<?php

include_once("api/log.php");

class daoClass{
    protected $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=aquabebe_db;charset=utf8';
        $login = 'aquabebe';
        $password = 'aquabebe';
        $this->pdo = new PDO( $dsn, $login, $password );  
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);          
    }

    
    protected function doInsert($table,$values)
    {
        $k=array_keys($values);
        $v=array_values($values);

        $query="INSERT INTO ".$table;
        $query.="(".implode(",",$k).") ";
        $query.="VALUES(".implode(",",$v).")";
    
        trace_debug($query);
        $retid=-1;
        try {
            $stmt=$this->pdo->query($query);
            $retid=$this->pdo->lastInsertId();
            trace_info("Return id=$retid");
        }catch(PDOException  $e ){
            trace_info("Error $e");
            trace_error("Error ".$query."\n  ".$e);
            return -1;
        }
        return $retid;
        
    }

    protected function doUpdate($table,$identifiant,$values)
    {
                //check if something has been changed
                if (count($values)==0){
                    trace_info("Not need to update ".$table." ".$identifiant);
                    return true;
                }
                trace_info("Update ".$table." for id ".$identifiant. " with ".print_r($values,true));

                //Build UPDATE query
                $query="UPDATE ".$table." SET ".implode(",",$values)." ";
                $query.="WHERE id=".$identifiant;
        
                trace_debug($query);
        
                //Execute query
                try {
                    $stmt=$this->pdo->query($query);
                }catch(PDOException  $e ){
                    trace_info("Error $e");
                    trace_error("Error ".$query."\n  ".$e);
                    return false;
                }
        
                return true;
    }
}

?>