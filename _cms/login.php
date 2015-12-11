<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Admin Panel -- Login</title>
	<?php require("includes/links.inc.php"); ?>

	<style>
	body{
		background: #222;
	}
	</style>
</head>
<body>

<div class="login-page">
	<img src="../assets/img/header-logo.png" class="logo"/>
	<div id="login-form-container">
		<form action="logintest.php" method="post" name="loginForm">
			<b>Username</b><br />
			<input type="text" class="logintxt" placeholder="Enter Username" name="username" /><br />
			<b>Password</b><br />
			<input type="password" class="logintxt" placeholder="Enter Password" name="password" /><br />
			<center><input type="submit" value="Log In" name="login" class="btn" /></center>
		</form>
		<a href="../" class="small_link">Back To Plus Two Notes</a><br /><a href="forgot.php" class="small_link">Forgot your username or password?</a>
		<div class="cleaner"></div>
	</div>
	<div class="cleaner"></div>
</div>

</body>
</html>