<?php

require("../includes/conf.inc.php");

if(isset($_COOKIE['allowAdmin'])){
	if(isset($_SESSION['error'])){
		if($_SESSION['error'] == 1) {
		$errorMsg = "You have to login first.";
		} else if($_SESSION['error'] == 2) {
		$errorMsg = "Enter Username and Password Correctly.";
		} else if($_SESSION['error'] == 3){
		$errorMsg = "Your account has been suspended.";	
		}
	}
	else{
		$errorMsg = "";
	}
} else {
	header("location: ../");
}

?>
<!doctype html>
<html lang="en" style="background:#333;">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<?php require 'includes/links.php'; ?>
	<link href="css/animate.min.css" rel="stylesheet" />

	<title>Admin Panel -- Plus Two Notes</title>
</head>
<body>

<header id="header">
	<hgroup>
		<span>Plus Two Notes | Admin Panel</span>
	</hgroup>
</header>

<div class="wrapper">
	<div id="login" <?php if(isset($_SESSION['error'])){ echo 'class="shake animated"'; }?>>
		<?php 
		if($errorMsg != ""){
			echo '<div id="loginError" class="loginResp">'.$errorMsg.'</div>';
			$errorMsg = '';
		}
		else
		{
			echo '';
		}
		?>
		<div id="formContainer" >
			<form action="logintest.php" method="post" name="loginForm" id="loginForm" >
				Username<br />
				<input type="text" placeholder="Enter Username" name="username" /><br /><br />
				Password<br />
				<input type="password" placeholder="Enter Password" name="password" /><br /><br />
				<input type="submit" value="LOG IN" name="login" class="btn right" />
			</form>
			<br /><br />
			<a href="../admin/forgot.php" class="small_link right">Forgot your username or password?</a>
			<div class="cleaner"></div>
		</div>
	</div>
</div>

</body>
</html>

<?php
if(isset($_SESSION['error'])){
	unset($_SESSION['error']);
}
?>