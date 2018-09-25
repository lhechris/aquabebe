<?php
	
	function writeLink($text,$ref,$selected){
		$link = "<a href=\"";
		if (is_file(DOCUMENT_ROOT.WEB_REPOSITORY.$ref)) {
			$link .=WEB_REPOSITORY.$ref;
		}
		$link .= "\"";
		
		
		
		//SAND
		// ereg est deprecated
		// Ajout de @ pour ne pas avoir de message d'eereur
		//if((ereg($selected,$ref)) && (0==strpos($ref,$selected))) {
		
		/*if((preg_match($selected,$ref)) && (0==strpos($ref,$selected))) {
			$link .=  " class=\"selected\" ";
		}*/
		$link .= ">".$text."</a>";
		echo $link;
	}
	
	function writeLastLink($text,$ref){
		$link = "<a href=\"";
		if (is_file(DOCUMENT_ROOT."$ref")) {
			$link .=REPOSITORY.$ref;
		}
		$link .= "\" class=\"last\">".$text."</a>";
		echo $link;
	}

	
function _startPage($specific_css,$diapo) {
	
	// Définition des traces
	require_once($_SERVER["DOCUMENT_ROOT"]."/script/trace.php");
	
	//definition de la langue
	if (isset($_GET['lang'])) {
		$_SESSION["LANG"]=$_GET['lang'];
	} else if(!isset($_SESSION["LANG"])){
		if(isset($HTTP_ACCEPT_LANGUAGE)){
			echo $HTTP_ACCEPT_LANGUAGE;
			$Langue = explode(",",$_server[HTTP_ACCEPT_LANGUAGE] );
			$Langue = strtolower(substr(chop($Langue[0]),0,2)); 
			$_SESSION["LANG"]=$Langue;
		} else {
			$_SESSION["LANG"]="fr";
		}
	}
	//chargement du fichier de langue pour la structure des pages
	require_once(DOCUMENT_ROOT."/lang/".$_SESSION["LANG"]."/structure_".$_SESSION["LANG"].".php");
	
	//Définition du nom de fichier de langue de la page et chargement
	$fichier="";
	$scriptName=substr(getenv("SCRIPT_NAME"),strlen(WEB_REPOSITORY));
	$dir_tab = explode("/",$scriptName);
	$last_index = count($dir_tab)-1;
	for($i=1;$i<$last_index;$i++){
		$fichier.=$dir_tab[$i]."_";
	}
	$file_name = explode(".",$dir_tab[$last_index]);
	$fichier.=$file_name[0];
	require_once(DOCUMENT_ROOT."/lang/".$_SESSION["LANG"]."/".$fichier."_".$_SESSION["LANG"].".php");
	
	//Definition du rÃ©pertoire dans lequel on se trouve.
	$selected = "/".$dir_tab[1];
	
	//ecriture du head
    echo "<head>
  <meta charset=\"utf-8\" />
  <title>"._TITLE."</title>
  <link rel=\"SHORTCUT ICON\" href=\"/images/favicon.ico\" />
  <link href=\"".REPOSITORY."/css/css.css\" rel=\"stylesheet\" media=\"all\" type=\"text/css\" />
  <link href=\"/css/menu.css\" rel=\"stylesheet\" media=\"all\" type=\"text/css\" />\n";
        if ($diapo==true) {
            echo "  <link href=\"/css/camera.css\" rel=\"stylesheet\" media=\"all\" type=\"text/css\" />\n";
        }
	if (! empty($specific_css)){
            foreach ($specific_css as $css) {
                echo"  <link href=\"".REPOSITORY."/css/$css\" rel=\"stylesheet\" media=\"all\" type=\"text/css\" />\n";
		}
	}
	
	echo "</head>\n";

	//ecriture du body : header + menu + ouverture du main
	echo "<body>\n";
    if ($diapo==true) {
        echo "  <script type=\"text/javascript\" src=\"/js/jquery.min.js\"></script>\n";
        echo "  <script type=\"text/javascript\" src=\"/js/jquery.easing.1.3.js\"></script>\n";
        echo "  <script type=\"text/javascript\" src=\"/js/jquery.mobile.customized.min.js\"></script>\n";
        echo "  <script type=\"text/javascript\" src=\"/js/camera.min.js\"></script>\n";
        echo "  <script>\n";
        echo "	jQuery(function(){\n";
        echo "		jQuery('#camera_wrap_1').camera({\n";
        echo "			thumbnails: true,\n";
        echo "          fx:'simpleFade',\n";
        echo "          loader:'none'\n";
        echo "		});\n";
        echo "	});\n";
        echo "   </script> \n"; 
   }


    echo "  <div id=\"page\">\n";
    include(DOCUMENT_ROOT."/script/header.php"); 
	
//	include (DOCUMENT_ROOT."/script/menu.php"); 
	
    echo "    <section id=\"corp\">\n";
	echo "      <div id=\"main\">\n";
}


function startPage($specific_css) {
    _startPage($specific_css,false);
}
		  

function _stopPage($diapo){
       
   echo "      </div><!--main-->\n";//main
   echo "      <section id=\"cote\">\n";
   if ($diapo==true) {
       echo "        <div class=\"coteaside\">\n";
       echo "           <aside class=\"diapo\">\n";
       echo "             <div class=\"camera_wrap camera_azure_skin\" id=\"camera_wrap_1\">\n";
       echo "               <div data-src=\"/images/diapo/BBsousEau.jpg\">\n";
       echo "                 <div class=\"camera_caption fadeFromBottom\">bebe sous l'eau</div>\n";
       echo "               </div>\n";
       echo "               <div data-src=\"/images/diapo/BB-1.jpg\"></div>\n";
       echo "               <div data-src=\"/images/diapo/20110401_CoinEscalier.jpg\"></div>\n";
       echo "               <div data-src=\"/images/diapo/lesGrands-1.jpg\"></div>\n";
       echo "               <div data-src=\"/images/diapo/lesGrands-2.jpg\"></div>\n";
       echo "               <div data-src=\"/images/diapo/lesGrands-3.jpg\"></div>\n";
       echo "             </div>\n";
       echo "           </aside>\n";
       echo "         </div>\n";
   }
   echo "        <div class=\"coteaside\">\n";
   echo "           <aside>\n";
   echo "             <p>Espace abonn&eacute;s</p>\n";
   include (DOCUMENT_ROOT."/script/menu_abo.php"); 
   echo "           </aside>\n";
   echo "        </div><!--coteaside-->\n";
   echo "      </section><!--cote-->\n";
   echo "    </section><!--corp-->";

    include (DOCUMENT_ROOT."/script/footer.php");
	echo "  </div><!--page-->";//page
    echo "</body>";
  
}

function stopPage(){
    _stopPage(false);
}


?>
