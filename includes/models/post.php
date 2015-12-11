<?php

class post{

	public static function getPostReviewNum($userId){
		$userId = intval($userId);
		$query = "SELECT 
		posts.postId
		FROM
		posts
		JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
		JOIN usersubrel ON usersubrel.userSubRelId = mstsubject.subjectId
		JOIN user ON user.userId = usersubrel.userId
		WHERE usersubrel.userId = '$userId' AND posts.statusId = 1";

		$result = @mysql_query($query);
		if($result != false){
			$numPr = mysql_num_rows($result);
			return $numPr;
		} else {
			return false;
		}
	}

	//function to return a single post
	public static function view($postId,$statusId){
		if($statusId == 1){
			$query = "SELECT 
			posts.postId,
			posts.postTitle,
			posts.postText,
			UNIX_TIMESTAMP(postDate) as postDate,
			posts.statusId,
			posts.imp,
			mstclass.class,
			mstfaculty.facultyName,
			mstsubject.subjectId,
			mstsubject.subjectName,
			mstposttyp.postTyp,
			file.fileName,
			admin.adminId,
			file.fileUrl
			FROM posts
			JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
			JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
			JOIN mstclass ON mstclass.classId = mstfaculty.classId
			JOIN mstposttyp ON mstposttyp.postTypId = posts.postTypId
			JOIN admin ON admin.adminId = posts.adminId
			LEFT JOIN file ON file.fileId = posts.fileId
			WHERE posts.postId = '$postId' AND posts.statusId = 1";

		} else {

			$query = "SELECT
			posts.postId,
			posts.postTitle,
			posts.postText,
			UNIX_TIMESTAMP(postDate) as postDate,
			posts.statusId,
			posts.imp,
			mstclass.class,
			mstfaculty.facultyName,
			mstsubject.subjectId,
			mstsubject.subjectName,
			mstposttyp.postTyp,
			file.fileName,
			admin.adminId,
			file.fileUrl
			FROM posts
			JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
			JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
			JOIN mstclass ON mstclass.classId = mstfaculty.classId
			JOIN mstposttyp ON mstposttyp.postTypId = posts.postTypId
			JOIN admin ON admin.adminId = posts.adminId
			LEFT JOIN file ON file.fileId = posts.fileId
			WHERE posts.postId = '$postId' AND posts.statusId != 3";

		}

		$result = @mysql_query($query);
		if($result){
			$numResult = mysql_num_rows($result);
			if($numResult == 1){
				$res = mysql_fetch_array($result);
				for($i=0;$i<mysql_num_fields($result);$i++){
					$fieldName = mysql_field_name($result, $i);
					$post[$fieldName] = $res[$fieldName];
				}				
				return $post;
			} else {
				return 'empty';
			}
		} else {
			return false;
		}
	}

	//public function to get Recent posts
	public static function rp(){
		$rpQuery = "SELECT 
		postId,
		postTitle,
		postText,
		postDate,
		class,
		facultyName,
		subjectName,
		postTyp
		FROM posts
		JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
		JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
		JOIN mstclass ON mstclass.classId = mstfaculty.classId
		JOIN mstposttyp ON mstposttyp.postTypId = posts.postTypId
		WHERE posts.statusId = 1
		ORDER BY posts.postDate DESC,posts.imp DESC
		LIMIT 0 , 5";

		$rpResult = @mysql_query($rpQuery);
		if($rpResult != false){
			$rpNum = mysql_num_rows($rpResult);
			if($rpNum == 0){
				return 'empty';
			} else {
				$i = 0;
				while($rp = mysql_fetch_array($rpResult)){
					$rpReturn[$i] = $rp;
					$i++;
				}
				return $rpReturn;
			}
		} else {
			return false;
		}
	}

	public static function fp(){
		$rpQuery = "SELECT 
		postId,
		postTitle,
		postText
		FROM posts
		WHERE posts.statusId = 1
		ORDER BY posts.imp DESC,  posts.postDate DESC
		LIMIT 0 , 3";

		$rpResult = @mysql_query($rpQuery);
		if($rpResult != false){
			$rpNum = mysql_num_rows($rpResult);
			if($rpNum == 0){
				return 'empty';
			} else {
				$i = 0;
				while($rp = mysql_fetch_array($rpResult)){
					$rpReturn[$i] = $rp;
					$i++;
				}
				return $rpReturn;
			}
		} else {
			return false;
		}
	}

	public static function relp($subjectId,$postId){
		$relpQuery = "SELECT 
		posts.postId,
		posts.postTitle,
		mstsubject.facultyId
		FROM posts
		JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
		JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
		WHERE posts.statusId = 1 AND posts.subjectId = $subjectId AND posts.postId != $postId
		ORDER BY posts.imp DESC,  posts.postDate DESC
		LIMIT 0 , 10";

		$relpResult = mysql_query($relpQuery);
		$relpnum = mysql_num_rows($relpResult);
		if($relpnum == 0){

			$relp = mysql_fetch_array($relpResult);
			$facultyId = $relp['facultyId'];

			$relpQuery = "SELECT 
			postId,
			postTitle
			FROM posts
			JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
			JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
			WHERE posts.statusId = 1 AND mstsubject.facultyId = $facultyId AND posts.postId != $postId
			ORDER BY posts.imp DESC,  posts.postDate DESC
			LIMIT 0 , 10";

			$relpResult = mysql_query($relpQuery);
			$relpnum = mysql_num_rows($relpResult);

			if($relpnum == 0){
				return 'empty';
			} else {
				$i = 0;
				while($relp = mysql_fetch_array($relpResult)){
					$rel[$i] = $relp;
					$i++;
				}
				return $rel;
			}
		} else {
			$i = 0;
			while($relp = mysql_fetch_array($relpResult)){
				$rel[$i] = $relp;
				$i++;
			}
			return $rel;
		}
	}

