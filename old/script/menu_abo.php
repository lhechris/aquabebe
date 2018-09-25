<!-- Menu haut de page -->	
	<ul>
		<?php 
		    $selected="";
			echo "<li>";writeLink("Inscrire un enfant","/inscription/index.php",$selected);echo "</li>";
            echo "<li>";writeLink("Planning","/doc-pub/AQUABEBE-Planning.pdf",$selected);echo "</li>";
			if(isset($_SESSION["ADMIN"])) 
            {
				echo "<li>";writeLink("Administratif","/administration/index.php",$selected); echo "</li>";
				echo "<li>";writeLink("Valider une inscription","/validation/index.php",$selected);echo "</li>"; 
				// writeLink("Offre d'emploi","/offre_emploi/index.php",$selected);
				echo "<li>";writeLastLink("Déconnexion","/administration/deconnexion.php"); echo "</li>";
			} else { 
                // writeLink("Offre d'emploi","/offre_emploi/index.php",$selected); 
                echo "<li>";writeLastLink("Réservé Administration","/administration/connexion.php");echo "</li>"; 
            }
		?>
      </ul>		
	 
<!-- Fin du menu haut de page -->
