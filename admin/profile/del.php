<?php

include("../../includes/conf.inc.php");
include("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	$id = $_POST['adminId'];
	$id = intval($id);

	$query = "UPDATE admin SET admin.statusId = 3 WHERE admin.adminId = '$id'";
	$result = mysql_query($query);
	if(!$result){
		echo 'error';
	} else {
		echo 'success';
	}
	
}

?>