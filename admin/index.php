<?php 

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");


if(!isset($_COOKIE['allowAdmin'])){
	if(!isset($_GET['_scob_'])){
		header("location: ../");	
	} else {
		setcookie('allowAdmin','1',0);
		header("location: ../admin/");
	}
} else {
	if(!isset($_SESSION['login'])){
		//$_SESSION['error'] = 2;
		header("location: login.php");	
	} else {
		$adminId = $_SESSION['adminId'];
		$admin = get_admin_info($adminId);

		if(isset($_COOKIE['ptn'])){
			$version = $_COOKIE['ptnCmsVersion'];

			if($version < cmsVersion){
				$expire = time() + (60*60*24*60);
				setcookie('ptnCmsVersion',cmsVersion,$expire);
			}
		} else {
			$expire = time() + (60*60*24*60);
			setcookie('ptn','1',$expire);
			setcookie('ptnCmsVersion',cmsVersion,$expire);
		}
	}
}



?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />	
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>Admin Panel -- Plus Two Notes</title>
	
	<?php require 'includes/links.php'; ?>
</head>
<body>
<!--header-->

<?php require("includes/header.php"); ?>

<div id="notice">
    <h5>Query Status</h5>
    <p></p>
    <br />
    <a href="#" class="anchor-btn" id="ok">Okay</a>
    <br /><br />
    <div class="cleaner"></div>
</div>

<?php

if(isset($_COOKIE['ptn'])){

	if($_COOKIE['ptnCmsVersion'] < cmsVersion){
		echo '
		<div id="updates">
			<b>New Update in CMS!</b><span class="cross right"></span>
			<p>Clear Browsing Data to view Changes</p>
		</div>';
	}
}

?>

<div id="main">

	<?php require("includes/sideBar.php"); ?>

	<div id="rightCol">
		<?php 

		require("includes/dashboard.php");

		if($admin['roleId'] == 1){
			echo '
			<div class="clrscr">
				<h2 class="ico_mug">Query</h2>
				<form action = "query.php" method="post">
					<textarea class="query" name="queryString" cols="100" style="width:100%;margin-bottom:0.5em;" rows="15"></textarea>
					<br />
					<input type="submit" class="btn" value="Query" name="query">
				</form>

				<div id="returnQuery" style="word-wrap:break-word;display:none;background:rgba(135,195,22,0.2);color:rgb(100,160,0);padding:0.5em;border-radius:0.5em;margin:0.5em 0;"></div>
				<div id="returnTbl" style="margin:0.5em 0;"></div>
			</div>
			';
		}

		require('includes/footer.php');

		?>
	</div>
</div>
</body>
</html>