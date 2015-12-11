<?php

include("../../includes/conf.inc.php");
include("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	$adminId = $_SESSION['adminId'];
	$admin = get_admin_info($adminId);

	if(isset($_GET['id']) && ($admin['roleId'] == 1)){
		$getId = intval($_GET['id']);
	} else if(!isset($_GET['id'])){
		$getId = $adminId;
	} else {
		header("location: ../profile/");
	}

	$user = get_admin_info($getId);
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>Plus Two Notes | Admin Editor</title>
	<?php require("../includes/links.php"); ?>
</head>
<body>

<!--header-->
<?php include("../includes/header.php"); ?>


<div id="notice">
    <h5>Profile Status</h5>
    <p></p>
    <br />
    <a href="#" class="anchor-btn" id="ok">Okay</a>
    <br /><br />
    <div class="cleaner"></div>
</div>

<div id="main">

	<?php include("../includes/sideBar.php"); ?>

	<div id="rightCol">
		<?php include("../includes/dashboard.php"); ?>

		<div class="clrscr">
			<h2 class="ico_mug">Admin Editor</h2>
			<form action="update.php" method="post" id="updateAdminForm">
				<input type="hidden" value="<?php echo $user['adminId']; ?>" name="adminId" />
				<table class="form_tbl">
					<tr>
						<td>First Name: </td>
						<td><input name="firstName" type="text" size="40" value="<?php echo $user['firstName']; ?>"/> </td>
					</tr>
					<tr>
						<td>Last Name: </td>
						<td><input name="lastName" type="text" size="40" value="<?php echo $user['lastName']; ?>"/> </td>
					</tr>
					<tr>
						<td>Email: </td>
						<td><input name="email" type="text" size="40" value="<?php echo $user['email']; ?>"/> </td>
					</tr>
					<tr>
						<td>Phone: </td>
						<td><input name="phone" type="text" size="40" value="<?php echo $user['phone']; ?>"/> </td>
					</tr>
					<tr>
						<td>Username: </td>
						<td><input name="username" type="text" size="40" value="<?php echo $user['username']; ?>"/> </td>
					</tr>
					<tr>
						<td>Password: </td>
						<td><input name="password" type="password" size="40" /> </td>
					</tr>
					<tr>
						<td>Re-enter Password: </td>
						<td><input name="re-password" type="password" size="40" /> </td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" name="updateAdmin" value="Update" class="btn" id="updateAdmin"/></td>
					</tr>
				</table>
			</form>
		</div>


		<?php require '../includes/footer.php'; ?>

	</div>
</div>

</body>
</html>