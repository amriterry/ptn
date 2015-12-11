<?php

$query = "SELECT classId FROM mstclass";
$result = mysql_query($query);
$numClass = mysql_num_rows($result);

$query = "SELECT facultyId FROM mstfaculty";
$result = mysql_query($query);
$numSubjectGroup = mysql_num_rows($result);

$query = "SELECT subjectId FROM mstsubject";
$result = mysql_query($query);
$numSubject = mysql_num_rows($result);

$query = "SELECT postId FROM posts WHERE posts.statusId = 1 AND posts.postTypId = 1";
$result = mysql_query($query);
$notes = mysql_num_rows($result);

$query = "SELECT postId FROM posts WHERE posts.statusId = 1 AND posts.postTypId = 2";
$result = mysql_query($query);
$qa = mysql_num_rows($result);

$query = "SELECT postId FROM posts WHERE posts.statusId = 1 AND posts.postTypId = 3";
$result = mysql_query($query);
$syllabus = mysql_num_rows($result);

$query = "SELECT postId FROM posts WHERE posts.statusId = 1 AND posts.postTypId = 4";
$result = mysql_query($query);
$refrence = mysql_num_rows($result);

$query = "SELECT postId FROM posts WHERE posts.statusId = 1 AND posts.postTypId = 5";
$result = mysql_query($query);
$qs = mysql_num_rows($result);

if($admin['roleId'] == 3){
	$query = "SELECT postId FROM posts WHERE posts.adminId='$adminId' AND posts.postTypId = 1 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingNotes = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.adminId='$adminId' AND posts.postTypId = 2 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingQa = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.adminId='$adminId' AND posts.postTypId = 3 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingSyllabus = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.adminId='$adminId' AND posts.postTypId = 4 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingRefrence = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.adminId='$adminId' AND posts.postTypId = 5 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingQs = mysql_num_rows($result);

} else {
	$query = "SELECT postId FROM posts WHERE posts.postTypId = 1 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingNotes = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.postTypId = 2 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingQa = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.postTypId = 3 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingSyllabus = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.postTypId = 4 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingRefrence = mysql_num_rows($result);

	$query = "SELECT postId FROM posts WHERE posts.postTypId = 5 AND posts.statusId = 2";
	$result = mysql_query($query);
	$pendingQs = mysql_num_rows($result);
}


echo '
<div id="dashboard" class="clrscr">
	<h3 class="ico_mug">Dashboard</h3>
	<div class="quickview">
		<h5>Overview</h5>
		<ul>
			<li>Total Class: <span class="number">'.$numClass.'</span></li>
			<li>Total Faculty: <span class="number">'.$numSubjectGroup.'</span></li>
			<li>Total Subjects: <span class="number">'.$numSubject.'</span></li>
			<li>Posted Notes: <span class="number">'.$notes.'</span></li>
			<li>Posted Question Anwers: <span class="number">'.$qa.'</span></li>
			<li>Posted Syllabus: <span class="number">'.$syllabus.'</span></li>
			<li>Posted Refrence Books: <span class="number">'.$refrence.'</span></li>
			<li>Posted Question Sets: <span class="number">'.$qs.'</span></li>
			<li>Total Posted: <span class="number">'.($notes+$qa+$syllabus+$refrence+$qs).'</span></li>
			<li>'; if($admin['roleId'] == 3){ echo 'Your '; } echo 'Pending Notes: <span class="number">'.$pendingNotes.'</span></li>
			<li>'; if($admin['roleId'] == 3){ echo 'Your '; } echo 'Pending Question Answers: <span class="number">'.$pendingQa.'</span></li>
			<li>'; if($admin['roleId'] == 3){ echo 'Your '; } echo 'Pending Syllabus: <span class="number">'.$pendingSyllabus.'</span></li>
			<li>'; if($admin['roleId'] == 3){ echo 'Your '; } echo 'Pending Refrence Books: <span class="number">'.$pendingRefrence.'</span></li>
			<li>'; if($admin['roleId'] == 3){ echo 'Your '; } echo 'Pending Question Sets: <span class="number">'.$pendingQs.'</span></li>
			<li>'; if($admin['roleId'] == 3){ echo 'Your '; } echo 'Total Pending Posts: <span class="number">'.($pendingNotes+$pendingQa+$pendingSyllabus+$pendingRefrence+$pendingQs).'</span></li>
		</ul>
	</div>	  
</div>';

?>