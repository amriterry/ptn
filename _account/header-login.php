<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(!isset($_POST['email'],$_POST['password'])){
	header($website);
} else {
	$email = $_POST['email'];
	$lpassword = $_POST['password'];
	$email = trim($email);
	$lpassword = trim($lpassword);
	$email = mysql_real_escape_string($email);
	$lpassword = mysql_real_escape_string($lpassword);
	$email = htmlentities($email);
	$lpassword = htmlentities($lpassword);
	
	$conn = mysql_connect($host,$username,$password) or die("0");
	mysql_select_db($db,$conn) or die("0");
	
	$loginQuery = "SELECT 
	userId,
	firstName,
	lastName,
	profilePicAddr
	FROM user
	JOIN profilePics ON profilePics.profilePicId = user.profilePicId
	WHERE user.email = '$email' AND user.password = '$lpassword' AND user.statusId = 1";
	$loginResult = mysql_query($loginQuery,$conn) or die("0");
	$numRows = mysql_num_rows($loginResult);
	if($numRows != 1){
		echo '0';
	} else if($numRows == 1){
		$user = mysql_fetch_array($loginResult);
		$_SESSION['userLogin'] = 1;
		$_SESSION['loginUserId'] = $user['userId'];
		$_SESSION['loginUserFirstName'] = $user['firstName'];
		$_SESSION['loginUserLastName'] = $user['lastName'];
		$_SESSION['loginUserProfilePicAddr'] = $user['profilePicAddr'];
		echo '1';
	}
}

?>