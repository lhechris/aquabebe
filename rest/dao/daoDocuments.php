<?php
include_once("document.php");

class daoDocuments {
    private $repertoire=__DIR__ . DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR."doc";

    public function litrepertoire($rep)
    {
        $data=array();
        //Lit le repertoire doc
        $directory=$this->repertoire.DIRECTORY_SEPARATOR.$rep;
        if ($handle = opendir($directory)) {
        
            /* Ceci est la façon correcte de traverser un dossier. */
            while (false !== ($entry = readdir($handle))) {
                if (($entry!=".") && ($entry!="..")) {
                    trace_info("$entry");
                    $doc=new Document();
                    $doc->setNom($entry);
                    $doc->setChemin("./");
                    array_push($data,$doc);
                }
            }
            closedir($handle);
        }
        return $data;
    }

    /**
     * Retourne la liste des fichiers 
     * uniquement les meta donnees (meta.json)
     */
    public function get()
    {
        $file=$this->repertoire.DIRECTORY_SEPARATOR.'meta.json';
        $json = json_decode(file_get_contents($file),true);
        $data=array();
        foreach ($json as $d) {
            $doc=new Document();
            $doc->setId($d["id"]);
            $doc->setNom($d["nom"]);
            $doc->setChemin($d["chemin"]);
            $doc->setDescription($d["description"]);
            $doc->setType($d["type"]);
            array_push($data,$doc);
        }
        return $data;
    }


    public function getFichier($id)
    {
        $docs=$this->get();
        $doc=null;
        foreach($docs as $d) {
            if ($d->getId()==$id) {
                $doc=$d;
                break;
            }
        }
        if ($doc!=null) {
            //lit le fichier
            $file=$this->repertoire.DIRECTORY_SEPARATOR.$doc->getChemin().DIRECTORY_SEPARATOR.$doc->getNom();
            return array($doc,file_get_contents($file));

        }else {
            return null;
        }
    }

    /**
     * Ajoute ou met à jour le document dans le fichier des meta données
     */
    public function add($doc) {
        $file="doc".DIRECTORY_SEPARATOR.'meta.json';
        $dao = new daoDocuments();
        $data = $dao->get();
        
        //ajoute le doc s'il n'existe pas
        $found=false;
        foreach ($data as $d )
        {
            if (($d->getNom()==$doc->getNom())&&($d->getChemin()==$doc->getChemin()))
            {
                $d->setDescription($doc->getDescription());
                $found=true;
            }
        }
        if ($found==false) { array_push($data,$doc); }
    
        //redefini les ids
        $currid=1;
        foreach ($data as $d ) {
            $d->setId($currid);
            $currid=$currid+1;
        }

        //transform en array pour le convertir en json
        $t=array();
        foreach ($data as $d ) { array_push($t,$d->toArray()); }
        $json=json_encode($t,JSON_PRETTY_PRINT);
                
        //ecrit le fichier meta
        if (($json!==FALSE) && ($json!=null)) {
            $hdl=fopen($file,"w");
            if ($hdl!==false) {
                fwrite($hdl,$json);
                fclose($hdl);
            }
        }
    }

}
?>