<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(isset($_POST['postTitle'])){

	$adminId= $_SESSION['adminId'];
	$postTitle = $_POST['postTitle'];
	$postTypId = $_POST['postTypId'];
	$subjectId = $_POST['subjectId'];
	$imp = $_POST['imp'];
	$postText = $_POST['postText'];
	$postTitle = ucfirst(sanitize_text($postTitle));
	$postText = trim(mysql_real_escape_string(stripslashes($postText)));


	if($postTitle == '' || $postText == ''){
		//when any entry is empty
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => 'Either Post Title Or Post Body is empty!'
		);

	} else {

		$newPost = array(
			'postTitle' => $postTitle,
			'postText'=> $postText,
			'subjectId' => $subjectId,
			'postTypId' => $postTypId,
			'adminId' => $adminId,
			'statusId' => 2,
			'imp' => $imp
		);

		if(!post::create($newPost)){
			$response = array(
				'success' => 0,
				'error' => 2,
				'errorMsg' => 'Opps! Something Went Wrong!'
			);
		} else {
			$response = array(
				'success' => 1,
				'error' => 0
			);
		}
	}

	/*$_SESSION['response'] = $response;
	header("location: add.php");*/

	echo json_encode($response);

}

?>