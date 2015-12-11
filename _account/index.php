<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(!isset($_SESSION['userLogin'])){
	header("location: login.php");
} else{
	if(!isset($_GET['u'])){
		$userId = $_SESSION['userId'];
		$userInfo = user::getUserInfoById(1);

		/*if($userInfo == false){
			echo 'err';
		}*/

		var_dump($userInfo);

	} else {
		$userName = sanitize_text($_GET['u']);
		if($userName == ''){
			$userId = $_SESSION['userId'];
			$userInfo = user::getUserInfoById($userId);

			echo 'Dfd';
			if($userInfo == false){
				die($e);
			}


		} else {
			$userInfo = user::getUserInfoByUsername($userName);

			if($userInfo == false){
				die($e);
			}
		}
	}
}

?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<head>
	
	<title><?php echo $userInfo['firstName'].' '.$userInfo['lastName'] ?> - Plus Two Notes</title>
	
	<?php require("../includes/links.inc.php"); ?>

</head>
<body>

<div id="main">

<?php require("../includes/header.inc.php"); ?>

<div id="page" class="user-page">
	<div class="wrapper">
		<div id="user-left-col">
			<div class="user-info">
				<img src="<?php echo $website.$userInfo['profilePicAddr']; ?>" id="userProfilePic"/><br />
				<div class="basic-info">
					<?php 
						echo $userInfo['firstName'].' '.$userInfo['lastName'].'<br />'.$userInfo['institutionName'].'<br />';

						if(isset($_GET['u'])){
							if($userId == $userInfo['userId']){
								echo '<br /><a href="#" class="anchor-btn green">Edit Profile</a>
								<br /><br /><a href="#" class="anchor-btn orange">Settings</a>
								<br /><br /><a href="#" class="anchor-btn red">Log Out</a>';
							}
						} else {
							echo '<br /><a href="#" class="anchor-btn green">Edit Profile</a>
							<br /><br /><a href="#" class="anchor-btn orange">Settings</a>
							<br /><br /><a href="#" class="anchor-btn red">Log Out</a>';
						}

					?>
				</div>
			</div>
		</div>
		<div id="user-right-col">
		<?php
			require("userActivity.php");
		?>
		</div>
	</div>
</div>

<?php require("../includes/footer.inc.php"); ?>

</div>

</body>
</html>