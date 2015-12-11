<?php

	$startNum = 0;
	$endNum = 2;
	$postReviewResult = post::getPostReviews($userId,$startNum,$endNum);
	if($postReviewResult == false){
		die($e);
	} else if($postReviewResult == 'empty'){
		echo "No Reviews to show";
	} else {
		echo '<div id="postReviewContainer">';
		foreach ($postReviewResult as $pr) {
			$dateTime = getdate(strtotime($pr['postDate']));
			echo '
			<div class="postReview" id="'.$pr['postId'].'">
				<h5>'.$pr['postTitle'].'</h5>
				<span>Added at: '.$dateTime['mday'].' '.$dateTime['month'].', '.$dateTime['year'].'</span>
				<span>Category: '.$pr['postTyp'].'</span>
				<span>'.$pr['class'].' > '.$pr['facultyName'].' > '.$pr['subjectName'].' > '.$pr['chapterName'].'</span>
				<div class="review">'.truncate($pr['postText'],500).'</div>
				<a href="'.generate_link($pr['postTitle'],$pr['postId']).'" class="anchor-btn" target="_blank">See More</a>
			</div>';
		}
		echo '</div>';

		$postReviewNum = $postReviewObj->getPostReviewNum($userId);
		if($postReviewNum > $endNum){
			echo '
			<a href="javascript:void(0)" id="seeMorePr" class="anchor-btn">See More</a>';
		}
	}

?>