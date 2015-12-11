<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

if(isset($_POST['token'],$_POST['email'],$_POST['password'],$_POST['repassword'])){

	$token = $_POST['token'];
	$email = sanitize_text($_POST['email']);
	$password = sanitize_text($_POST['password']);
	$repassword = sanitize_text($_POST['repassword']);

	$newToken = md5($salt.$email);

	if($token == $newToken){
			
		$query = "SELECT admin.adminId FROM admin WHERE admin.email = '$email' AND admin.statusId = 2";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);

		if($count != 0){
			$admin = mysql_fetch_array($result);
			$adminId = $admin['adminId'];

			if($password == $repassword){
				$entryPassword = md5($password);

				$insQ = "UPDATE admin SET admin.statusId = '1' , admin.password = '$entryPassword' WHERE admin.adminId = '$adminId'";
				$insR = mysql_query($insQ);

				if(!$insR){
					$response = array(
						'success' => 0,
						'error' => 4,
						'errorMsg' => 'Opps! Something Went wrong. Please Try Again Later',
						'debugError' => mysql_error()
					);
				} else {
					$response = array(
						'success' => 1,
						'error' => 0
					);
				}
			} else {
				$response = array(
					'success' => 0,
					'error' => 3,
					'errorMsg' => 'Password didnot Match.'
				);
			}
		} else {
			$response = array(
				'success' => 0,
				'error' => 2,
				'errorMsg' => 'The email you entered couldnot be found.'
			);
		}
	} else {
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => 'Invalid token. Please check your email once again.'
		);
	}

echo json_encode($response);
	
}


?>