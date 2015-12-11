<?php

header("Content-type: text/javascript");

include("../includes/conf.inc.php");
include("../includes/functions.inc.php");

if(isset($_POST['email'])){

	$email = $_POST['email'];

	$email = sanitize_text($email);

	$query = "SELECT 
	admin.adminId,
	admin.firstName,
	admin.lastName,
	admin.email 
	FROM admin 
	WHERE admin.email = '$email'
	AND admin.statusId = 1";

	$result = mysql_query($query);

	if(!$result){
		$response = array(
			'success' => 0,
			'error' => 1,
			'errorMsg' => 'Opps! Something went wrong.'
		);
	} else {
		$adminNum = mysql_num_rows($result);
		if($adminNum == 0){
			$response = array(
				'success' => 0,
				'error' => 2,
				'errorMsg' => 'Incorrect Information Provided. Please try again.'
			);
		} else {
			$admin = mysql_fetch_array($result);
			$adminId = $admin['adminId'];
			$adminFirstName = $admin['firstName'];
			$adminLastName = $admin['lastName'];
			$adminEmail = $admin['email'];

			$token = md5($salt.$adminEmail);

			$resetLink = $website."admin/reset.php?token=".$token;

			$updQuery = "UPDATE admin SET admin.statusId = 2 WHERE admin.adminId = '$adminId'";
			$updRes = mysql_query($updQuery);

			if(!$updRes){
				$response = array(
					'success' => 0,
					'error' => 1,
					'errorMsg' => 'Opps! Something went wrong.',
				);
			} else {
				$subject = "Password Reset.";
				$body = "
					<html>
					<head>
						<title>Password Reset</title>
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
					Dear $adminFirstName $adminLastName,<br/><br/>

					A request to reset password was received from your <a href=$website>Plus Two Notes</a> account - $adminEmail. (Admin Id: <b>$adminId</b>)<br/><br/>

					<br/>

					<a href=$resetLink>$resetLink</a><br/><br/>

					Click the above link to reset your password or copy and paste in the address bar of your browser.<br /><br />

					<b>Support</b><br/>

					For any support with respect to your relationship with us you can always contact us directly using the following Information.<br/><br/>

					Email address: contact@plustwonotes.com

					<br /><br />

					<i>This is auto generated email. Please donot reply</i>
					</body>
					</html>

				";



				$headers="From: Plus Two Notes <reset-noreply@pluswonotes.com>\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				if(mail($adminEmail,$subject,$body,$headers)){
					$response = array(
						'success' => 1,
						'error' => 0
					);
				} else {
					$response = array(
						'success' => 0,
						'error' => 1,
						'errorMsg' => 'Email couldnot be sent!'
					);
				}

				$response = array(
					'success' => 1,
					'error' => 0,
					'resetLink' => $resetLink
				);
			}
		}
	}

}

echo json_encode($response);

?>