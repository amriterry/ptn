<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_GET['limitStart'],$_GET['numPosts'])){

	$limitStart = $_GET['limitStart'];
	$numPosts = $_GET['numPosts'];

	$posts = post::all(1,0,0,$limitStart,$numPosts);

	if(!$posts){
		$postList['success'] = 0;
		$postList['message'] = 'Whoops! Something Went Wrong';
	} else if($posts == 'empty'){
		$postList['success'] = 0;
		$postList['message'] = 'Post Not Found';
	} else {
		$postList['success'] = 1;
		$postList['posts'] = array();
		$postList['posts']= $posts;
	}

	echo json_encode($postList);

}

?>