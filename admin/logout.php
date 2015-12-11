<?php

//logout script

session_start();

unset($_SESSION['adminId'],$_SESSION['login'],$_SESSION['superAdmin'],$_SESSION['levelId']);

header("Location: login.php");

?>