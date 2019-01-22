<?php 

namespace controller;

use model\UserDao;

class Usercontroller{
    private $userDao;

    public function __construct(){
        $this->userDao= new UserDao();
    }

    public function add($email, $passwd, $profil){
        return $userDao->add($email, $passwd, $profil);
    }
}