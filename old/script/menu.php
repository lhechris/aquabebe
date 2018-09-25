<!-- Menu haut de page -->	
	<ul>
		<?php 
			echo "<li>";writeLink("Accueil","/index.php",$selected);echo "</li>"; 
            echo "<li>";writeLink("Accès","/acces/index.php",$selected); echo "</li>";
			echo "<li>";writeLink("Tarifs","/tarifs/index.php",$selected);echo "</li>";
			echo "<li>";writeLink("FAQ","/faq/index.php",$selected);echo "</li>";
			echo "<li>";writeLink("Créneaux","/creneaux/index.php",$selected);echo "</li>"; 
		?>
      </ul>		
	 
<!-- Fin du menu haut de page -->