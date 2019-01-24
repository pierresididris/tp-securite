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
        if($userId != "error"){
            $this->userDao->openSession($userId);
        }
        return $userId;
    }

    public function isUserConnected($userId){
        $ret = false;
        $session = $this->userDao->getSession($userId);
        if($session['open_close'] == 'o'){
            $ret = true;
        }
        return $ret;
    }

    public function disconnectUser($email, $pwd){
        $userId = $this->userDao->getUserId($email, $pwd);
        $ret = 'error';
        if($userId != 'error'){
            $ret = $this->userDao->closeSession($userId);
        }
        return $ret;
    }


    public function getListUser($userId){
        return $this->userDao->getListUser($userId);
    }
}