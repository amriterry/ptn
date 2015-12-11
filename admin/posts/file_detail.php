<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

$fileId = $_POST['fileId'];

$query = "SELECT * FROM file WHERE file.fileId = '$fileId'";
$result = mysql_query($query,$conn) or die("Error");


$numFiles = mysql_num_rows($result);
if($numFiles != 1){
	$response = "Could not Fetch File Information";
} else {
	$file = mysql_fetch_array($result);
	$response = '<table border="0" class="tbl_file_detail" cellspacing="0">
	<tr>
		<td width="80">File Name:</td>
		<td>'.$file['fileName'].'</td>
	</tr>
	<tr>
		<td>File Url:</td>
		<td>'.$file['fileUrl'].'</td>
	</tr>
		<td>File Size:</td>
		<td>'.round(($file['fileSize']/1024),2).' kB</td>
	</tr>
	<tr>
		<td>File Desc:</td>
		<td>'.$file['fileDes'].'</td>
	</tr>
	</table>';
}
	
echo $response;

?>