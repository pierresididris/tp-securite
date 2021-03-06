<?php

include __DIR__ . '/classes/autoloader.php';

use model\Db;
use controller\UserController;

$autloader = new Autoloader();

session_start();

$baseUrl = "http://localhost/dev/a3/tp-securite/index.php";
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if($actual_link == $baseUrl . '?add-user'){
    $mail = $_POST["email"];
    $pwd = $_POST["pwd"];
    $profil = $_POST["profil"];
    if(
        ($mail != "" && $mail != null) &&
        ($pwd != "" && $pwd != null) &&
        ($profil != "" && $pwd != null)
    ) {
        $ctrl = new UserController();
        $resAddUser= $ctrl->add($mail, $pwd, $profil);
        $result = $resAddUser;
        header("HTTP1/1 200");
        echo json_encode($result);
    }
}

if($actual_link == $baseUrl . '?connect-user'){
    $mail = $_POST["email"];
    $pwd = $_POST["pwd"];

    if(
        ($mail != "" && $mail != null) &&
        ($pwd != "" && $pwd != null)
    ){
        session_unset();
        $ctrl = new UserController();
        header("HTTP1/1 200");
        $userId = $ctrl->connectUser($mail, $pwd);
        $result = [
            "userId" => $userId
        ];
        if($userId != "error"){
            $_SESSION["id"] = $userId;
        }
        header("HTTP1/1 200");
        echo json_encode($result);
    }
}

if($actual_link == $baseUrl . '?deconnect-user'){
    session_destroy();
    header("HTTP1/1 200");
    echo json_encode([
        "sessionDestroy" => true
    ]);
}

if($actual_link == $baseUrl . '?connected-user'){
    header("HTTP1/1 200");
    if(checkConnection()){
        $ctrl = new UserController();
        echo json_encode($ctrl->getListUser($_SESSION['id']));
    }else{  
        echo json_encode([
            "userConnected" => false
        ]);
    }
}

function checkConnection(){
    $ret = false;
    if(array_key_exists('id', $_SESSION)){
        if($_SESSION['id'] != null && $_SESSION['id'] != ""){
            $ret = true;
        }
    }
    return $ret;
}