	public static function getPostReviews($userId,$start,$end){
		$userId = intval($userId);
		$query = "SELECT 
		posts.postId,
		posts.postTitle,
		posts.postText,
		posts.postDate,
		posts.imp,
		mstsubject.subjectName,
		mstfaculty.facultyName,
		mstclass.class,
		mstposttyp.postTyp
		FROM
		posts
		JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
		JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
		JOIN mstclass ON mstclass.classId = mstfaculty.classId
		JOIN usersubrel ON usersubrel.userSubRelId = mstsubject.subjectId
		JOIN user ON user.userId = usersubrel.userId
		JOIN mstposttyp ON mstposttyp.postTypId = posts.postTypId
		WHERE usersubrel.userId = $userId AND posts.statusId = 1
		ORDER by posts.imp DESC,posts.postDate DESC
		LIMIT $start,$end";

		$result = @mysql_query($query);
		if($result != false){
			$numResult = mysql_num_rows($result);
			if($numResult == 0){
				return 'empty';
			} else {
				while($pr = mysql_fetch_array($result)){
					$prOutput[$pr['postId']] = $pr;
				}
				return $prOutput;
			}
		} else {
			return false;
		}
	}


	public static function searchPosts($q,$filters){
		if(empty($filters)){
			$query = "SELECT 
			postId,
			postTitle,
			postDate,
			imp,
			subjectName,
			facultyName,
			class,
			postTyp
			FROM posts 
			JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
			JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
			JOIN mstclass ON mstclass.classId = mstfaculty.classId
			JOIN mstposttyp ON mstposttyp.postTypId = posts.postTypId
			WHERE MATCH (posts.postTitle,posts.postText) AGAINST('$q')
			AND posts.statusId = 1";
		} else {
			//query
		}

		$result = @mysql_query($query);
		if($result != false){
			$num_el = mysql_num_rows($result);
			if($num_el == 0){
				return 'empty';
			} else {
				$i=0;
				while($srCol = mysql_fetch_array($result)){
					$sr[$i] = $srCol;
					$i++;
				}
				return $sr;
			}
		} else {
			return false;
		}
	}

	public static function all($statusId = 0,$postTypId = 0,$subjectId = 0,$limitStart = 0,$limitEnd = 0){

		$query = "SELECT
		posts.postId,
		posts.postTitle,
		UNIX_TIMESTAMP(postDate) as postDate,
		posts.statusId,
		posts.imp,
		mstclass.class,
		mstfaculty.facultyName,
		mstsubject.subjectName,
		mstposttyp.postTypId,
		mstposttyp.postTyp,
		admin.adminId,
		admin.firstName,
		admin.lastName,
		file.fileName,
		file.fileUrl
		FROM posts
		JOIN mstsubject ON mstsubject.subjectId = posts.subjectId
		JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
		JOIN mstclass ON mstclass.classId = mstfaculty.classId
		JOIN mstposttyp ON mstposttyp.postTypId = posts.postTypId
		JOIN admin ON admin.adminId = posts.adminId
		LEFT JOIN file ON file.fileId = posts.fileId
		WHERE posts.statusId";

		if($statusId != 0){
			$query .= "= $statusId";
		} else {
			$query .= "!= 3";
		}

		if($postTypId != 0){
			$query .=" AND posts.postTypId = $postTypId";
		}

		if($subjectId != 0){
			$query .=" AND posts.subjectId = $subjectId";
		}
		
		$query .="
		ORDER BY posts.statusId DESC,posts.postDate DESC";

		if($limitEnd != 0){
			$query .= "
			LIMIT $limitStart,$limitEnd";
		}

		$result = @mysql_query($query);
		if($result != false){
			$numPost = mysql_num_rows($result);
			if($numPost == 0){
				return 'empty';
			} else {

				//$plist['posts'] = array();

				$plist = array();

				while($res = mysql_fetch_array($result)){

					for($i=0;$i<mysql_num_fields($result);$i++){
						$fieldName = mysql_field_name($result, $i);
						$post[$fieldName] = $res[$fieldName];
					}					

					array_push($plist,$post);

				}

				return $plist;

			}
		} else {
			return false;
		}
	}

	public static function save($newPost,$postId){

		static $tbl = 'posts';

		$query = "UPDATE $tbl SET ";

		$array_size = sizeof($newPost);

		$i = 1;
		foreach($newPost as $key => $value){
			$query .= "$key = '$value'";

			if($i != $array_size){
				$query .= ', ';
			}
			$i++;
		}

		$query .= " WHERE postId=$postId";

		$result = @mysql_query($query);
		
		if(!$result){
			return false;
		} else {
			return true;
		}
	}
	
	public static function create($newPost){
		static $tbl = 'posts';

		$query = "INSERT INTO $tbl ";

		$array_size = sizeof($newPost);

		$colName = "postId,";
		$val = "NULL,";
		$i = 1;
		foreach($newPost as $key => $value){
			$colName .= "$key";
			$val .= "'$value'";
			if($i != $array_size){
				$colName .= ', ';
				$val .= ', ';
			}
			$i++;
		}

		$query .= "($colName) VALUES ($val)";
		
		$result = @mysql_query($query);
		
		if(!$result){
			return false;
		} else {
			return true;
		}
	}

}

?>