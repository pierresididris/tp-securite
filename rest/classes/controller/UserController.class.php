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
            \setcookie('currentUser', $userId);
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

    public function disconnectUser($userId){
        $user = $this->userDao->getUser($userId);
        $ret = false;
        if(\array_key_exists('email', $user)){
            $ret = $this->userDao->closeSession($userId);
        }
        return $ret;
    }


    public function getListUser($userId){
        return $this->userDao->getListUser($userId);
    }
}