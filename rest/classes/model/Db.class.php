<?php

namespace model;

use PDO;

class Db {
    const ADDR_DB = "localhost";
    const PORT_DB = "";
    const DB_NAME = "tp_secu";
    const USER_NAME = "root";
    const USER_PWD = "Mat06061998";

    private $db;

    public function __construct(){
        try {
            $this->db = new PDO('mysql:host='.self::ADDR_DB.';dbname='.self::DB_NAME.';charset=utf8', self::USER_NAME, self::USER_PWD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $e){
            die('Erreur : '.$e->getMessage());
        }
    }

    public function getDb(){
        return $this->db;
    }
}