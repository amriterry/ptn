<?php
	require("../includes/conf.inc.php");
	require("../includes/functions.inc.php");
	
	if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == 1){
		header("Location: ".$website);
	}
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<head>
	
	<title>Plus Two Notes - Log In</title>
	
	<?php require("../includes/links.inc.php"); ?>

	<style>

	html{
		background: none;
	}

	body{
		background: #001C2E url(../assets/img/seamless-login-bg.jpg) no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		color:#fff;
	}

	</style>

	

</head>
<body>
<div id="page">
	<div class="wrapper">
		<section class="loginform">
			<a href="<?php echo $website; ?>"><img src="<?php echo $website; ?>assets/img/header-logo.png"></a>
			<h2 class="userAccounts-heading">LOGIN</h2>
			<?php
				if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == 0){
					generate_error_msg("Opps! Invalid Username and Password Combination");
					unset($_SESSION['userLogin']);
				}
			?>
			
			<form action="logincheck.php" method="post" id="loginForm">
				<center>
					<table>
						<tr>
							<td><input type="email" placeholder="EMAIL ADDRESS" name="email" /></td>
						</tr>
						<tr>
							<td><input type="password" placeholder="PASSWORD" name="password" /></td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="Log In" name="login" />
								<br /><br /><a href="register.php" class="userAccounts">Create an Account</a>
								<br /><a href="forgot.php" class="userAccounts">Forgot your password?</a>
							</td>
						</tr>
					</table>
				</center>
			</form>
		</section>		
	</div>
</div>
</body>
</html>