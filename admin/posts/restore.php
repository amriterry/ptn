<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(isset($_POST['postId'])){
	$postId = $_POST['postId'];

	if(!post::save(array('statusId' => 2),$postId)){
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