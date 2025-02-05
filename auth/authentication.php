<?php
require_once("./includes/form_secure.php");

if(!isset($_SESSION["authenticated"])){
    $_SESSION['status-fail'] = "Please login to access au Dashboard";
    header("Location: index.php");
    exit;
}
?>