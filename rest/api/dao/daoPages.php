<?php
include_once("api/objects/page.php");

class daoPages {
    private $repertoire=__DIR__ . DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR."pages";
    //private $metafile = __DIR__ . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR."doc".DIRECTORY_SEPARATOR.'meta.json';

    private $pages=["","accueil","acces","tarifs","faq"];
    private $pagesadmin=["coordonnees"];

    /**
     */
    public function get($name)
    {
        if (in_array($name,$this->pages)){
            if ($name=="") { $name="accueil";}
            $file=$this->repertoire.DIRECTORY_SEPARATOR.$name.".html";
            $data = file_get_contents($file);
            return $data;
        
        } else if (isregister() && (in_array($name,$this->pagesadmin))) {
            $file=$this->repertoire.DIRECTORY_SEPARATOR.$name.".html";
            $data = file_get_contents($file);
            return $data;

        } else {
            trace_info("La page demandee $name n'est pas autorisee");
            return "";
        }
    }

    public function list() {
        $t=array_slice($this->pages,1);
        return array_merge($t,$this->pagesadmin);
    }

    public function update($name,$texte)
    {
        //Normalement ici on est proteges en access dans restPages
        if (in_array($name,$this->pages) || in_array($name,$this->pagesadmin)) {
            $filename=$this->repertoire.DIRECTORY_SEPARATOR.$name.".html";
            //verify qu'il y a des modif
            if (file_get_contents($filename)==$texte) {
                trace_info("pas de modification pour $name, on ne fait rien");
                return false;
            } else {
                $this->history($name);
                $hdl=fopen($filename,"w");
                fwrite($hdl,$texte);
                fclose($hdl);
                return true;
            }
        }
    }


    private function history($name) {

        $histdir=$this->repertoire.DIRECTORY_SEPARATOR.'.history';
        $histfile=$histdir.DIRECTORY_SEPARATOR.$name."_".date("Ymdhis").".html";
        $oldfilename=$this->repertoire.DIRECTORY_SEPARATOR.$name.".html";
        if (!file_exists($histdir)) {
            if (mkdir($histdir)==false) {
                trace_error("on n'arrive pas a creer le repertoire .history");
                return;
            }
        }
        trace_info("deplace [$oldfilename]  -> [$histfile]");

        if (rename($oldfilename,$histfile)) {
        }
    }


}
?>