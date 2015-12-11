<?php

include("../../includes/conf.inc.php");
include("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {

	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	$roleId = $_POST['roleId'];
	
	$firstName = ucfirst(sanitize_text($firstName));
	$lastName = ucfirst(sanitize_text($lastName));
	$email = sanitize_text($email);
	$phone = sanitize_text($phone);
	$username = sanitize_text($username);
	$password = sanitize_text($password);
	$repassword = sanitize_text($repassword);
	$roleId = intval($roleId);
	$decPass = md5($password);
		
	if($firstName == '' || $lastName == '' || $email == '' || $phone == '' || $username == '' || $password == '' || $repassword == ''){
		echo 'empty';
	} else {
		if($password != $repassword){
			echo 'unmatch';
		} else {
			$query = "SELECT adminId FROM admin WHERE admin.username = '$username' OR admin.email = '$email'";
			$result = mysql_query($query);
			if(!$result){
				echo 'error';
			} else {
				$numDuplicate = mysql_num_rows($result);
				if($numDuplicate == 1){
					echo 'alreadyAdded';
				} else {
					$insert = "INSERT INTO admin VALUES 
					(NULL,'$username','$decPass','$firstName','$lastName','$email','$phone','$roleId','1')";
					$insertResult = mysql_query($insert);
					if(!$insertResult){
						echo 'error';
					} else {
						$lastAdminId = mysql_insert_id();
						$query = "SELECT roleName FROM roles WHERE roles.roleId = $roleId";
						$result = mysql_query($query);
						$role = mysql_fetch_array($result);
						$roleName = $role['roleName'];

						$subject = 'Your Account Has been Created';
						$body = "
						<html>
						<head>
							<title>Your account Has been Created.</title>
							<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
							<style>
							body{
								font:100% 'Open Sans',Segoe UI, Calibri, Candara, Arial, sans-serif;
							}

							a{
								color:#008ED7;
								text-decoration:none;
							}

							a:hover{
								text-decoration:underline;
							}

							</style>
						</head>
						<body>
						Dear $firstName $lastName,<br/><br/>

						Your admin account has been succesfully created at <a href=$website>Plus Two Notes</a> (Admin Id: <b>$lastAdminId</b>) under following details:<br/><br/>

						<ul>
							<li>Username: $username</li>
							<li>Password: $password</li>
							<li>Email: $email</li>
							<li>Role: $roleName</li>
							<li>Phone Number: $phone</li>
						</ul>

						<a href=\"http://www.plustwonotes.com/admin/?_scob_\">http://www.plustwonotes.com/admin/?_scob_</a>

						Click the above link to login to your account or paste in the address bar of your browser.<br /><br />

						<b>Support</b><br/>

						For any support with respect to your relationship with us you can always contact us directly using the following Information.<br/><br/>

						Email address: contact@plustwonotes.com

						<br /><br />

						<i>This is auto generated email. Please donot reply</i>
						</body>
						</html>";

						$headers="From: Plus Two Notes <admin-noreply@pluswonotes.com>\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						if(mail($email,$subject,$body,$headers)){
							echo 'success';
						} else {
							echo 'error';
						}
					}
				}
			}
		}
	}
}

?>