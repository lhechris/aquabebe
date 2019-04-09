<?php

class daoConfig {

    private $configfile;
    
    public function __construct()
    {
        $this->configfile="config.json";
    }

    public function get() {
        if (!file_exists($this->configfile)) {
            $this->save([]);
        }

        $hdl=fopen($this->configfile,"r");        
        $string = file_get_contents($this->configfile);
        fclose($hdl);
        $json = json_decode($string, true);
        return $json;
    }

    public function save($input) {
        $hdl=fopen($this->configfile,"w");
        $json=array();
        if (array_key_exists("CURRENT_SAISON",$input)) {
            $json["CURRENT_SAISON"]=$input['CURRENT_SAISON'];
        } else {
            $currmonth=date('n');
            if ($currmonth>=9) {
                $year1  = date("Y");
                $year2  = date("Y")+1;                
            } else {
                $year1  = date("Y")-1;
                $year2  = date("Y");                
            }
            $json["CURRENT_SAISON"]=$year1."-".$year2;
        }

        if (array_key_exists("blockinscription",$input)) {
            $json["blockinscription"]=$input["blockinscription"];
        } else {
            $json["blockinscription"]="false";
        }

        if (array_key_exists("inscriptionpass",$input)) {
            $json["inscriptionpass"]=$input["inscriptionpass"];
        } else {
            $json["inscriptionpass"]="";
        }
        
        fwrite($hdl,json_encode($json,JSON_PRETTY_PRINT));
        fclose($hdl);

    }

    public function getBlockInscription() {
        $conf=$this->get();
        if (array_key_exists("blockinscription",$conf)) {
            return $conf["blockinscription"];
        } else {
            return "false";
        }
    }

    public function checkInscriptionPass($pass) {
        $conf=$this->get();
        if (array_key_exists("inscriptionpass",$conf)) {
            return ($pass==$conf["inscriptionpass"]);
        } else {
            return false;
        }
    }


}

?>