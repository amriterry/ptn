<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

$class = $_POST['classId'];

$query = "SELECT * FROM mstsubject
JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
JOIN mstclass ON mstclass.classId = mstfaculty.classId
WHERE mstclass.classId = $class";

$result = mysql_query($query);

$response = '<option value=""></option>';

while($subject = mysql_fetch_array($result)){
	$response =  $response."
	<option value=".$subject['subjectId'].">".$subject['subjectName']."</option>";
}

echo $response;

?>