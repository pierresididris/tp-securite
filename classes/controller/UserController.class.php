<?php 

namespace controller;

use model\UserDao;

class Usercontroller{
    private $userDao;

    public function __construct(){
        $this->userDao= new UserDao();
    }

    public function add($email, $passwd, $profil){
        $ret['result'] = false;
        if(!$this->userDao->checkUserDb($email)){
            $ret['result'] = $this->userDao->add($email, $passwd, $profil);
        }else{
            $ret['memberAlreadyExists'] = true;
        }
        return $ret;
    }

    public function connectUser($email, $pwd){
        $userId = $this->userDao->connectUser($email, $pwd);
        return $userId;
    }
}