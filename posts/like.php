<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(isset($_POST['postId'],$_SESSION['userLogin'])){
	$postId = intval($_POST['postId']);
	$userId = $_SESSION['userId'];
	
	$like = like::likeToggle($postId,$userId);

	if($like != false){
		echo $like;
	} else {
		echo false;
	}

}

?>