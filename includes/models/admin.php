<?php

require("../baseClasses/Auth.php");
require("../conf.inc.php");

class admin extends Auth{
	
	public static function auth(){
		$table = 'admin';
		admin::user($table);
	}
}

?>