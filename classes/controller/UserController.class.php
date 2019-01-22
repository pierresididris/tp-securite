<?php 

namespace controller;

use model\UserDao;

class Usercontroller{
    private $userDao;

    public function __construct(){
        $this->userDao= new UserDao();
    }

    public function add($email, $passwd, $profil){
        return $this->userDao->add($email, $passwd, $profil);
    }

    public function connectUser($email, $pwd){
        $userId = $this->userDao->connectUser($email, $pwd);
        if($userId != "error"){
            session_start();
        }
        return $userId;
    }
}