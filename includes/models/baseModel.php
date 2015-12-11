<?php

class BaseModel{

	protected $table;
	protected $primaryKey;

	public static function all(){
		$rows = array();

		$query = "SELECT * FROM ".self::$table;
		$result = mysql_query($query);

		/*while($row = mysql_fetch_array($result)){
			array_push($rows, $row);
		}
*/
		return $query;
	}
}

?>