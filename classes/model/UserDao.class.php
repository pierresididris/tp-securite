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
        // trigger_error("==============================" . $this->checkUserBdd($email));
        if($this->checkUserBdd($email) == ""){
            // Insertion
            $req = $this->db->prepare('INSERT INTO membres(pass, email, profil, date_inscription) VALUES(:pass, :email, :profil, CURDATE())');
            $ret= $req->execute(array(
                'pass' => $pass_hache,
                'profil' => $profil,
                'email' => $email
            ));
        }
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

    public function checkUserBdd($email){
      $sql = "SELECT id from membres WHERE email = :email";
      $query = $this->db->prepare($sql);
      $query->execute(array(
          "email" => $email
      ));
      $result = $query->fetch();
      $ret;
      if(array_key_exists('id', $result)){
          $ret = $result['id'];
      }
      return $ret;
    }
}