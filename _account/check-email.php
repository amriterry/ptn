<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_POST['email'])){
	$email = sanitize_text($_POST['email']);
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		$selQuery = "SELECT user.userId FROM user WHERE user.email = '$email'";
		$selResult = @mysql_query($selQuery) or die($e);
		$numEmail = mysql_num_rows($selResult);
		if($numEmail != 1){
			echo 0;
		} else {
			echo 1;
		}
	} else {
		echo 2;
	}
}

?>