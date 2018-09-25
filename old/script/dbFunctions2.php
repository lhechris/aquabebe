<?php
	require_once($_SERVER["DOCUMENT_ROOT"]."/script/trace.php");
  
	$_SESSION["CONNECTED"]=0;
	define("ALL", null);
	
	function pushIn($val,$result)
  {
		array_push($result,$val);
		return $result;
	}
	
	function putIn($val,$result)
  {
		$result[$val['cle']]=$val['valeur'];
		return $result;
	}
	
	function concat($val,$result){
		if(is_null($result)){
			$result = $val[0];
		} else {
			$result .= ", ".$val[0];
		}
		return $result;
	}
	
	function translateDate($naissance) 
  {
    // en V1.0, utilisation de split() mais fonction deprecated
		$tab=explode("/",$naissance);
		if(sizeof($tab)==3)
    {
			$naissance="'".$tab[2]."-".$tab[1]."-".$tab[0]."'";
		}
		if("'"!= substr($naissance,0,1))
    {
			$naissance="'".$naissance."'";
		}
		return $naissance;
	}
	
	function translateBinary ($val,$result){
  		if($val[0]){
  			$result="oui";
  		}
  		else
  		{
  			$result="non";
  		}
  		return $result;
  	}
	
  // ------------------------------------------------------------------------------------------------------------------------------
  // executeQuery()
  // ------------------------------------------------------------------------------------------------------------------------------
	function executeQuery($query,$action=null,$val_result=null) 
  {
		//trace("-> executeQuery()");
    //trace("  query = $query");
    //var_dump($query);    
		
		//if (! isset($_SESSION["CONNECTED"]) || 0==$_SESSION["CONNECTED"]) 
    {
			/*$con = mysql_connect(HOST,USER,PASSWORD);
			if (!$con) 
      {
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db(DATABASE, $con);*/
			$dsn = 'mysql:host=localhost;dbname=aquabebe_db;charset=utf8';
			$login = 'aquabebe';
			$password = 'aquabebe';
			$pdo = new PDO( $dsn, $login, $password );  
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

			//$_SESSION["CONNECTED"] = 1;
		} 
    //else 
    {
			//$_SESSION["CONNECTED"] ++;
		}
		
/*		$result = mysql_query($query);
    trace(mysql_error());
		//$result = mysql_query($query) or die('Erreur SQL !<br/>'.$query.'<br/>'.mysql_error());
		
		if((null != $result) && is_resource($result)) 
    {
			while($row = mysql_fetch_array($result)) 
      {
        //trace("  $row = ".$row);
        $keylist=array("prenom","nom","profession","adresse","commune");
        foreach ($keylist as $key) {
            if (array_key_exists($key,$row)) {
                $row[$key]=utf8_encode($row[$key]);
            }
        }
        $val_result=$action($row,$val_result);
        //trace( "  val_result : ".$val_result);
			}
		}*/

		try {
				$stmt=$pdo->query($query);
				$result=$stmt->fetchAll();
		}catch(PDOException  $e ){
				trace("Error ".$query."\n  ".$e);
				return "";            
		}
		foreach($result as $row) 
		{
			//trace("  $row = ".$row);
			$keylist=array("prenom","nom","profession","adresse","commune");
			foreach ($keylist as $key) {
					if (array_key_exists($key,$row)) {
							$row[$key]=utf8_encode($row[$key]);
					}
			}
			$val_result=$action($row,$val_result);
		}

		
		$_SESSION["CONNECTED"] --;
		if (0==$_SESSION["CONNECTED"]) 
    {
			//mysql_close($con);
		}
		
		//trace("<- executeQuery()");
		return $val_result;
	}
  
  // ------------------------------------------------------------------------------------------------------------------------------
  // getCreneaux(action, result, saison)
  // ------------------------------------------------------------------------------------------------------------------------------
	function getCreneaux($action,  $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
    $query = "SELECT creneau.ID, creneau.capacite, creneau.jour, creneau.heure, creneau.lieu, 
					 creneau.age, creneau.pour_fratrie, creneau.naissance_min, creneau.naissance_max, 
					 creneau.nb_mois_mini,
                      creneau.capacite-count(DISTINCT inscription.ID)-count(DISTINCT preinscription.ID_inscription) as disponible, 
                      count(DISTINCT preinscription.ID_inscription) as attente 
		FROM  creneau 
			LEFT JOIN inscription ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
			LEFT JOIN preinscription ON creneau.ID = preinscription.ID_creneau 
                  AND preinscription.reservation=true 
                  AND preinscription.ID_inscription in (SELECT ID from inscription WHERE ( date_max>=NOW() OR paiement = true )
                  AND ID_creneau IS NULL)
		WHERE creneau.saison = ".$saison." 
		AND creneau.heure IS NOT NULL
		GROUP BY creneau.ID";
    
		// DEBUG SVG
    trace("saison = $saison");
    trace("query = $query ");

		return executeQuery($query,$action,$result);
	}
	
  // ------------------------------------------------------------------------------------------------------------------------------
  // getCreneaux(creneau_id,action, result)
  // ------------------------------------------------------------------------------------------------------------------------------
	function getCreneau($id,$action,  $result=null)
  {
		$query = "SELECT creneau.ID, creneau.capacite, creneau.jour, creneau.heure, creneau.lieu, 
						 creneau.age, creneau.naissance_min, creneau.naissance_max, 
                      creneau.capacite-count(DISTINCT inscription.ID)-count(DISTINCT preinscription.ID_inscription) as disponible, 
                      count(DISTINCT preinscription.ID_inscription) as attente 
		FROM  creneau 
			LEFT JOIN inscription ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
			LEFT JOIN preinscription ON creneau.ID = preinscription.ID_creneau 
                AND preinscription.reservation=true 
                AND preinscription.ID_inscription in (SELECT ID from inscription WHERE ( date_max>=NOW() OR paiement = true )
                AND ID_creneau IS NULL)
		WHERE creneau.ID = $id 
		GROUP BY creneau.ID";

		return executeQuery($query,$action,$result);
	}
	
	function getInscrits($id,$action, $result=null)
  {
		$query = "SELECT DISTINCT inscription.ID_enfant as ID, personne.prenom, personne.nom, personne.naissance, inscription.ID_creneau IS NOT NULL as valide
		FROM 	inscription, personne 
		WHERE 	inscription.ID_enfant = personne.ID
		AND (	inscription.ID_creneau = ".$id."
			OR  (	inscription.ID_creneau IS NULL
				AND inscription.date_max>=NOW()
				AND inscription.ID IN (SELECT preinscription.ID_inscription
									FROM 	preinscription
									WHERE 	preinscription.reservation = true
									AND 	preinscription.ID_creneau = ".$id.") )
			);";
		return executeQuery($query,$action,$result);
	}
	
  // SVG : essai de nouvelle fonction (bof, marche pas)
  // getInscritsSimple : sansn utiliser d'action
  // retourne un tableau contenant l'ID des enfants inscrits au créneau donné en paramètre
  // ----------------------------------------------------------------------------------------------------------------
	function getInscritsSimple($id, $result_get=null)
  {
		$query = "SELECT DISTINCT inscription.ID_enfant as ID, personne.prenom, personne.nom, personne.naissance, inscription.ID_creneau IS NOT NULL as valide
		FROM 	inscription, personne 
		WHERE 	inscription.ID_enfant = personne.ID
		AND (	inscription.ID_creneau = ".$id."
			OR  (	inscription.ID_creneau IS NULL
				AND inscription.date_max>=NOW()
				AND inscription.ID IN (SELECT preinscription.ID_inscription
									FROM 	preinscription
									WHERE 	preinscription.reservation = true
									AND 	preinscription.ID_creneau = ".$id.") )
			);";
		
    $result = mysql_query($query);
    
    // $row[0] = ID de l'enfant
    while($row = mysql_fetch_row($result))
    {
      trace(" nnn : ".$row[0]);
      array_push($result_get, $row[0]);
    }
    
    return $result_get;
	}
	
	function getFreeCreneaux($naissance,$action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$naissance = translateDate($naissance);

		$query = "SELECT creneau.ID, creneau.capacite, creneau.jour, creneau.heure, creneau.lieu, creneau.age, 
						 creneau.pour_fratrie, creneau.naissance_min, creneau.naissance_max, 
						 creneau.capacite-count(DISTINCT inscription.ID)-count(DISTINCT preinscription.ID_inscription) as disponible, 
						 count(DISTINCT preinscription.ID_inscription) as attente, creneau.capacite>count(DISTINCT inscription.ID) as valide
		FROM  creneau 
			LEFT JOIN inscription ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
			LEFT JOIN preinscription ON creneau.ID = preinscription.ID_creneau AND preinscription.reservation=true AND preinscription.ID_inscription in (SELECT ID from inscription WHERE ( date_max>=NOW() OR paiement = true )AND ID_creneau IS NULL)
		WHERE creneau.saison = ".$saison." 
		AND creneau.naissance_min<=".$naissance."
		AND creneau.naissance_max>=".$naissance."
		GROUP BY creneau.id;";
		trace($query);
//		AND (creneau.naissance_max>=".$naissance." OR date_sub(now(),INTERVAL creneau.nb_mois_mini month) >=".$naissance.")

		return executeQuery($query,$action,$result);
	}
	
	function isCBEnable($naissance, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$naissance = translateDate($naissance);
		$query = "SELECT creneau.capacite-count(DISTINCT inscription.ID)-count(preinscription.reservation)>0 as enable
		FROM  creneau 
			LEFT JOIN inscription ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
			LEFT JOIN preinscription ON creneau.ID = preinscription.ID_creneau AND preinscription.reservation=true  
		WHERE creneau.saison = ".$saison." 
		AND creneau.naissance_min<=".$naissance."
		AND creneau.naissance_max>=".$naissance."
		GROUP BY creneau.id;";

		$creneaux =executeQuery($query,"pushIn",array());
		
		foreach ($creneaux as $creneau)
    {
			if($creneau["enable"]) 
      {
				return true;
			}
		}
		return false;

	}
	
	function getInscriptionsEnCours($action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, inscription.date_max, personne.prenom, personne.nom, 
                      personne.naissance, inscription.paiement as paiement_recu, inscription.ID_creneau IS NOT NULL as creneau_affecte, 
                      creneau.jour, creneau.heure, creneau.lieu
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND ( inscription.date_max>=NOW()
			OR	inscription.paiement>0 )
		AND inscription.ID_creneau IS NULL
		ORDER BY inscription.date_max;";

		return executeQuery($query,$action,$result);
	}
	
	function getInscriptionsHorsDelai($action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, inscription.date_max, personne.prenom, personne.nom, personne.naissance, 
						inscription.paiement as paiement_recu, inscription.ID_creneau IS NOT NULL as creneau_affecte, creneau.jour, creneau.heure, creneau.lieu
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.date_max < NOW()
		AND (inscription.paiement IS NULL OR inscription.paiement = 0)
		ORDER BY inscription.date_max;";

		return executeQuery($query,$action,$result);
	}
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // getInscriptionsValides()
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  
	function getInscriptionsValides($action, $result=null, $saison=SAISON)
  {
    trace("-> getInscriptionsValides()");
    trace("  saison = $saison");
    
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, personne.prenom, personne.nom, personne.naissance, 
						inscription.ID_creneau, creneau.jour, creneau.heure, creneau.lieu, 
						inscription.certificat_medical, inscription.vaccins, inscription.facture_remise
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.paiement IS NOT NULL
		AND creneau.saison = $saison
		ORDER BY personne.nom;";

		return executeQuery($query,$action,$result);
	}
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // getInscriptionsValidesByCreneau() : liste les inscriptions validées et les trie par créneau
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  
	function getInscriptionsValidesByCreneau($action, $result=null, $saison=SAISON)
  {
    trace("-> getInscriptionsValidesByCreneau()");
    trace("  saison = $saison");
    
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, personne.prenom, personne.nom, personne.naissance, 
						inscription.ID_creneau, creneau.jour, creneau.heure, creneau.lieu, 
						inscription.certificat_medical, inscription.vaccins, inscription.facture_remise
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.paiement IS NOT NULL
		AND creneau.saison = $saison
		ORDER BY creneau.jour, creneau.heure, personne.nom;";

		return executeQuery($query,$action,$result);
	}
	
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  // getPaiementsValides() : infos sur les paiements reçus
  // ----------------------------------------------------------------------------------------------------------------------------------------------
  
	function getPaiementsValides($action, $result=null, $saison=SAISON)
  {
    trace("-> getPaiementsValides()");
    trace("  saison = $saison");
    
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, personne.prenom, personne.nom, 
                      inscription.ID_creneau, creneau.jour, creneau.heure, creneau.lieu, 
                      paiement.id, paiement.payeur, paiement.montant, paiement.remarques
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
      LEFT JOIN paiement on inscription.paiement = paiement.id
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.paiement IS NOT NULL
		AND creneau.saison = $saison
		ORDER BY creneau.jour, creneau.heure, personne.nom;";
    
    /*
		$query = "SELECT inscription.ID, inscription.ID_enfant, personne.prenom, personne.nom,  
                      inscription.ID_creneau, creneau.jour, creneau.heure, 
                      paiement.id, paiement.payeur, paiement.montant, paiement.remarques
		FROM  personne, inscription, paiement
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.paiement IS NOT NULL
    AND inscription.paiement = paiement.id
		AND creneau.saison = $saison
		ORDER BY personne.nom;";
*/

		return executeQuery($query,$action,$result);
	}
	
	//à supprimer et appeler getInscriptionByEnfant
	function getCertificatMedical($id,$action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, inscription.certificat_medical, 
		FROM  inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = $id
		AND creneau.saison = $saison;";

		return executeQuery($query,$action,$result);
	}
	
	function getInscriptionByEnfant($id,$action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, inscription.certificat_medical, inscription.paiement as paiement_recu, 
						creneau.jour, creneau.heure, creneau.lieu, 
						inscription.ID_creneau IS NOT NULL as creneau_affecte
		FROM  inscription
			LEFT OUTER JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = $id
		AND creneau.saison = $saison;";

		return executeQuery($query,$action,$result);
	}
	
	function getEnfantsBySaison($action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT personne.prenom, personne.nom, personne.adresse, personne.cp, personne.commune
		FROM personne
			RIGHT JOIN inscription ON personne.ID = inscription.ID_enfant AND inscription.ID_creneau in (SELECT ID FROM creneau WHERE creneau.saison = $saison)
		WHERE personne.type = 'enfant'";
		
		return executeQuery($query,$action,$result);
	}
	
	function getPreinscriptions($ID_inscription,$action,  $result=null) 
  {
		$query = "SELECT preinscription.ID_inscription,  preinscription.ID_creneau, preinscription.choix, 
						creneau.jour, creneau.heure, creneau.lieu, 
						creneau.capacite>count(DISTINCT inscription.ID) as disponible 
		FROM preinscription 
			LEFT JOIN creneau ON creneau.ID = preinscription.ID_creneau
			LEFT JOIN inscription ON inscription.ID_creneau = preinscription.ID_creneau
		WHERE preinscription.ID_inscription = ".$ID_inscription."
		GROUP BY preinscription.ID_inscription,  preinscription.ID_creneau, preinscription.choix
		ORDER BY choix";
		
		return executeQuery($query,$action,$result);
	}
	
	function getEnfantByID($id,$action,  $result=null)
  {
		$query = "SELECT *  
		FROM personne
		WHERE ID IN (SELECT enfant.ID_personne
						FROM enfant
							WHERE ID_enfant = $id)
		ORDER BY ID;";
		
		return executeQuery($query,$action,$result);
	}
	function getPersonneEnfantByID($id,$action,  $result=null)
  {
		$query = "SELECT *  
		FROM personne
		WHERE ID IN (SELECT enfant.ID_personne
						FROM enfant
							WHERE ID_enfant = $id)
		AND type LIKE 'enfant'
		ORDER BY ID;";
		
		return executeQuery($query,$action,$result);
	}
	
	function getReservations($ID_creneau=ALL,$action,  $result=null, $saison=SAISON) 
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
		$creneau = "";
    
    if(ALL != $ID_creneau)
    {
			$creneau = " AND creneau.ID = $ID_creneau ";
		}	
		$query = "SELECT creneau.ID as cle, creneau.capacite-count(DISTINCT inscription.ID)-count(DISTINCT preinscription.ID_inscription)>0 as valeur
		FROM  creneau 
			LEFT JOIN inscription ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
			LEFT JOIN preinscription ON creneau.ID = preinscription.ID_creneau AND preinscription.reservation=true AND preinscription.ID_inscription in (SELECT ID from inscription WHERE ( date_max>=NOW() OR paiement = true )AND ID_creneau IS NULL)
		WHERE creneau.saison = ".$saison
		.$creneau."
		GROUP BY creneau.ID;";
		
		return executeQuery($query,$action,$result);
	}
	
	function getInscriptionById($id,$action,  $result=null)
  {
		$query = "SELECT *  
		FROM inscription
		WHERE ID = $id;";
		
		return executeQuery($query,$action,$result);
	}
	
	function getPaiementInscriptionById($id,$action,  $result=null)
  {
		$query = "SELECT inscription.ID as ID, inscription.ID_enfant as ID_enfant, 
						paiement.payeur as payeur, paiement.montant as montant, paiement.moyen as moyen , 
						creneau.jour as jour, creneau.heure as heure, creneau.lieu as lieu
			FROM inscription
				LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
				LEFT JOIN paiement ON paiement.ID = inscription.paiement
			WHERE inscription.ID = $id;";
		
		return executeQuery($query,$action,$result);
	}
	
  // ---------------------------------------------------------------------------------------------------------------
  // setPaiement() : prise en compte des infos de validation_paiement.php
  // ----------------------------------------------------------------------------------------------------------------
	//function setPaiement$id_inscription,$action=null,  $result=null)
  function setPaiement($row,$action=null,  $result=null)
  {
		trace("-> setPaiement()");
    
    $id_inscription = $row['ID_inscription'];
    $payeur         = $row['payeur'];
    $montant        = $row['montant'];
    $moyen          = $row['moyen'];
    $mois           = $row['mois'];
    $remarques      = $row['remarques'];
    
    $id_paiement    = 0;
    
    //trace("  row = $row");
    		
    // màj de la table Paiement
		$query="INSERT INTO paiement 
            SET  payeur='".$payeur."', 
                  montant='".$montant."',
                  moyen='".$moyen."',
                  mois='".$mois."',
                  remarques='".$remarques."';";
		$result = executeQuery($query);
        
    trace("  maj table paiement");
    trace("  query : $query");
    trace("  result : $result");
 
 
    // récupération de l'id du paiement inséré dans la table paiement
    $query = "SELECT MAX(id) FROM paiement"; 
    $id_paiement = executeQuery($query,"qetQueryId");
    
    //echo "<br/>DEBUG : query : $query <br/>  ";
    //echo "<br/>DEBUG : id = $id_paiement";
    
		// cas du paiement normal : màj de la table Inscription
    // set paiement à true et date de paiement à aujourdhui
		$query="UPDATE inscription 
            SET  paiement='".$id_paiement."', paiement_date=NOW() 
            WHERE ID='".$id_inscription."'
            AND date_max >= NOW();";
		$result = executeQuery($query);
    //echo "<br/>DEBUG : 3ème query : $query <br/>    result : $result";
    
    
		//$row=mysql_
		//si pas de mise à jour => paiement tardif
		if (! $result) 
    {
			//cas du paiement tardif : récupère la valeur max des date_max de paiement (associé à l'id de l'inscription à modifier) 
				//En callback, appelle setPaiementTardif => set paiement à true et date de paiment à aujourdhui et la date_max au maximum+1 des dates max des inscriptions actuelles
			$query="SELECT $id_inscription as id, max(date_max) as max FROM inscription;";
			$result = executeQuery($query,"setPaiementTardif",$id_paiement);
      //echo "<br/>DEBUG : 4ème query (si paiement tardif): $query <br/>    result : $result";
		}

    //trace("<- setPaiement()");
		if (! is_null($action)) 
    {
			return $action($id_inscription,$result);
		}
	}

  // -------------------------------------------------------------------------
  // qetQueryId() : 
  // -------------------------------------------------------------------------
	function qetQueryId($row)
  {
		//echo "<br/>DEBUG : =>gggggggggggggggggggggggggggggg qetQueryId()";
    //var_dump($row);
    //echo "<br/> DEBUG : row[0] : $row[0]";
		return $row[0];
	}
	
  // -------------------------------------------------------------------------
  // setPaiementTardif() : 
  // -------------------------------------------------------------------------
	function setPaiementTardif($row, $id_paiement)
  {
		//echo "<br/>DEBUG : => setPaiementTardif()";
        
    $query="UPDATE inscription 
			SET  paiement=".$id_paiement.", paiement_date=NOW() ,date_max=ADDTIME('".$row['max']."','00:00:01')
			WHERE ID=".$row['id']."
			AND date_max < NOW();";
		
		return executeQuery($query);
	}
	
  // ---------------------------------------------------------------------------------------------------------
  // setCreneau() : 
  // met à jour l'inscription identifiée avec le numéro du créneau donné
	// le trigger supprime toutes les preinscriptions correspondant à cette inscription.
  // ---------------------------------------------------------------------------------------------------------
	function setCreneau($row,$action=null,  $result=null)
  {	
		//echo "<br/>DEBUG : => setCreneau()";
    
		$query="UPDATE inscription 
			SET  ID_creneau=".$row['ID_creneau']."
			WHERE ID=".$row['ID_inscription'].";";
			
		$result = executeQuery($query);
		
		if (! is_null($action)) 
    {
			return $action($row['ID_inscription'],$result);
		}
	}
	
  // ---------------------------------------------------------------------------------------------------------
  // setCertificatMedical) : 
  // ---------------------------------------------------------------------------------------------------------
	function setCertificatMedical($id,$action=null,  $result=null)
  {
		$query="UPDATE inscription 
            SET  certificat_medical=true
            WHERE ID=$id;";
		$result = executeQuery($query);
		
		if (! is_null($action)) 
    {
			return $action($id,$result);
		}
	}
	
  // ---------------------------------------------------------------------------------------------------------
	// setVaccins() : 
	// ---------------------------------------------------------------------------------------------------------
	function setVaccins($id,$action=null,  $result=null)
	{
		trace("setVaccins()");
    
		$query="UPDATE inscription 
            SET  vaccins=1
            WHERE ID=$id;";
		$result = executeQuery($query);
		
		if (! is_null($action)) 
		{
			return $action($id,$result);
		}
	}
	
	// ---------------------------------------------------------------------------------------------------------
	// setFactureRemise() : 
	// ---------------------------------------------------------------------------------------------------------
	function setFactureRemise($id,$action=null)
	{
		trace("setFactureRemise()");
    
		$query="UPDATE inscription 
				SET  facture_remise=1
				WHERE ID=$id;";
		$result = executeQuery($query);
	}
	
  //============================================================================
  // Sert pour la validation des parents p/r au changement de lieu
  //============================================================================
  //--------------------------------------------------------------------------
  // is_set_demenagement()
  // renvoie 1 si l'e-mail a déjà été utilisé
  // renvoie 0 si l'e-mail n'existe pas encore
  // règle : l'e-mail permet d'identifier l'adhérent.
  //--------------------------------------------------------------------------
  function is_set_demenagement($value)
  {
		$query = "SELECT COUNT( * )
		FROM  `demenagement` 
		WHERE  `mel` LIKE '$value';";
				
		return executeQuery($query,"concat"); //renvoie 0 ou 1
	}
	

?>
