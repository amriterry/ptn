<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_POST['query'])){
		
	$query = $_POST['query'];
	$qarray = split(' ', $query);
	$queryTyp = strtolower($qarray[0]);

	$result = mysql_query($query);
	if(!$result){
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => mysql_error()
		);
	} else {
		if($queryTyp == 'select'){
			$tblData = '<table class="tbl_list" cellpadding="0" cellspacing=0>
			<tr>';
			
			$numFields = mysql_num_fields($result);
			$numresult = mysql_num_rows($result);

			for($i=0; $i<$numFields; $i++){
				$tblData .= "
				<td>".mysql_field_name($result,$i)."</td>";
			}

			$tblData .= "</tr>";

			while($row = mysql_fetch_row($result)){

				$tblData .= "<tr>";

				foreach($row as $entry){

					if($entry == NULL){
						$entry = "<b>NULL</b>";
					} else {
						$entry = truncate(strip_tags($entry),75);
					}
					$tblData .= "
					<td>".$entry."</td>";
				}

				$tblData .= "</tr>";

			}


			$tblData .= "
			</table>";

			$response = array(
				'success' => 1,
				'error' => 0,
				'returnTbl' => 1,
				'respData' => $tblData,
				'numresult' => $numresult
			);
		} else {
			$response = array(
				'success' => 1,
				'error' => 0,
				'returnTbl' => 0
			);
		}
		
	}
	
	
	
	echo json_encode($response);

}

?>