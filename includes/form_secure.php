<?php
require_once __DIR__ . '/common/function.php';

start_session();

if(isset($loggedPage)){
    if($loggedPage == true){
        require_once './auth/authentication.php';
    }    
}
$con = connectDB();


if(isset($loggedPage)){
    $id = $_SESSION['auth_user']['id'];

    if(empty($id)){
        header("Location: ".  $_SERVER["DOCUMENT_ROOT"] .'/'. "index.php");
    }
    else{
        $user = getUserById($id,$con);

        if(empty($user)){
            header("Location: ".  $_SERVER["DOCUMENT_ROOT"] .'/'. "index.php");
        }
        else{
            $user = $user[0];
        }
    }
}
?>