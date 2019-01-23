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
        $ret = false;
        // Insertion
        $req = $this->db->prepare('INSERT INTO membres(pass, email, profil_id, date_inscription) VALUES(:pass, :email, :profil, CURDATE())');
        $ret= $req->execute(array(
            'pass' => $pass_hache,
            'profil' => $profil,
            'email' => $email
        ));
        return $ret;
        
    }

    public function connectUser($email, $pwd){
        $sql = "SELECT id, pass FROM membres WHERE email = :email";
        $query = $this->db->prepare($sql);
        $query->execute(array(
            "email" => $email,
        ));
        $user = $query->fetch();
        $isPwdCorrect = password_verify($pwd, $user["pass"]);
        $result = "error";
        if($isPwdCorrect){
            $result = $user["id"];
        }
        return $result;
    }

    public function checkUserDb($email){
      $sql = "SELECT id from membres WHERE email = :email";
      $query = $this->db->prepare($sql);
      $query->execute(array(
          "email" => $email
      ));
      $result = $query->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getListUser($userId){
        $sql = "SELECT profil_id FROM membres WHERE id = :userId";
        $query = $this->db->prepare($sql);
        $query->execute(array(
            "userId" => $userId
        ));
        $profilId = $query->fetch()["profil_id"];
        $result;
        if($profilId != ""){
            $sql = "SELECT id, email FROM membres WHERE profil_id = :profilId";
            $query = $this->db->prepare($sql);
            $query->execute(array(
                "profilId" => $profilId
            ));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        }else{
            trigger_error(__CLASS__.'->'.__METHOD__.'no profil id found for user '.$userId);
        }

        return $result;
    }
}