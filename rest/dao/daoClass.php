<?php
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
}

?>