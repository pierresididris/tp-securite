<?php

namespace model;

use PDO;
use model\Db;

class UserDao{
    private $db ;
    
    public function __construct(){
        $db = new Db();
        $this->db = $db->getDb();
    }

    public function add($email, $passwd, $profil){
        // Hachage du mot de passe
        $pass_hache = password_hash($passwd, PASSWORD_DEFAULT);
        $emailQuoted = $this->db->quote($email) ;
        $profilQuoted = $this->db->quote($profil);
    
        // Insertion
        $req = $this->db->prepare('INSERT INTO membres(pass, email, profil, date_inscription) VALUES(:pass, :email, :profil, CURDATE())');
        return $req->execute(array(
            'pass' => $pass_hache,
            'profil' => $profilQuoted,
            'email' => $emailQuoted
        ));
    }
}