<?php
// header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, origin");
header('Access-Control-Allow-Credentials: true');

include __DIR__ . '/classes/autoloader.php';

use model\Db;
use controller\UserController;

$autloader = new Autoloader();

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
        // echo json_encode($ctrl->connectUser($mail, $pwd));
        echo json_encode($ctrl->connectUser($mail, $pwd));
    }
}

if($actual_link == $baseUrl . '?deconnect-user'){
    $userId = $_POST["id"];
    $ctrl = new UserController();
    if(
        $userId != "" && $userId != null 
    ){
        setcookie('currentUser', '');
        echo json_encode([
            "sessionDestroy" => $ctrl->disconnectUser($userId)
        ]);
    }
}

if($actual_link == $baseUrl . '?get-user-list'){
    if(isUserConnected()){
        $ctrl = new UserController();
        echo json_encode($ctrl->getListUser($_COOKIE['currentUser']));
    }else{
        echo json_encode([
            "userConnected" => false
        ]);
    }
}

/**
 * Check if the session is still open for the current cookie
 * Session is marked at 'o' in db if it's open
 * return true or false if the session is open
 */
if($actual_link == $baseUrl . '?is-session-open'){
    $ctrl = new UserController();
    if(isUserConnected()){
        echo json_encode(true);
    }else{
        echo json_encode([
            'error' => 'no user connected'
        ]);
    }
}

if($actual_link == $baseUrl . '?get-user-connected'){
    if(isUserConnected()){
        $ctrl = new UserController();
        $user = $ctrl->getUser($_COOKIE['currentUser']);
        echo json_encode($user);
    }else{
        echo json_encode([
            'error' => 'no user connected'
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
    
    /**
     * Check if a cookie is recorded for currentUser
     */
    function isUserConnected(){
    $ret = false;
    if(array_key_exists('currentUser', $_COOKIE)){
        if($_COOKIE['currentUser'] != null && $_COOKIE['currentUser'] != ''){
            if(checkSession($_COOKIE['currentUser'])){
                $ret = true;
            }
        }
    }
    // trigger_error('==================================================' . $ret);
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