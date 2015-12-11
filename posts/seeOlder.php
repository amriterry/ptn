<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_POST['postId'],$_POST['commentNum'])){
	$postId = $_POST['postId'];
	$commentNum = $_POST['commentNum'];

	$comments = comment::seeOlder($postId,$commentNum);
	if($comments != false){
		$commentOutput = '';
		foreach($comments as $comment){
			$cmmtDate = ago($comment['commentDate']);
			$commentOutput = $commentOutput.'
			<li class="comment">
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

		echo $commentOutput;
	} else {
		echo false;
	}
}


?>