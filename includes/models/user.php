<?php

class user{

	public static function getUserInfoById($userId){
		$query= "SELECT 
		user.userId,
		user.firstName,
		user.lastName,
		user.username
		FROM 
		user 
		WHERE user.userId = '$userId'";
		$result = @mysql_query($query);
		if($result != false){
			$userInfo = mysql_fetch_array($result);
			return $userInfo;
		} else {
			echo 'error';
			return mysql_error();
		}
	}

	public static function getUserInfoByUsername($username){
		$query= "SELECT 
		user.userId,
		user.firstName,
		user.lastName,
		user.username,
		profilepics.profilePicAddr,
		institutions.institutionName
		FROM 
		user 
		JOIN profilepics ON profilepics.userId = user.userId
		LEFT JOIN institutions ON institutions.institutionId = user.institutionId
		WHERE user.username = '$username' AND profilepics.statusId = 1";
		$result = @mysql_query($query);
		if($result != false){
			$userInfo = mysql_fetch_array($result);
			return $userInfo;
		} else {
			return false;
		}
	}

	private function getUserActivity($userId,$start){
		$end = $start + 5;
		$query="SELECT DISTINCT
		posts.postId
		FROM
		comments
		JOIN posts ON posts.postId = comments.postId
		WHERE comments.userId = '$userId' AND posts.statusId = 1
		ORDER by comments.commentDate DESC
		LIMIT $start , $end";
		$result = @mysql_query($query);
		if($result != false){
			$numResult = mysql_num_rows($result);
			if($numResult == 0){
				return 'empty';
			} else {
				$i = 0;
				while($ua = mysql_fetch_array($result)){
					$uaOut[$i] = $ua;
					$i++;
				}
				return $uaOut;
			}
		} else {
			return false;
		}
	}

	public static function getUserActivityDetail($userId,$start){
		$uaOut = user::getUserActivity($userId,$start);
		if($uaOut != false){
			$userActivity = '';
			$i = 0;
			foreach($uaOut as $ua){
				$activityId = $ua['postId'];
				$query = "SELECT 
				posts.postTitle,
				posts.postDate,
				posts.postText,
				comments.commentDate 
				FROM comments
				JOIN posts ON posts.postId = comments.postId
				WHERE comments.postId = '$activityId'
				ORDER by comments.commentDate DESC
				LIMIT 1";
				$result = @mysql_query($query);
				$userActivity[$i] = mysql_fetch_array($result);
				$i++;
			}
		} else {
			return false;
		}
	}

}

?>