<?php
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Content-Type, origin");

include __DIR__ . '/classes/autoloader.php';

use model\Db;
use controller\UserController;

$autloader = new Autoloader();

session_start();

$baseUrl = "http://localhost/dev/a3/tp-securite/rest/index.php";
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_POST = json_decode(file_get_contents('php://input'), true);
}

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
        header("HTTP1/1 200");
        echo json_encode($ctrl->add($mail, $pwd, $profil));
    }
}

if($actual_link == $baseUrl . '?connect-user'){
    $mail = $_POST["email"];
    $pwd = $_POST["pwd"];

    if(
        ($mail != "" && $mail != null) &&
        ($pwd != "" && $pwd != null)
    ){
        //session_unset();
        $ctrl = new UserController();
        // header("HTTP1/1 200");
        echo json_encode($ctrl->connectUser($mail, $pwd));
    }
}

if($actual_link == $baseUrl . '?deconnect-user'){
    // session_destroy();
    // // header("HTTP1/1 200");
    // echo json_encode([
    //     "sessionDestroy" => true
    // ]);
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $ctrl = new UserController();
    if(
        $email != "" && $pwd != null &&
        $pwd != "" && $pwd != null
    ){
        echo json_encode([
            "sessionDestroy" => $ctrl->disconnectUser($email, $pwd)
        ]);
    }
}

if($actual_link == $baseUrl . '?connected-user'){
    // header("HTTP1/1 200");
    if(checkConnection()){
        $ctrl = new UserController();
        echo json_encode($ctrl->getListUser($_SESSION['id']));
    }else{  
        echo json_encode([
            "userConnected" => false
        ]);
    }
}

if($actual_link == $baseUrl . '?get-user-list'){
    $userId = $_POST['id'];
    if($userId != "" && $userId != null){
        if(checkSession($userId)){
            $ctrl = new UserController();
            echo json_encode($ctrl->getListUser($_POST['id']));
        }else{
            echo json_encode([
                "userConnected" => false
            ]);
        }
    }else{
        echo json_encode([
            "error" => 'aucun idée trouvée'
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

function checkSession($userId){
    $ret = false;
    $ctrl = new UserController();
    if($ctrl->isUserConnected($userId)){
        $ret = true;
    }
    return $ret;
}