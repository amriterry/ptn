<?php

include("../../includes/conf.inc.php");
include("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	$updAdminId = $_POST['adminId'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	
	$updAdminId = intval($updAdminId);
	$firstName = ucfirst(sanitize_text($firstName));
	$lastName = ucfirst(sanitize_text($lastName));
	$email = sanitize_text($email);
	$phone = sanitize_text($phone);
	$username = sanitize_text($username);
	$password = sanitize_text($password);
	$repassword = sanitize_text($repassword);
	$decPass = md5($password);
	
	if($firstName == '' || $lastName == '' || $email == '' || $phone == '' || $username == '' || $password == '' || $repassword == ''){
		echo 'empty';
	} else {
		if($password != $repassword){
			echo 'unmatch';
		} else {
			$query = "SELECT adminId FROM admin WHERE admin.username = '$username' AND admin.adminId != '$updAdminId'";
			$result = mysql_query($query);
			if(!$result){
				echo 'error';
			} else {
				$numDuplicate = mysql_num_rows($result);
				if($numDuplicate == 1){
					echo 'alreadyAdded';
				} else {
					$update = "UPDATE admin SET 
					admin.firstName = '$firstName',
					admin.lastName = '$lastName',
					admin.username = '$username',
					admin.password = '$decPass',
					admin.email = '$email',
					admin.phone = '$phone'
					WHERE admin.adminId = '$updAdminId'";
					$updResult = mysql_query($update);

					if(!$updResult){
						echo 'error';
					} else {
						echo 'success';	
					}
				}
			}
		}
	}
}

?>