<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(isset($_POST['postId'])){
	$postId = $_POST['postId'];

	if(!post::save(array('statusId' => 1),$postId)){
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => 'Opps! Something Went Wrong! Please Try Again Later',
			'debugMsg' => mysql_error()
		);
	} else {
		$post = post::view($postId,1);
		$postTitle = $post['postTitle'];
		$previewLink = '<a href="'.generate_link($postTitle,$postId).'" target="_blank" class="ico_preview"></a>';
		$response = array(
			'success' => 1,
			'preview' => $previewLink,
			'error' => 0
		);
	}

	echo json_encode($response);
}
?>