<?php
function formatDate($date) 
  {
		$tab = explode("-",$date);
		if (sizeof ($tab)==3) 
    {
			return $tab[2]."/".$tab[1]."/".$tab[0];
		}
		$tab = explode("/",$date);
		if (sizeof ($tab)==3) 
    {
			return $tab[2]."-".$tab[1]."-".$tab[0];
		}
		return null;
    }



    function chiffre2lettre($v) 
    {
        if ($v<17){ 
            switch ($v){ 
                case 0: return 'Zero'; 
                case 1: return 'Un'; 
                case 2: return 'Deux'; 
                case 3: return 'Trois'; 
                case 4: return 'Quatre'; 
                case 5: return 'Cinq'; 
                case 6: return 'Six'; 
                case 7: return 'Sept'; 
                case 8: return 'Huit'; 
                case 9: return 'Neuf'; 
                case 10: return 'Dix'; 
                case 11: return 'Onze'; 
                case 12: return 'Douze'; 
                case 13: return 'Treize'; 
                case 14: return 'Quatorze'; 
                case 15: return 'Quinze'; 
                case 16: return 'Seize'; 
            } 
    
        } else if ($v<20){ 
            return 'dix-'.chiffre2lettre($v-10); 
    
        } else if ($v<100){ 
            if ($v%10==0){ 
                switch ($v){ 
                    case 20: return 'Vingt'; 
                    case 30: return 'Trente'; 
                    case 40: return 'Quarante'; 
                    case 50: return 'Cinquante'; 
                    case 60: return 'Soixante'; 
                    case 70: return 'Soixante-Dix'; 
                    case 80: return 'Quatre-Vingt'; 
                    case 90: return 'Quatre-Vingt-Dix'; 
                } 
    
            } elseif (substr($v, -1)==1){ 
                if( ((int)($v/10)*10)<70 ){ 
                return chiffre2lettre((int)($v/10)*10).'-et-un'; 
    
            } elseif ($v==71) { 
                return 'Soixante et onze'; 
    
            } elseif ($v==81) { 
                return 'Quatre vingt un'; 
    
            } elseif ($v==91) { 
                return 'Quatre vingt onze'; 
            } 
    
            } elseif ($v<70){ 
                return chiffre2lettre($v-$v%10).'-'.chiffre2lettre($v%10); 
            } elseif ($v<80){ 
                return chiffre2lettre(60).'-'.chiffre2lettre($v%20); 
            } else{ 
                return chiffre2lettre(80).'-'.chiffre2lettre($v%20); 
            } 
        } else if ($v==100){ 
            return 'Cent'; 
    
        } else if ($v%100==0){
            switch ($v){ 
                case 200: return 'Deux-Cents'; 
                case 300: return 'Trois-Cents'; 
                case 400: return 'Quatre-Cents'; 
                case 500: return 'Cinq-Cents'; 
                case 600: return 'Six-Cents'; 
                case 700: return 'Sept-Cents'; 
                case 800: return 'Huit-Cents'; 
                case 900: return 'Neuf-Cents'; 
            } 
         
        
        } else if ($v<200){ 
            return chiffre2lettre(100).' '.chiffre2lettre($v%100); 
        } else if ($v<1000){ 
            return chiffre2lettre((int)($v/100)).' '.chiffre2lettre(100).' '.chiffre2lettre($v%100); 
        } else if ($v==1000){ 
            return 'Mille'; 
        } else if ($v<2000){ 
            return chiffre2lettre(1000).' '.chiffre2lettre($v%1000).' '; 
        } else if ($v<1000000){ 
            return chiffre2lettre((int)($v/1000)).' '.chiffre2lettre(1000).' '.chiffre2lettre($v%1000); 
        } 
        
    }  
    
    function isregister() {
        return true;
        if (array_key_exists("register",$_SESSION)) {
            return $_SESSION["register"]=="oui";
        }else {
            return false;
        }

    }

    include_once("dao/daoConfig.php");

    function isinscriptionlocked() {
        $dao = new daoConfig();
        $ret=$dao->getBlockInscription();
        $lock=in_array(strtolower($ret),array("true","yes","oui","1","t","y","o",true,1));
        if ($lock) {
            if ((key_exists("inscription",$_SESSION)) && ($_SESSION["inscription"]=="oui")) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

?>