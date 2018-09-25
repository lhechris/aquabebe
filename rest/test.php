<?php
include_once("dao/document.php");
include_once("dao/daoDocuments.php");

$dao=new daoDocuments();
$doc=new Document();
$doc->setNom("trucmuche.jpg");
$doc->setChemin("");
$doc->setDescription("la description modifde trucmuche");
$doc->updateType();

$file="doc".DIRECTORY_SEPARATOR.'meta.json';
$data = $dao->get();

if ($data!==FALSE) {
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
    if ($found==false) {
        array_push($data,$doc);
    }

    //redefini les ids
    $currid=1;
    foreach ($data as $d )
    {
        $d->setId($currid);
        $currid=$currid+1;
    }

    $t=array();
    foreach ($data as $d )
    {
        array_push($t,$d->toArray());
    }
    

    //ecrit le fichier meta
    $hdl=fopen($file,"w");
    if ($hdl!==false) {
        fwrite($hdl,json_encode($t,JSON_PRETTY_PRINT));
        fclose($hdl);
    }
}


?>