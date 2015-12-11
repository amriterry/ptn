<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(!isset($_COOKIE['allowAdmin'])){
	header("location: ../");
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
			<form action="forgot_test.php" method="post" id="forgotForm">
				Enter your email address<br>
				<input type="text" name="email" placeholder="Email" class="logintxt"/><br><br>
				<input type="submit" class="btn" value="Prompt Reset" name="forgot" id="forgotPromptBtn"/><br>
			</form>
			<div class="cleaner"></div><br>
			<a href="login.php" class="small_link">Login?</a><br />
		</div>
	</div>
</div>

</body>
</html>