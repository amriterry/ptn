<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_POST['institutionName'])){
	$institutionName = sanitize_text($_POST['institutionName']);
	$insQuery = "INSERT INTO institutions VALUES (NULL,'$institutionName')";
	$insResult = @mysql_query($insQuery) or die($e);
	$selQuery = "SELECT * FROM institutions";
	$selResult = @mysql_query($selQuery) or die($e);
	echo '<option value="NULL">Choose Your Institution</option>';
	while($institution = mysql_fetch_array($selResult)){
		echo '<option value="'.$institution['institutionId'].'">'.$institution['institutionName'].'</option>';
	}
}

?>