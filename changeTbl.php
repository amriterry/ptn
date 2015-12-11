<?php

require('includes/conf.inc.php');
require('includes/functions.inc.php');

$query = "SELECT * FROM posts";

$result = mysql_query($query);

$fieldNames = array();

$insertQ = 'INSERT INTO posts';

for($i = 0; $i<mysql_num_fields($result); $i++){
	array_push($fieldNames,mysql_field_name($result,$i));
}


var_dump($fieldNames);


?>