<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(isset($_POST['id'])){
	$id = intval($_POST['id']);
	$postTitle = $_POST['postTitle'];
	$textArea = $_POST['postText'];
	$imp = $_POST['imp'];

	$postTitle = ucfirst(sanitize_text($postTitle));
	$textArea = trim(mysql_real_escape_string(stripslashes($textArea)));
	
	if($postTitle == '' || $textArea == ''){
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => 'Either Post Title Or Post Body is empty!'
		);
	} else {

		$newPost = array(
			'postTitle' => $postTitle,
			'postText' => $textArea,
			'imp' => $imp
		);

		if(!post::save($newPost,$id)){
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

	echo json_encode($response);
	
}

?>