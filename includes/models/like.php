<?php

class like{
	public static function checkLike($postId,$userId){
		$query = "SELECT likeId FROM `like` WHERE like.postId = '$postId' AND like.userId = '$userId' AND like.statusId = 1";
		$result = @mysql_query($query);
		if($result != false){
			$numLike = mysql_num_rows($result);
			if($numLike == 1){
				return 'liked';
			} else {
				return 'unliked';
			}
		} else {
			return false;
		}
	}

	public static function likeToggle($postId,$userId){
		$query = "SELECT * FROM `like` WHERE like.postId = '$postId' AND like.userId = '$userId'";
		$result = @mysql_query($query);
		if($result != false){
			$numLikeSel = mysql_num_rows($result);
			if($numLikeSel != 1){
				$insertQuery = "INSERT INTO `like` VALUES ('','$postId','$userId','1')";
				$insertResult = @mysql_query($insertQuery);
				if($insertResult){
					return 'liked';
				} else {
					return false;
				}
			} else {
				$liked = mysql_fetch_array($result);
				$checkLike = like::heckLike($postId,$userId);
				if($checkLike == "liked"){
					$updateStatus = 2;
					$updateLike = 'unliked';
				} else {
					$updateStatus = 1;
					$updateLike = 'liked';
				}

				$likeId = $liked['likeId'];

				$updateQuery = "UPDATE `like` SET like.statusId = '$updateStatus' WHERE like.likeId = '$likeId'";
				$updateResult = @mysql_query($updateQuery);
				if($updateResult){
					return $updateLike;
				} else {
					return false;
				}
			
			}
		} else {
			return false;
		}
	}

	public static function getLikes($postId){
		$query = "SELECT
		like.likeId,
		user.firstName,
		user.lastName,
		user.username
		FROM `like` 
		JOIN user ON user.userId = like.userId
		WHERE like.postId = '$postId'";
		$result = @mysql_query($query);
		if($result != false){
			while($likes = mysql_fetch_array($result)){
				$like[$likes['likeId']] = $likes;
			}
			return $like;
		} else {
			return false;
		}
	}
}

?>