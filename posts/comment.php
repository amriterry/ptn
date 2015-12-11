<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");


if(isset($_POST['commentText']) && !empty($_POST['commentText'])){
	$comment['commentText'] = sanitize_text($_POST['commentText']);
	$comment['userId'] = intval($_POST['userId']);
	$comment['postId'] = intval($_POST['postId']);

	$comment = comment::insertComment($comment);
	if($comment == false){
		echo false;
	} else{
		$cmmtDate = ago($comment['commentDate']);
		echo '<li class="comment">
					<div class="commenterProfilePic">
						<img src="'.$website.$comment['profilePicAddr'].'"/>
					</div>
					<div class="commentDetail">
						<a href="'.$website.'account/profile/'.$comment['username'].'" class="commenter">'.$comment['firstName'].' '.$comment['lastName'].'</a><br />
						<p>'.$comment['commentText'].'</p>
						<span>'.$cmmtDate.'</span>
					</div>
					<div class="cleaner"></div>
				</li>';
	}	
}

?>