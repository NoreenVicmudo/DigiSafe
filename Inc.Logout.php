<?php
session_start();
$_SESSION = array();
session_unset();
session_destroy();
header("Location: LoginPage.php");
exit();
?>
