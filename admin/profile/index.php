<?php

include("../../includes/conf.inc.php");
include("../../includes/functions.inc.php");

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
	<title>Plus Two Notes | Admins</title>
	<?php require("../includes/links.php"); ?>
</head>
<body>

<!--header-->
<?php include("../includes/header.php"); ?>

<div id="main">

<?php include("../includes/sideBar.php"); ?>

<div id="rightCol">

<?php include("../includes/dashboard.php"); ?>


<div id="tabledata" class="clrscr">
<h2 class="ico_mug">Admins</h2>
<!--php begins-->

<?php

		
$query = "SELECT * FROM admin
JOIN roles ON roles.roleId = admin.roleId
WHERE admin.statusId != 3";

$result = mysql_query($query);

if(!$result){
	die($e);
} else {

	echo '
	<div>
		<table cellspacing="0" class="tbl_list">
		<tr>
			<td>Name </td>
			<td>Email </td>
			<td>Phone </td>
			<td>Status </td>
			<td>Level </td>
			<td>Actions</td>
		</tr>';

	while($adminQ = mysql_fetch_array($result)){
	
		echo '
		<tr>
			<td>'.$adminQ['firstName'].' '.$adminQ['lastName'].'</td>
			<td>'.$adminQ['email'].'</td>
			<td>'.$adminQ['phone'].'</td>
			<td>';
			if($adminQ['statusId'] == 2){
				echo "Suspended!";
			} else {
				echo "Good!";	
			}
			echo '
			</td>
			<td class="level">'.$adminQ['roleName'].'</td>';
			if($admin['roleId'] == 1 || $adminId == $adminQ['adminId']){
				echo '
				<td><a href="edit.php?id='.$adminQ['adminId'].'">Edit?</a></td>';
			} else {
				echo 'No actions';
			}

			echo '</tr>';		
		
	}

	echo'
	</table>
	</div>';
}



?>

</div>

<div id="footer" class="clrscr">
<center>Admin Panel<br /><br />Copyright © Plus Two Notes 2013</center>
</div>

</div>
</div>
</body>
</html>