<?php
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
	
  // ------------------------------------------------------------------------------------------------------------------------------
  // executeQuery()
  // ------------------------------------------------------------------------------------------------------------------------------
	function executeQuery($query,$action=null,$val_result=null) 
  {
		//echo "<br/>DEBUG : => executeQuery()";
    //echo "<br/>DEBUG : query : ";
    //var_dump($query);
		
		if (! isset($_SESSION["CONNECTED"]) || 0==$_SESSION["CONNECTED"]) 
    {
			$con = mysql_connect(HOST,USER,PASSWORD);
			if (!$con) 
      {
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db(DATABASE, $con);
			$_SESSION["CONNECTED"] = 1;
		} 
    else 
    {
			$_SESSION["CONNECTED"] ++;
		}
		
		$result = mysql_query($query);
		//$result = mysql_query($query) or die('Erreur SQL !<br/>'.$query.'<br/>'.mysql_error());
		
		if((null != $result) && is_resource($result)) 
    {
			while($row = mysql_fetch_array($result)) 
      {
        //echo "<br/>DEBUG : hhhhhhhhhhhhhhhhhhhhhhh";
        //var_dump($row);	
        $val_result=$action($row,$val_result);
        //echo "<br/>val_result : $val_result";
			}

		}
		
		$_SESSION["CONNECTED"] --;
		if (0==$_SESSION["CONNECTED"]) 
    {
			mysql_close($con);
		}
		
		return $val_result;
	}
  
  // ------------------------------------------------------------------------------------------------------------------------------
  // getCreneaux()
  // ------------------------------------------------------------------------------------------------------------------------------
	function getCreneaux($action,  $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
    $query = "SELECT creneau.ID, creneau.capacite, creneau.jour, creneau.heure, creneau.age, creneau.naissance_min, creneau.naissance_max, 
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
    // echo "var saison = $saison";
    //echo "query = $query ";

		return executeQuery($query,$action,$result);
	}
	
	function getCreneau($id,$action,  $result=null)
  {
		$query = "SELECT creneau.ID, creneau.capacite, creneau.jour, creneau.heure, creneau.age, creneau.naissance_min, creneau.naissance_max, 
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
	
	function getFreeCreneaux($naissance,$action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$naissance = translateDate($naissance);

		$query = "SELECT creneau.ID, creneau.capacite, creneau.jour, creneau.heure, creneau.age, creneau.naissance_min, creneau.naissance_max, creneau.capacite-count(DISTINCT inscription.ID)-count(DISTINCT preinscription.ID_inscription) as disponible, count(DISTINCT preinscription.ID_inscription) as attente, creneau.capacite>count(DISTINCT inscription.ID) as valide
		FROM  creneau 
			LEFT JOIN inscription ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
			LEFT JOIN preinscription ON creneau.ID = preinscription.ID_creneau AND preinscription.reservation=true AND preinscription.ID_inscription in (SELECT ID from inscription WHERE ( date_max>=NOW() OR paiement = true )AND ID_creneau IS NULL)
		WHERE creneau.saison = ".$saison." 
		AND creneau.naissance_min<=".$naissance."
		AND creneau.naissance_max>=".$naissance."
		GROUP BY creneau.id;";
		
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
                      creneau.jour, creneau.heure
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
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, inscription.date_max, personne.prenom, personne.nom, personne.naissance, inscription.paiement as paiement_recu, inscription.ID_creneau IS NOT NULL as creneau_affecte, creneau.jour, creneau.heure
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.date_max < NOW()
		AND (inscription.paiement IS NULL OR inscription.paiement = 0)
		ORDER BY inscription.date_max;";

		return executeQuery($query,$action,$result);
	}
	
	function getInscriptionsValides($action, $result=null, $saison=SAISON)
  {
    // ajout de simples quotes indispensables pour la query
    $saison = "'".$saison."'";
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, personne.prenom, personne.nom, personne.naissance, 
                      inscription.ID_creneau, creneau.jour, creneau.heure, inscription.certificat_medical
		FROM  personne, inscription
			LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau
		WHERE inscription.ID_enfant = personne.ID
		AND inscription.paiement IS NOT NULL
		AND creneau.saison = $saison
		ORDER BY personne.nom;";

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
    
		$query = "SELECT inscription.ID, inscription.ID_enfant, inscription.certificat_medical, inscription.paiement as paiement_recu, creneau.jour, creneau.heure, inscription.ID_creneau IS NOT NULL as creneau_affecte
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
		$query = "SELECT preinscription.ID_inscription,  preinscription.ID_creneau, preinscription.choix, creneau.jour, creneau.heure, creneau.capacite>count(DISTINCT inscription.ID) as disponible 
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
		$query = "SELECT inscription.ID as ID, inscription.ID_enfant as ID_enfant, paiement.payeur as payeur, paiement.montant as montant, paiement.moyen as moyen , creneau.jour as jour, creneau.heure as heure
			FROM inscription
				LEFT JOIN creneau ON creneau.ID = inscription.ID_creneau AND inscription.ID_creneau IS NOT NULL
				LEFT JOIN paiement ON paiement.ID = inscription.paiement
			WHERE inscription.ID = $id;";
		
		return executeQuery($query,$action,$result);
	}
	
  // -------------------------------------------------------------------------
  // setPaiement_ALICE() : 
  // -------------------------------------------------------------------------
	function setPaiement_ALICE($id,$action=null,  $result=null)
  {
    echo "DEBUG => Début de setPaiement_ALICE()";
		echo "DEBUG => ici";
		//cas du paiement normal : set paiement à true et date de paiment à aujourdhui
		$query="UPDATE inscription 
			SET  paiement=true, paiement_date=NOW() 
			WHERE ID=$id
			AND date_max >= NOW();";
		$result = executeQuery($query);
		//$row=mysql_
		//si pas de mise à jour => paiement tardif
		if (! $result) 
    {
			//cas du paiement tardif : récupère la valeur max des date_max de paiement (associé à l'id de l'inscription à modifier) 
				//En callback, appelle setPaiementTardif => set paiement à true et date de paiment à aujourdhui et la date_max au maximum+1 des dates max des inscriptions actuelles
			$query="SELECT $id as id, max(date_max) as max FROM inscription;";
			$result = executeQuery($query,"setPaiementTardif");
		}
		
		if (! is_null($action)) 
    {
			return $action($id,$result);
		}
	}
	
  // ---------------------------------------------------------------------------------------------------------------
  // setPaiement() : NEW
  // on part de setPaiement() et on essaie de rajouter les infos de validation_paiement.php
  // ----------------------------------------------------------------------------------------------------------------
	//function setPaiement$id_inscription,$action=null,  $result=null)
  function setPaiement($row,$action=null,  $result=null)
  {
		//echo "<br/>DEBUG => setPaiement()";
    
    $id_inscription = $row['ID_inscription'];
    $payeur         = $row['payeur'];
    $montant        = $row['montant'];
    $moyen          = $row['moyen'];
    $mois           = $row['mois'];
    $remarques      = $row['remarques'];
    
    $id_paiement    = 0;
    
    //echo "<br/>DEBUG : ";
    //var_dump($row);
    		
    // màj de la table Paiement
		$query="INSERT INTO paiement 
            SET  payeur='".$payeur."', 
                  montant='".$montant."',
                  moyen='".$moyen."',
                  mois='".$moyen."',
                  remarques='".$remarques."';";
		$result = executeQuery($query);
    
    //echo "<br/>DEBUG : 1ère query : $query <br/>    result : $result";
 
 
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
  // cas du paiement normal : set paiement à true et date de paiment à aujourdhui
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
	
	
	

?>