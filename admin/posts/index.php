<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	$adminId = $_SESSION['adminId'];
	$admin = get_admin_info($adminId);
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>Plus Two Notes | Posts</title>
	<?php require("../includes/links.php"); ?>

	<script>
	</script>
</head>
<body>

<!--header-->
<?php require("../includes/header.php"); ?>

<div id="main">

	<?php require("../includes/sideBar.php"); ?>

	<div id="rightCol">

	<?php require("../includes/dashboard.php"); ?>


	<div class="clrscr">
		<h2 class="ico_mug">Posts</h2>
		<a href="#" class="ico_refresh" style="padding-left:1.25em;" id="refreshPostList">Refresh</a><br /><br />
		<div class="tbl_container">
			<?php require("renderPostList.php"); ?>
		</div>
	</div>


	<?php require '../includes/footer.php'; ?>

</div>

</body>
</html>