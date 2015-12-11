<?php

class Subject {

	public static function all(){
		$rows = array();

		$query = "SELECT * FROM mstsubject";
		$result = mysql_query($query);

		while($row = mysql_fetch_array($result)){
			array_push($rows, $row);
		}

		return $query;
	}
}

?>