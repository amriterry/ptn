<?php

include("../../includes/conf.inc.php");
include("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	$adminId = $_SESSION['adminId'];
	$admin = get_admin_info($adminId);

	if($admin['roleId'] != 1){
		header("location: ../profile/");
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>Plus Two Notes | Admin Manager</title>
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
		<h2 class="ico_mug">Admin Manager</h2>
		<div class="tbl_container">
			<?php
				$query = "SELECT * FROM admin JOIN roles ON roles.roleId = admin.roleId WHERE admin.statusId != 3 ORDER by admin.adminId ASC";
				$result = mysql_query($query);
				if(!$result){
					die($e);
				} else {
					echo '
					<table class="tbl_list" cellspacing=0>
						<tr>
						<td>Id</td>
						<td>FirstName</td>
						<td>LastName</td>
						<td>Username</td>
						<td>Role</td>
						<td>Email</td>
						<td>Phone</td>
						<td>Status</td>
						<td>Action</td>
					</tr>';
					while($user = mysql_fetch_array($result)){
						if($user['statusId'] == 1){
							$status = "Good";
						} else {
							$status = "Reported!";	
						}

						echo '
						<tr id="'.$user['adminId'].'">
						<td>'.$user['adminId'].'</td>
						<td>'.$user['firstName'].'</td>
						<td>'.$user['lastName'].'</td>
						<td>'.$user['username'].'</td>
						<td>'.$user['roleName'].'</td>
						<td>'.$user['email'].'</td>
						<td>'.$user['phone'].'</td>
						<td>'.$status.'</td>
						<td>
						<a href="edit.php?id='.$user['adminId'].'" class="ico_edit"></a>
						<a href="#" class="ico_delete delAdmin" data-adminId="'.$user['adminId'].'"></a>
						</td>
						</tr>
						';
					}
					echo 
					'</table>';
				}
			?>
		</div>
	</div>


	<?php require '../includes/footer.php'; ?>

	</div>
</div>

</body>
</html>