<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php 
	
	$specific_css=array();
	$specific_css[0]="formulaire_contact.css";
	
	require_once("../constant.php");
	require_once(DOCUMENT_ROOT."/commun/structure.php");
	require_once(DOCUMENT_ROOT."/script/dbFunctions2.php");
	
	define("_TITLE","Envoi de message");
  
  //echo "saison = $saison";
	
	startPage($specific_css);
  
		
		$con = mysql_connect(HOST,USER,PASSWORD);
		if (!$con) 
    {
			die('Could not connect: ' . mysql_error());
		}
		
		
		$_SESSION["CONNECTED"] = 1;
		mysql_select_db(DATABASE, $con);
		
		
		//debut de la transaction
		mysql_query("START TRANSACTION");
    
  $query = "SELECT DISTINCT demenagement.reponse, demenagement.mel, personne.nom, personne.prenom, inscription_id
            FROM  demenagement, personne, inscription
            WHERE demenagement.inscription_id=inscription.ID
            AND inscription.ID_enfant=personne.ID
            ORDER BY reponse";
	$result = mysql_query($query);  
      
  // on affiche chaque valeur
      while($row = mysql_fetch_row($result))
      {
        if ($row[0]==0)
        {
          echo "<ul>réponse : NON; $row[2] $row[3]; e-mail : $row[1]; id : $row[4] </ul>";
        }
        else
        {
          echo "<ul>réponse : OUI; $row[2] $row[3]; e-mail : $row[1]; id : $row[4] </ul>";
        }
        trace("réponse : $row[0]; nom : $row[2]; prenom : $row[3]; e-mail : $row[1]; id : $row[4]");
      }
      
      
		mysql_close($con);
		$_SESSION["CONNECTED"] = 0;
    
    
 	stopPage();
?>

</html>
