<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

$subject = $_POST['subjectId'];

$query = "SELECT * FROM mstposttyp";
$result = mysql_query($query);

$response = '<option value=""></option>';
while($postTyp = mysql_fetch_array($result)){
		$response = $response."
		<option value=".$postTyp['postTypId'].">".$postTyp['postTyp']."</option>";
}

echo $response;

?>

