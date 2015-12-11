<?php

if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == 1){
	$userId = $_SESSION['userId'];

	$user = user::getUserInfoById($userId);
	if($user == false){
		die($e);
	}
	
	$profilePic = $website.$user['profilePicAddr'];
	$headerName = $user['firstName'];
	$name = $user['firstName'].' '.$user['lastName'];
	$userName = $user['username'];
} else {
	$profilePic = $website.'assets/img/avatar-small.png';
	$headerName = "Guest";
}

if(isset($_SESSION['userLogin'])){
	echo '
	<div id="fixedHeader">
		<a href="'.$website.'"><img src="'.$website.'assets/img/logo_48 X 48.png" alt="Plus Two Notes"/></a>
		<div id="fixedHeaderUserInfo">
			<div id="fixedHeaderAvatar">
				<a href="'.$website.'account/profile/"><img src="'.$profilePic.'" class="avatar"></a>
			</div>
			<div id="fixedHeaderuserOptions">
				<span>'.$headerName.'</span> <div class="header-login-dropdown"> </div>
				<div class="cleaner"></div>
			</div>
		</div>
		<div class="header-account-dropdown-menu">
			<a href="'.$website.'">Home</a>
			<a href="'.$website.'account/profile/">Profile</a>
			<a href="'.$website.'account/notifications.php">Notifications</a>
			<a href="'.$website.'account/settings.php">Settings</a>
			<a href="'.$website.'account/logout.php">Log Out</a>
		</div>
	</div>';
}

echo '
<header id="header">
<hgroup>
	<div class="wrapper">
	
		<div class="fluid-col-container">
			<div class="fluid-col-3">
				<h2 id="logo"><a href="'.$website.'"><img src="'.$website.'/assets/img/header-logo.png" alt="Plus Two Notes - a site for complete Plus Two HSEB based Notes and Other Educational Materials."/></a></h2>
			</div>
			
			<div class="fluid-col-3">
				<div id="header-search">
					<form action="'.$website.'search/" method="get">
						<input type="text" name="q" placeholder="Search For Posts" id="header-search-input" autocomplete="off"/><input type="submit" value=" " id="header-search-btn" />
						<div id="header-search-feedback"><span class="search-wait">Searching...</span></div>
					</form>
				</div>
			</div>
			
			<div class="fluid-col-3">';

				/*<div class="header-account">
					<div class="header-user-info">
						<div class="header-user-profile-pic">
							<img src="'.$profilePic.'" class="avatar">
						</div>
						<div class="header-account-info">
							<span>'.$headerName.'</span> <div class="header-login-dropdown"> </div>
							<div class="cleaner"></div>
						</div>	
					</div>
					<div class="header-account-dropdown-menu">';
					
					if(!isset($_SESSION['userLogin']) || $_SESSION['userLogin'] != 1){
						echo '
						<a href="'.$website.'account/login.php">Log In</a>
						<a href="'.$website.'account/register.php">Sign Up</a>';
					} else {
						echo '
						<a href="'.$website.'">Home</a>
						<a href="'.$website.'account/profile/">Profile</a>
						<a href="'.$website.'account/notifications.php">Notifications</a>
						<a href="'.$website.'account/settings.php">Settings</a>
						<a href="'.$website.'account/logout.php">Log Out</a>';
					}

					echo '
					</div>
					<div class="cleaner"></div>
				</div><!--end of header-account-->
				<div class="cleaner"></div>*/

			echo '
			</div><!--end of fluid-col-3-->
			
			<div class="cleaner"></div>
		</div><!--end of fluid col container-->
		
	</div><!--end of wrapper-->
</hgroup>
</header>';

require("navigation.inc.php");

//die();

if(!isset($_SESSION['userLogin'])){
	echo '
<div id="banner">
	<div class="wrapper">
		
		<div class="slidewrap" data-autorotate="6000">
			
			<ul class="slider" id="sliderName">
				<li class="slide">
					<div>
						<h2>Plus Two Notes :: Read Notes</h2>
						<p>Take your time reading through our best explanatory Grade 11 and 12 notes.</p>
						<a href="'.$website.'notes/">See More</a>
					</div>
				</li>
				<li class="slide">
					<div>
						<h2>Plus Two Notes :: Check Syllabus</h2>
						<p>Too much to study? Go through the HSEB based syllabus to know how to study properly.</p>
						<a href="'.$website.'syllabus/">See More</a>
					</div>
				</li><li class="slide">
					<div>
						<h2>Plus Two Notes :: Get Answers</h2>
						<p>Learn more by knowing answers for questions for +2 HSEB Board Exam.</p>
						<a href="'.$website.'questions/">See More</a>
					</div>
				</li><li class="slide">
					<div>
						<h2>Plus Two Notes :: Refrence Books</h2>
						<p>Know about the best books available in the market which are benificial for your +2 education.</p>
						<a href="'.$website.'refrence/">See More</a>
					</div>
			</ul>
			
			<div class="cleaner"></div>
						
		</div>		
		
	</div>
</div>';
}
?>