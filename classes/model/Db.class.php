<?php

namespace model;

use PDO;

class Db {
    const ADDR_DB = "localhost";
    const PORT_DB = "";
    const DB_NAME = "";
    const USER_NAME = "root";
    const USER_PWD = "";

    private $db;

    public function __construct(){
        try {
            $this->db = new PDO('mysql:host='.self::ADDR_DB.';dbname='.self::DB_NAME.';charset=utf8', self::USER_NAME, self::USER_PWD);
        } catch (Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }

    public function getDb(){
        return $this->db;
    }
}