<?php
require_once __DIR__ . '/../includes/form_secure.php';


unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);
$_SESSION['status-success'] = "You logged out sucessfully";
header("Location: ../index.php");

?>