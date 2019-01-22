<?php

include __DIR__ . '/classes/autoloader.php';

use model\Db;
use controller\UserController;

$autloader = new Autoloader();

$baseUrl = "http://localhost/tp-security/index.php";
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
        $result = [
            "result" => $resAddUser,
        ];
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
        $ctrl = new UserController();
        header("HTTP1/1 200");
        $result = [
            "userId" => $ctrl->connectUser($mail, $pwd)
        ];
        echo json_encode($result);
    }
}