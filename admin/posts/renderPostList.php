<?php

require_once("../../includes/conf.inc.php");
require_once("../../includes/functions.inc.php");

if(isset($_SESSION['login'])){
$adminId = $_SESSION['adminId'];
$admin = get_admin_info($adminId);

$posts = post::all();

if($posts== 'empty'){
	echo "<center><img src=\"../../assets/img/smile_face.png\" /><h4 style=\"color:#AAA;\">There are no posts yet.</h4></center>";
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
		<td width="80">Status</td>
	</tr>';

	
	
	//while($post = mysql_fetch_array($selResult)){
	foreach($posts as $post){
	
		if($post['statusId'] == 1){
			$status = "Posted";
			$statusColor = "#008ED7";
		} else if($post['statusId'] == 2){
			$status = "Pending";
			$statusColor="#F58100";
		}
		
		echo '
		<tr data-postId="'.$post['postId'].'">
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
		<td width="8%">';

		if($post['statusId'] == 1){
			echo '<a href="'.generate_link($post['postTitle'],$post['postId']).'" class="ico_preview" target="_blank"></a>';

			if($admin['roleId'] == 1){
				echo '
				<a href="javascript:void(0)" data-postId="'.$post['postId'].'" class="ico_delete postDel"></a>';
			} else if($admin['roleId'] == 2){
				echo ' 
				<a href="edit.php?id='.$post['postId'].'" target="_blank" class="ico_edit"></a> <a href="javascript:void(0)" data-postId="'.$post['postId'].'" class="ico_delete postDel"></a>';
			} else {
				if($post['adminId'] == $adminId){
					echo '
					<a href="edit.php?id='.$post['postId'].'" target="_blank" class="ico_edit"></a>';
				}
			}
		} else{
			if($admin['roleId'] == 1){
				echo '
				<a href="javascript:void(0)" data-postId="'.$post['postId'].'" class="ico_delete postDel"></a>';
			} else if($admin['roleId'] == 2){
				echo '
				<a href="javascript:void(0)" data-postId="'.$post['postId'].'" class="ico_pending postPend"></a>
				<a href="edit.php?id='.$post['postId'].'" target="_blank" class="ico_edit"></a>
				<a href="javascript:void(0)" data-postId="'.$post['postId'].'" class="ico_delete postDel"></a>';
			} else {
				if($post['adminId'] == $adminId){
					echo '<a href="edit.php?id='.$post['postId'].'" target="_blank" class="ico_edit"></a>';
				} else {
					echo 'No Action';
				}
			}
		}

		echo '</td>
		<td id="td'.$post['postId'].'" style="color:'.$statusColor.';">'.$status.'</td>';
	}
	
	echo '
	</tr>
	</table>';

}
}
?>