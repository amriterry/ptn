<?php

if(isset($_POST['start'])){
	$start = intval($_POST['start']);
	require("../includes/conf.inc.php");
	require("../includes/functions.inc.php");
} else {
	$start = 0;
}

if(isset($_SESSION['userLogin'])){
	$userId = $_SESSION['userId'];

	$userActivity = user::getUserActivityDetail($userId,$start);

	if($userActivity == false){
		echo $e;
	} else {
		foreach($userActivity as $ua){
			echo '
				<div class="userActivity">
					<h5>'.$ua['postTitle'].'</h5>
				</div>
			';
		}
	}

}

?>