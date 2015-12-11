<?php
	
require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_POST['login'])){

	$email = sanitize_text($_POST['email']);
	$password = sanitize_text($_POST['password']);
	$query = "SELECT * FROM user WHERE user.email = '$email' AND user.password = '$password' AND	user.statusId = 1";
	$result = mysql_query($query,$conn) or die("Error Logging In");
	$numrows = mysql_num_rows($result);
	if($numrows == 1){
		$userLogin = mysql_fetch_array($result);
		$_SESSION['userLogin'] = 1;
		$_SESSION['userId'] = $userLogin['userId'];
		header("Location: ".$website);
	} else {
		$_SESSION['userLogin'] = 0;
		header("Location: login.php");
	}	
} else {
	header("Location: login.php");
}
?>