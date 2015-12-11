<?php

require_once("../../includes/conf.inc.php");
require_once("../../includes/functions.inc.php");

if(isset($_SESSION['login'])){
$adminId = $_SESSION['adminId'];
$admin = get_admin_info($adminId);

$postTrash = post::all(3);

if($postTrash == 'empty'){
	echo "<center><img src=\"../../assets/img/smile_face.png\" /><h4 style=\"color:#AAA;\">Yay! No posts in trash.</h4></center>";
} else {
	echo '
	<table class="tbl_list" cellspacing="0">
		<tr>
		<td>Id</td>
		<td width="200">Title</td>
		<td>Date</td>
		<td>Class</td>
		<td>Faculty</td>
		<td>Subject</td>
		<td>Category</td>
		<td>File</td>
		<td>Posted By</td>
		<td>Imp?</td>
		<td>Actions</td>
	</tr>';
	
	foreach($postTrash  as $post){
		
		echo '
		<tr data-postId="'.$post['postId'].'" data-postTypId="'.$post['postTypId'].'">
		<td>'.$post['postId'].'</td>
		<td>'.$post['postTitle'].'</td>
		<td>'.$post['postDate'].'</td>
		<td>'.$post['class'].'</td>
		<td>'.$post['facultyName'].'</td>
		<td>'.$post['subjectName'].'</td>
		<td>'.$post['postTyp'].'</td>
		<td>';
		if($post['fileName'] != NULL){
			echo '<a href="'.$website.$post['fileUrl'].'">'.$post['fileName'].'</a>';
		} else {
			echo "<strong>N/A</strong>";
		}
		echo '
		</td>
		<td>'.$post['firstName'].' '.$post['lastName'].'</td>
		<td>';
		if($post['imp'] == 1){ echo 'Yes'; } else { echo 'No'; }
		echo '
		<td>';
	
		if($admin['roleId'] == 1){
			echo '<a href="#" class="ico_delete permanentDel" data-postId="'.$post['postId'].'"></a>';
		}

		echo '
		<a href="#" class="ico_restore restorePost" data-postId="'.$post['postId'].'" ></a></td>';
	}
	
	echo '
	</tr>
	</table>';

}
}
?>