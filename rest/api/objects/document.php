<?php
include_once("mime.php");

class Document {
    private $id;
    private $nom;
    private $chemin;
    private $description;
    private $type;

    public function __construct()
    {
    }

    public function getId() { return $this->id;}
    public function setId($id) { $this->id=$id;}

    public function getNom() { return $this->nom;}
    public function setNom($v) { $this->nom=$v;}

    public function getChemin() { return $this->chemin;}
    public function setChemin($v) { $this->chemin=$v;}

    public function getDescription() { return $this->description;}
    public function setDescription($v) { $this->description=$v;}

    public function getType() { return $this->type;}
    public function setType($v) { $this->type=$v;}

    
    public function updateType() {
      //get extension
      $t=explode(".",$this->nom);
      $ext=strtolower($t[count($t)-1]);
      
      $this->type=getMimeType($ext);
    }

    /*public function jsonSerialize() {
		$vars = get_object_vars($this);
		return $vars;
    }*/
    public function toArray() {
		$vars = get_object_vars($this);
		return $vars;
    }
}
?>