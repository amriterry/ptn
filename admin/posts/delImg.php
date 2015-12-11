<?php

if(isset($_POST['imgLink'])){

	if(unlink($_POST['imgLink']) && unlink($_POST['thumbLink'])){
		$response = array(
			'success' => 1,
			'error' => 0,
			'thumbLink' => $_POST['thumbLink']
		);
	} else {
		$response = array(
			'success' => 0,
			'error' => 1
		);
	}

	echo json_encode($response);
	
}

?>