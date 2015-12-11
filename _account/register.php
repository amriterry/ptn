<?php
	require("../includes/conf.inc.php");
	require("../includes/functions.inc.php");

?>

<!doctype html>
<html lang="en">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<head>
	
	<title>Plus Two Notes</title>
	
	<?php require("../includes/links.inc.php"); ?>

	<style>
	body{
		background: #001C2E url(../assets/img/seamless-login-bg.jpg) no-repeat center center fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		color:#fff;
	}
	</style>

</head>
<body>

<div class="formWarning">asfasd</div>

<div id="page">

	<div class="wrapper">
	
		<section class="registerformpage">
			<a href="<?php echo $website; ?>"><img src="<?php echo $website; ?>assets/img/header-logo.png"></a>
			<h2 class="userAccounts-heading">CREATE AN ACCOUNT</h2>
			<a href="login.php" class="userAccounts">LOGIN</a>
			<form action="register-test.php" method="post" id="register-form">
				<table>
					<tr>
						<td>
							<span>FIRST NAME:</span><br />
							<input type="text" name="firstName" placeholder="FIRST NAME" maxlength="30" />
						</td>
					</tr>
					<tr>
						<td>
							<span>LAST NAME:<br />
							<input type="text" name="lastName" placeholder="LAST NAME" maxlength="30"/>
						</td>
					</tr>
					<tr>
						<td>
							<span>EMAIL:<br />
							<input type="email" name="email" placeholder="EMAIL" maxlength="50"/>
						</td>
					</tr>
					<tr>
						<td>
							<span>PASSWORD:<br />
							<input type="password" name="password" placeholder="PASSWORD"/>
						</td>
					</tr>
					<tr>
						<td>
							<span>RE-ENTER PASSWORD:<br />
							<input type="password" name="password" placeholder="RE-ENTER PASSWORD"/>
						</td>
					</tr>
					<tr>
						<td>
							<span>INSTITUTION:<br />
							<select id="institutionList">
								<option value="NULL">Choose Your Institution</option>
								<?php
									$institutionListQuery = "SELECT * FROM institutions";
									$institutionListResult = mysql_query($institutionListQuery) or die("Error");

									while ($institution = mysql_fetch_array($institutionListResult)) {
										echo '<option value="'.$institution['institutionId'].'">'.$institution['institutionName'].'</option>';
									}
								?>
							</select><br />
							<p id="addInstitutionOptTrigger">NOT IN THE LIST? <a href="javascript:void(0)" id="addInstitution" class="userAccounts">+ADD ONE</a></p>
							<p id="addInstitutionOpt">
								<input type="text" name="institutionName" placeholder="Institution Name" id="institutionName" maxlength="50"/><br />
								<a href="javascript:void(0)" class="anchor-btn">ADD INSTITUTION TO LIST</a>
							</p>
							<p id="addInstitutionOptFeedback" style="display:none;"></p>
						</td>
					</tr>
					<tr>
						<td>
							<span>INTEGRATE SUBJECTS :<br />
							<?php

								$subListQuery = "SELECT subjectId,subjectName,facultyName,class FROM mstsubject 
								JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
								JOIN mstclass ON mstclass.classId = mstfaculty.classId";

								$subListResult = mysql_query($subListQuery) or die("Error");

								while($subject = mysql_fetch_array($subListResult)) {
									echo '<input type="checkbox" name="'.$subject['subjectId'].'" /> '.$subject['class'].' - '.$subject['facultyName'].' - '.$subject['subjectName'].' <br />';
								}

							?>
						</td>
					</tr>
					<tr>
						<td>
							<center>
								<input type="submit" name="register" value="Create Your Account" />
							</center>
						</td>
					</tr>
				</table>
			</form>
		</section>

	</div>

</div>

</body>
</html>