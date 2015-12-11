<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	$adminId = $_SESSION['adminId'];
	$admin = get_admin_info($adminId);
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />	
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>Plus Two Notes | Add Post</title>
	
	<?php require("../includes/links.php"); ?>

	<link href="../css/uploadfile.css" rel="stylesheet">
	<script src="../js/jquery.uploadfile.js"></script>
	<script src="../js/ckeditor/ckeditor.js"></script>

	<script>

	$(document).ready(function()
	{
		$("#fileuploader").uploadFile({
			url:"uploadImg.php",
			fileName:"file",
			allowedTypes: "jpg,jpeg,png,gif",
			maxFileSize: "1048576",
			uploadButtonClass:"ajax-file-upload-green",
			showStatusAfterSuccess:false,
			showAbort:true,
			showDone:false,
			afterUploadAll:function(){
				$.ajax({
					dataType: 'json',
					url: "getImgList.php",
					success:function(data){
						$("#imgThumbContainer").html('');
						for(i = 0;i < data.length;i++){
							renderImg(data[i]);
						}
					}
				});
			}
		});

		CKEDITOR.replace( 'postText', {
		    contentsCss: '../css/content_text.css',
		    height: '300px'
		});
	});

	</script>
</head>
<body>

<!--header-->
<?php  require("../includes/header.php"); ?>

<div id="notice">
    <h5>Post Submission Status</h5>
    <p></p>
    <a href="#" class="anchor-btn" id="ok">Okay</a>
    <br /><br />
    <div class="cleaner"></div>
</div>

<div id="imgListDialog">
	<div class="heading">
		<span>Image Explorer</span><span class="right cross"> </span>
		<div class="cleaner"></div>
	</div>
	
	<div id="imgThumbContainer"></div>
	<div id="imgOptions">
		<div id="imgDetail">
			<h6>Image Detail</h6>
			<p></p>
		</div>

		<div id="imgUploadContainer">
			<div id="fileuploader">Upload</div>
		</div>
	</div>
</div>

<div id="main">

	<?php require("../includes/sideBar.php"); ?>
		
	<div id="rightCol">
		<?php require("../includes/dashboard.php"); ?>

		<div class="clrscr">
			<h2 class="ico_mug">Add a new Post</h2>
			<form action="post.php" method="post">
				Post Title: <input type="text" name="postTitle" size="100" style="margin-bottom:0.5em;width:100%;"/><br />
				<div class="subject select">Subject:
					<span id="subjectSpan">	
					<?php	
						$query = "SELECT 
						mstsubject.subjectId,
						mstsubject.subjectName,
						mstfaculty.facultyName,
						mstclass.class FROM mstsubject
						JOIN mstfaculty ON mstfaculty.facultyId = mstsubject.facultyId
						JOIN mstclass ON mstclass.classId = mstfaculty.classId";
						$result = mysql_query($query,$conn) or die("Error");
						echo '
						<select id="subject" name="class">
						<option value="0">-N/A-</option>';
						while($class = mysql_fetch_array($result)){
						echo "
						<option value=".$class['subjectId'].">".$class['subjectName'].' '.$class['facultyName'].' '.$class['class']."</option>";	
						}
						echo '
						</select>';
					?>
					</span>
				</div> 

				<div class="postTyp select">Post Type: 
					<span id="postTypSpan">
						<select id="postTyp" name="postTyp">
						<?php
							$query = "SELECT * FROM mstposttyp";
							$result = mysql_query($query);

							$response = '<option value="0">-N/A-</option>';
							while($postTyp = mysql_fetch_array($result)){
									$response = $response."
									<option value=".$postTyp['postTypId'].">".$postTyp['postTyp']."</option>";
							}

							echo $response;
						?>
						</select>
					</span>
				</div>				
				<br />

				<span class="anchor-btn" id="imgExp" style="margin-right:1em;">Image Explorer</span>

				<input type="checkbox" name="imp"> Imp
				<br /><br />
				<textarea id="postText" name="postText" style="height:400px;" height="400px" name="textArea" id="postText"></textarea>
				<br />
				<input disabled="disabled" id="submitPost" type="submit" name="post" class="btn" value="Request to Publish"/>
		</form>
		</div>

		<?php require('../includes/footer.php'); ?>

	</div>
</div>
</body>
</html>