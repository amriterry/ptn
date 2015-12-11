<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(!isset($_SESSION['login']) && isset($_POST['login'])){

	//taking the inputs in
	$username = $_POST['username'];
	$password = $_POST['password'];
	//cleaning the inputs
	$username = sanitize_text($username);
	$password = sanitize_text($password);
	$password = md5($password);
			
	$query = "SELECT * FROM admin WHERE ( admin.username = '$username' OR admin.email = '$username' ) AND admin.password = '$password'";
	$result = mysql_query($query,$conn) or die("Error");
	$count = mysql_num_rows($result);
	
	if($count == 1){
		$admin = mysql_fetch_array($result);
		if($admin['statusId'] == 1){
			$_SESSION['login'] = 1;
			$_SESSION['adminId'] = $admin['adminId'];
			header("location: ../admin/");
		} else {
			$_SESSION['error'] = 3;
			header("location: ../admin/login.php");
		}
	} else {
		$_SESSION['error'] = 2;
		header("location: ../admin/login.php");
	}
} else {
	header("location: ../admin/");
}

?>