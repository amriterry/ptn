<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_GET['postId'])){
	$postId = intval($_GET['postId']);

	$post = post::view($postId,1);

	if(!$post){
		$postRe['success'] = 0;
		$postRe['message'] = 'Whoops! Something Went Wrong';
	} else if($post == 'empty'){
		$postRe['success'] = 0;
		$postRe['message'] = 'Post Not Found';
	} else {
		$postRe['success'] = 1;
		$postRe['post'] = array();
		array_push($postRe['post'],$post);
	}
	
	echo json_encode($postRe);
}


?>