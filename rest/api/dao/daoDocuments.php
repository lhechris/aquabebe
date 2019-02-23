<?php
include_once("api/objects/document.php");

class daoDocuments {
    private $repertoire=__DIR__ . DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR."doc";
    private $metafile = __DIR__ . DIRECTORY_SEPARATOR . '..'. DIRECTORY_SEPARATOR . '..'.DIRECTORY_SEPARATOR."doc".DIRECTORY_SEPARATOR.'meta.json';

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

    private function jsonLastErrorStr() {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return 'Aucune erreur';
            break;
            case JSON_ERROR_DEPTH:
                return 'Profondeur maximale atteinte';
            break;
            case JSON_ERROR_STATE_MISMATCH:
                return 'Inadéquation des modes ou underflow';
            break;
            case JSON_ERROR_CTRL_CHAR:
                return 'Erreur lors du contrôle des caractères';
            break;
            case JSON_ERROR_SYNTAX:
                return 'Erreur de syntaxe ; JSON malformé';
            break;
            case JSON_ERROR_UTF8:
                return 'Caractères UTF-8 malformés, probablement une erreur d\'encodage';
            break;
            default:
                return 'Erreur inconnue';
            break;
        }
    
    } 

    /**
     * Retourne la liste des fichiers 
     * uniquement les meta donnees (meta.json)
     */
    public function get()
    {
        $file=$this->metafile;
        $json = json_decode(file_get_contents($file),true);
        $data=array();
        if (($json!=null)&&($json!=FALSE)) {
            foreach ($json as $d) {
                if ((array_key_exists("id",$d)) && 
                    (array_key_exists("nom",$d)) &&
                    (array_key_exists("chemin",$d)) &&
                    (array_key_exists("description",$d)) &&
                    (array_key_exists("type",$d))
                   ) {
                    $doc=new Document();
                    $doc->setId($d["id"]);
                    $doc->setNom($d["nom"]);
                    $doc->setChemin($d["chemin"]);
                    $doc->setDescription($d["description"]);
                    $doc->setType($d["type"]);
                    array_push($data,$doc);
                }
            }
        } else {
            trace_error("Erreur lecture meta.json :".$this->jsonLastErrorStr());
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
            $hdl=fopen($this->metafile,"w");
            if ($hdl!==false) {
                fwrite($hdl,$json);
                fclose($hdl);
            }
        }
    }

    /**
     * Remplace les meta donnees
     */
    function update($docsupd) {
        //TODO : verifier les donnees recues
        trace_info("Update ");
        if (($docsupd===FALSE) || ($docsupd==null) ) {
            trace_info("Mauvais parametres fonctions update");
            return;
        }
        //transform
        $newdocs=array();
        foreach ($docsupd as $d) {
            $doc=new Document();
            $doc->setNom($d['nom']);
            $doc->setDescription($d['description']);
            $doc->updateType();
            array_push($newdocs,$doc);
        }
        trace_info(count($newdocs)." docs recues");

        $dao=new daoDocuments();
        $olddocs=$dao->get();

        trace_info(count($olddocs)." dans la base");

        //recherche les fichier a supprimer
        foreach($olddocs as $old) {
            $found=false;
            foreach($newdocs as $new) {
                if (($old->getNom()==$new->getNom()) && ($old->getChemin()==$new->getChemin())) {
                    $found=true;
                }
            }
            if ($found==false) {
                //deplace le fichier dans trash
                $this->trash($old);
            }
        }

        $this->rebuildids($newdocs);

        //transform en array pour le convertir en json
        $t=array();
        foreach ($newdocs as $d ) { array_push($t,$d->toArray()); }
        $json=json_encode($t,JSON_PRETTY_PRINT);

        $hdl=fopen($this->metafile,"w");
        if ($hdl!==false) {
            trace_info("Ecriture des metas donnes pour les ".count($newdocs)." docs");
            fwrite($hdl,$json);
            fclose($hdl);
        } else {
            trace_error("Erreur ecriture fichier ".$this->metafile);
            trace_info("Erreur ecriture fichier ".$this->metafile);
        }
    }

    private function rebuildids($docs) {
        trace_info("reconstruit les ids pour les ".count($docs). " documents");
        //redefini les ids
        $currid=1;
        foreach ($docs as $doc ) {
            $doc->setId($currid);
            $currid=$currid+1;
        }
    }

    //supprime le doc
    private function trash($doc) {

        $trashdir=$this->repertoire.DIRECTORY_SEPARATOR.'.trash';
        $trashfile=$trashdir.DIRECTORY_SEPARATOR.$doc->getNom()."_".date("Ymdhis");
        $oldfilename=$this->repertoire.DIRECTORY_SEPARATOR.$doc->getNom();
        if (!file_exists($trashdir)) {
            if (mkdir($trashdir)==false) {
                trace_error("on n'arrive pas a creer le repertoire .trash");
                return;
            }
        }
        trace_info("deplace [$oldfilename]  -> [$trashfile]");

        if (rename($oldfilename,$trashfile)) {
            trace_info("poubelle $oldfilename");
        }
    }



}
?>