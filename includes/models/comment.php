<?php
class comment{

	private function commentNum($postId){
		$rowQuery = "SELECT * FROM comments WHERE comments.statusId = 1 AND comments.postId = '$postId'";
		$rowResult = @mysql_query($rowQuery);

		if($rowResult != false){
			$numComment = mysql_num_rows($rowResult);
			if($numComment == 0){
				return 'empty';
			} else {
				return $numComment;
			}
		} else {
			return false;
		}
	}

	public static function getComments($postId){

		$commentNum = comment::commentNum($postId);
		if($commentNum != false){
			if($commentNum == 'empty'){
				return 'empty';
			} else {
				if($commentNum > 10){
					$startComment = $commentNum - 10;
					$cmmtQuery = "SELECT 
					commentId,
					commentText,
					UNIX_TIMESTAMP(commentDate) AS commentDate,
					username,
					firstName,
					lastName,
					profilePicAddr
					FROM comments
					JOIN user ON comments.userId = user.userId
					JOIN profilepics ON comments.userId = profilepics.userId
					WHERE comments.postId = '$postId' AND comments.statusId = 1 AND profilepics.statusId = 1
					ORDER by comments.commentDate ASC
					LIMIT $startComment,$commentNum";
				} else {
					$cmmtQuery = "SELECT 
					commentId,
					commentText,
					UNIX_TIMESTAMP(commentDate) AS commentDate,
					username,
					firstName,
					lastName,
					profilePicAddr
					FROM comments
					JOIN user ON comments.userId = user.userId
					JOIN profilepics ON comments.userId = profilepics.userId
					WHERE comments.postId = '$postId' AND comments.statusId = 1 AND profilepics.statusId = 1
					ORDER by comments.commentDate ASC";
				}
				$cmmtResult = @mysql_query($cmmtQuery);
				$numResult = mysql_num_rows($cmmtResult);
				if($cmmtResult != false){
					while($cmmt = mysql_fetch_array($cmmtResult)){
						$comment[$cmmt['commentId']] = $cmmt;
					}
					return $comment;
				} else {
					return false;
				}
			}
		}


	}

	public static function checkOldComments($postId){
		$commentNum = comment::commentNum($postId);
		if($commentNum > 10){
			if(($commentNum - 10) == 1){
				$prefix = '';
			} else {
				$prefix = 's';
			}
			return '<li class="comment"><a href="javascript:void(0)" id="seeOlder" data-postId="'.$postId.'" data-lastComment="'.($commentNum-10).'">See '.($commentNum-10).' More Comment'.$prefix.'</a> <span class="loading"><span></span></span> <span class="numComment">Total '.$commentNum.' comments</span><div class="cleaner"></div></li>';
		} else {
			return '';
		}	
	}

	public static function insertComment($comment){
		$commentText = sanitize_text($comment['commentText']);
		$userId = $comment['userId'];
		$postId = $comment['postId'];
		
		$query = "INSERT INTO comments VALUES (NULL,'$commentText',NOW(),'$postId','$userId','1')";
		
		$result = @mysql_query($query);
			
		if($result != false){
			$lastCmmtId =  mysql_insert_id();
		
			$lastCmmtQ = "SELECT 
			commentId,
			commentText,
			UNIX_TIMESTAMP(commentDate) AS commentDate,
			firstName,
			lastName,
			username,
			profilePicAddr
			FROM comments
			JOIN user ON comments.userId = user.userId
			JOIN profilepics ON profilepics.userId = comments.userId
			WHERE comments.commentId = '$lastCmmtId' AND profilepics.statusId = 1";

			$lastCmmtR = mysql_query($lastCmmtQ);
			if($lastCmmtR != false){
				$lastCmmt = mysql_fetch_array($lastCmmtR);
				return $lastCmmt;
			} else {
				return false;
			}
		} else {
			return false;
		}
		
	}

	public static function seeOlder($postId,$commentNum){
		$query = "SELECT 
		commentId,
		commentText,
		UNIX_TIMESTAMP(commentDate) AS commentDate,
		username,
		firstName,
		lastName,
		profilePicAddr
		FROM comments
		JOIN user ON comments.userId = user.userId
		JOIN profilepics ON comments.userId = profilepics.userId
		WHERE comments.postId = '$postId' AND comments.statusId = 1 AND profilepics.statusId = 1
		ORDER by comments.commentDate ASC
		LIMIT $commentNum";
		$result = @mysql_query($query);
		if($result != false){
			while($cmmt = mysql_fetch_array($result)){
				$comment[$cmmt['commentId']] = $cmmt;
			}
			return $comment;
		} else {
			return false;
		}
	}
}

?>