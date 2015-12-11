<?php

class Auth{
	
	protected static function user($table){
		if(isset($_SESSION['login'])){
			$colName = $table.'Id';
			$id = $_SESSION[$colName];

			$query = "SELECT * FROM $table WHERE $colName = $id AND statusId = 1";
			$result = mysql_query($query);
			$userDetail = mysql_fetch_array($result);

			return $userDetail;
		} else {
			return false;
		}
	}
	
}

?>