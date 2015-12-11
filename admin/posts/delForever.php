<?php

$host = "localhost";
$username = "plustwon_admin";
$password = "P@55w0rd.";
$db = "plustwonotes.com";
@mysql_connect($host,$username,$password);
@mysql_select_db($db);
session_start();
require("../../includes/functions.inc.php");

if(isset($_POST['postId'])){
	$postId = $_POST['postId'];
	$query = "DELETE FROM posts WHERE posts.statusId = 3 AND posts.postId = '$postId'";

	$result = @mysql_query($query);
	if(!$result){
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => 'Opps! Something Went Wrong! Please Try Again Later',
			'debugMsg' => mysql_error()
		);
	} else {
		$response = array(
			'success' => 1,
			'error' => 0
		);
	}

	echo json_encode($response);
}
?>