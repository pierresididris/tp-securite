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

    function openSession($userId){
        $sql = "INSERT INTO session_user (id_membre, open_close) VALUES (:idMember, :op)";
        $query = $this->db->prepare($sql);
        return $query->execute(array(
            'op' => "o",
            'idMember' => $userId
        ));
    }

    function getSession($userId){
        $sql = "SELECT open_close
                FROM session_user 
                WHERE id_membre = $userId 
                ORDER BY creation_time DESC
                LIMIT 1";
        $query = $this->db->query($sql);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function closeSession($userId){
        $sql = "SELECT open_close
                FROM session_user 
                WHERE id_membre = :userId
                ORDER BY creation_time DESC
                LIMIT 1";
        $query = $this->db->prepare($sql);
        $query->execute(array(
            'userId' => $userId
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result['open_close'] == 'o'){
            $sql = "INSERT INTO session_user (id_membre, open_close) VALUES (:idMembre, :cl)";
            $query = $this->db->prepare($sql);
            return $query->execute(array(
                'idMembre' => $userId,
                'cl' => 'c'
            ));
        }
    }

    public function getUserId($email, $pwd){
        $sql = "SELECT id, pass FROM membres WHERE email = :email";
        $query = $this->db->prepare($sql);
        $query->execute(array(
            "email" => $email
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $encryptedPwd = $result['pass'];
        $userId = 'error';
        if($encryptedPwd != "" && $encryptedPwd != null){
            if(password_verify($pwd, $encryptedPwd)){
                $userId = $result['id'];
            }
        }
        return $userId;
    }
}