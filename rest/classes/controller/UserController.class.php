<?php 

namespace controller;

use model\UserDao;
use \Firebase\JWT\JWT;

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
            $jwt = JWT::encode($userId, 'tpsecuritepassphrase');
            \setcookie('currentUser', $jwt);
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

    public function getUser($userId){
        return $this->userDao->getUser($userId);
    }

    public function resetPasswordPre($userEmail){
        if($this->userDao->isUserExists($userEmail)){
            $this->userDao->setInactif($userEmail);
            $this->userDao->add($userEmail, 'test', $this->userDao->getProfilId($userEmail));
            $mailer = new \Mailer();
            $mailer->setUserEmail($userEmail);
            $mailResponse = $mailer->send();
        }else{
            trigger_error('no user found for email : '.$userEmail);
        }
    }

    public function resetPasswordPost($userEmail, $newPwd){
        $ret = 'error';
        if($newPwd != null && $newPwd != "" && $this->userDao->isUserExists($userEmail)){
            $this->userDao->setInactif($userEmail);
            $this->userDao->add($userEmail, 'test', $this->userDao->getProfilId($userEmail));
            $ret = 'passwordReseted';
        }
        return $ret;
    }
}