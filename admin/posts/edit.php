<?php

require("../../includes/conf.inc.php");
require("../../includes/functions.inc.php");

if(!isset($_SESSION['login'])){
	$_SESSION['error'] = 2;
	header("location: ../login.php");	
} else {
	
	$adminId = $_SESSION['adminId'];
	$admin = get_admin_info($adminId);
	
	if($admin['roleId'] == 1){
		header("location: ../posts/");
	}
	
	if(!isset($_GET['id'])){
		header("location: ../posts/");							 
	} else {
		$id = intval($_GET['id']);
		$post = post::view($id,2);
	
		if($post == 'empty'){
			header("location: ../posts/");
		}
	}
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>Plus Two Notes | Post Editor</title>
	<?php require("../includes/links.php"); ?>

	<link href="../css/uploadfile.css" rel="stylesheet">
	<script src="../js/jquery.uploadfile.js"></script>
	<script src="../js/tinymce/tinymce.min.js"></script>
	<script src="../js/ckeditor/ckeditor.js"></script>
	<script>	
	$(document).ready(function(){
		
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
<?php include("../includes/header.php"); ?>

<div id="notice">
    <h5>Post Update Status</h5>
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
			<h5>Image Detail</h5>
			<p></p>
		</div>

		<div id="imgUploadContainer">
			<div id="fileuploader">Upload</div>
		</div>
	</div>
</div>

<div id="main">


<?php include("../includes/sideBar.php"); ?>

<div id="rightCol">

<?php include("../includes/dashboard.php"); ?>

<div class="clrscr">
<h2 class="ico_mug">Post Editor</h2>
<form action="update.php" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>">
Post Title: <input type="text" name="postTitle" style="width:100%;"size="100" value="<?php echo $post['postTitle']; ?>"/><br /><br />
<p class="postDetail">
<b>Post Type: </b><?php echo $post['postTyp']; ?><br />
<b>Class: </b><?php echo $post['class']; ?><br>
<b>Faculty: </b><?php echo $post['facultyName']; ?><br>
<b>Subject: </b><?php echo $post['subjectName']; ?><br>
<b>Status: </b><span class="postStatus"><?php if($post['statusId'] == 1){ echo "Posted";} else {echo "Pending";} ?></span>
</p>
<span class="anchor-btn" id="imgExp" >Image Explorer</span>
<?php
if($post['statusId'] == 1){
	echo '<a href="'.generate_link($post['postTitle'],$post['postId']).'" target="_blank" class="anchor-btn">View This Post</a>';
}
?>
<input type="checkbox" style="margin-left:1em;" name="imp" <?php if($post['imp'] == 1){ echo 'checked'; } ?>> Imp
<br /><br />


<textarea id="postText" name="postText" style="height:400px;width:100%;" name="textArea"><?php echo $post['postText']; ?></textarea>
<br />
<input type="submit" id="updatePost" name="update" class="btn" value="Update"/> <?php if(($post['statusId'] == 2) && ($admin['roleId'] == 2)){ echo '<input type="button" class="btn" value="Publish" id="publishBtn" />'; } ?>
</form>
</div>

	<?php require '../includes/footer.php'; ?>

</div>
</div>
</body>
</html>