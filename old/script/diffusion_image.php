<?php
	define("_AUTORISATION",1);
	define("_REFUS",2);
	

	function writeAutorisation(&$values,$row,$errors)
  {
		$name=$row['name'];
		$class="";
    
		if(isset($errors[$name]))
    {
			$class="class=\"error\"";
		}
		
    $oldValue = "";
    if (isset($_POST[$name]))
    {
      $oldValue = $_POST[$name];
    }
		
		//autorisation
		if($oldValue==_AUTORISATION)
    {
			$select=" checked=\"checked\"";
		} 
    else 
    {
			$select="";
		}
    
		$values[$name] .= "<br/><input "
                    .$class
                    .$select
                    ." type=\"radio\" name=\""
                    .$name
                    ."\" value=\""
                    ._AUTORISATION."\">\n"
                    .htmlentities("Je reconnais et accepte que les images puissent être utilisées pour support pouvant assurer 
                                  la promotion de l'association Aqua-bébé et plus particulièrement sur les plaquettes et le site 
                                  web de l'association (http://www.aquabebe.fr)",null,"utf-8",false)
                    ."\n"
                    ."</input>\n";
						
		//refus
		if($oldValue==_REFUS)
    {
			$select=" checked=\"checked\"";
		} 
    else 
    {
			$select="";
		}				
		
    $values[$name] .= "<br/><input ".$class.$select." type=\"radio\" name=\"".$name."\" value=\""._REFUS."\">\n"
                    .htmlentities("Je refuse que les images puissent être utilisées pour support pouvant assurer la promotion 
                                  de l'association Aqua-Bébé et le cas échéant, elles seront rendues floues afin que l'identification 
                                  soit impossible.",null,"utf-8",false)."\n"
                    ."</input>\n";
	}
	
	function verify_writeAutorisation($row)
  {
		$value = $_POST[$row['name']];
		if (($value!=_AUTORISATION) && ($value!=_REFUS)) 
    {
				return htmlentities("Vous devez accepter ou refuser la diffusion d'image.",null, null,false);
		}
		return null;
	}

?>
