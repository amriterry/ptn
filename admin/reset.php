<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php"); 

if(!isset($_GET['token'])){
	header("location: forgot.php");
}

?>
<!doctype html>
<html lang="en" style="background:#333;">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<?php require 'includes/links.php'; ?>

	<title>Admin Panel -- Plus Two Notes</title>
</head>
<body>

<header id="header">
	<hgroup>
		<span>Plus Two Notes | Admin Panel</span>
	</hgroup>
</header>

<div id="wrapper">
	<div id="login">
		<div id="loginAuth" class="loginResp" style="display:none;"></div>
		
		<div id="formContainer">
			<center><h5>Password Reset</h5></center><br />
			<form action="reset_test.php" method="post" id="resetForm">
				Email<br />
				<input type="email" placeholder="Enter email" name="email" /><br /><br />
				New Password<br />
				<input type="password" placeholder="Enter new Password" name="password" /><br /><br />
				Re-enter New Password
				<input type="password" placeholder="Enter Re-enter New Password" name="repassword" /><br /><br />
				<input type="hidden" name="token" value="<?php echo $_GET['token']; ?>"/>
				<input type="submit" id="passResetBtn" value="RESET PASSWORD" name="login" class="btn right" />
			</form>
			<div class="cleaner"></div><br>
			<a href="login.php" class="small_link">Login?</a><br />
		</div>
	</div>
</div>

</body>
</html>