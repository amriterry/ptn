<?php

echo '<div id="postedit" class="clrscr">';

$conn = mysql_connect($dbinfo['host'],$dbinfo['username'],$dbinfo['password']);

if(!$conn){
echo "Opps! Something Went Wrong.";
} else {
$db_handle = mysql_select_db($dbinfo['name'],$conn);

if(!$db_handle){
echo "Opps! Something Went Wrong.";	
} else {

$query = "SELECT * FROM mstsubject
JOIN mstchapter ON mstchapter.subjectId = mstsubject.subjectId
JOIN mstfaculty ON mstfaculty.facultyId = mstfaculty.facultyId
JOIN mstclass ON mstclass.classId = mstfaculty.classId
WHERE mstsubject.userRelId = $adminId";

$result = mysql_query($query,$conn);

if(!$result){
echo "Opps! Something Went Wrong.";
} else {
echo'
<h2 class="ico_mug">Add a new Note</h2>

<form action="'.$website.'/admin/posts/post_note.php" method="post" name="noteForm">
Title of Note: <input type="text" name="noteTitle" placeholder="Type Title" size="140" id="noteTitle"/>
<br /><br />
Chapter: <select name="noteChapter">';

//giving chapter output
$result = mysql_query($query,$conn);
while ($chapter = mysql_fetch_array($result)){
echo '<option value="'.$chapter['chapterId'].'">'.$chapter['chapterName'].' ('.$chapter['class'].' '.$chapter['subjectName'].')</option>';
}

echo '</select>
<br /><br />
Note Content: <br /><br />
<textarea name="noteTxt" cols="115" rows="15" id="noteTxt"></textarea>
<br /><br />
<!--<input type="submit" name="previewNote" value="Preview" id="notePreview" class="btn"/>-->
<input type="submit" name="postNote" value="Post" class="btn"/>
</form>
</div>

<!--question-->
<div id="question" class="clrscr">
<h2 class="ico_mug">Add a New Question</h2>
<form action="" method="post">
Question: <input type="text" name="title" placeholder="Type Question" size="140"/>
<br /><br />
Chapter: <select name="qaChapter">';

//giving chapter output
$result = mysql_query($query,$conn);
while ($chapter = mysql_fetch_array($result)){
echo '<option value="'.$chapter['chapterId'].'">'.$chapter['chapterName'].' ('.$chapter['class'].' '.$chapter['subjectName'].')</option>';
}

echo '
</select>
<br /><br />
Answer:
<br /><br />
<textarea name="article" cols="115" rows="15" placeholder="Type Answer"></textarea>
<br /><br />
<!--<input type="submit" name="preview" value="Preview" class="btn"/>-->
<input type="submit" name="post" value="Post" class="btn"/>
</form>
</div>

<!--question set-->
<div id="question_set" class="clrscr">
<h2 class="ico_mug">Add a New Question Set</h2>
<form action="" method="post" name="questionSet">
Subject: <select name="qsSubject">';

$query = "SELECT * FROM mstSubject
		JOIN mstSubjectGroup ON mstSubjectGroup.subjectGroupId = mstSubject.subjectGroupId
		JOIN mstClass ON mstClass.classId = mstSubjectGroup.classId
		WHERE mstSubject.userRelId = '$adminId'";
		

//giving chapter output
$result = mysql_query($query,$conn);
while($subject = mysql_fetch_array($result)){
echo '
<option value="'.$subject['subjectId'].'">'.$subject['subjectName'].'('.$subject['class'].')'.'</option>';	
}

echo '
</select>
&nbsp;&nbsp;&nbsp;Exam: <select name="qsExam">';

$query = "SELECT * FROM mstExam";

//giving chapter output
$result = mysql_query($query,$conn);
while($exam = mysql_fetch_array($result)){
echo '
<option value="'.$exam['examId'].'">'.$exam['exam'].'</option>';	
}

echo '
</select>
&nbsp;&nbsp;&nbsp;Year: <select name="qsYear">';

$query = "SELECT * FROM mstYear";

//giving chapter output
$result = mysql_query($query,$conn);
while($year = mysql_fetch_array($result)){
echo '
<option value="'.$year['yearId'].'">'.$year['year'].'</option>';	
}

echo '
</select>
<br /><br />
<textarea name="article" cols="115" rows="15"></textarea>
<br /><br />
<!--<input type="submit" name="preview" value="Preview" class="btn"/>-->
<input type="submit" name="post" value="Post" class="btn"/>
</form>
</div>';

//checking if the subject has numerical section or not??
$numStatQuery = "SELECT * FROM mstSubject WHERE mstSubject.numStatus = 1 AND mstSubject.userRelId = '$adminId'";
$numStatResult = mysql_query($numStatQuery,$conn);
if(!$numStatResult){
	echo "Opps! Something went wrong";
} else {
	$numStatTrue = mysql_num_rows($numStatResult);
	if($numStatTrue != 0){
echo '
<!--numerical-->
<div id="question_set" class="clrscr">
<h2 class="ico_mug">Add a Numerical</h2>
<form action="" method="post" name="numerical">
Chapter: <select name="qsSubject">';

$query = "SELECT * FROM mstChapter
		JOIN mstSubject ON mstSubject.subjectId = mstChapter.subjectId
		JOIN mstSubjectGroup ON mstSubjectGroup.subjectGroupId = mstSubject.subjectGroupId
		JOIN mstClass ON mstClass.classId = mstSubjectGroup.classId
		WHERE mstSubject.userRelId = '$adminId' AND mstSubject.numStatus = 1";
		

//giving chapter output
$result = mysql_query($query,$conn);
while($chapter = mysql_fetch_array($result)){
echo '
<option value="'.$chapter['subjectId'].'">'.$chapter['chapterName'].'('.$chapter['class'].' - '.$chapter['subjectName'].')'.'</option>';	
}

echo '
</select>
<br /><br />
Numerical Question: <br />
<textarea name="numerical" cols="115" rows="10"></textarea>
<br /><br />
Answer: <input type="text" size="50" name="ans" placeholder="Answer of Numerical"/><br /><br />
<!--<input type="submit" name="preview" value="Preview" class="btn"/>-->
<input type="submit" name="post" value="Post" class="btn"/>
</form>
</div>';

	}
}

//checking if the subject has practical section or not?
$checkPracQuery = "SELECT * FROM mstSubject WHERE mstSubject.pracStatus = 1 AND mstSubject.userRelId = '$adminId'";
$checkPracResult = mysql_query($checkPracQuery,$conn);
if(!$checkPracResult){
	echo "Opps! Something went wrong";
} else {
	$numPracTrue = mysql_num_rows($checkPracResult);
	if($numPracTrue != 0){
echo '
<!--practical-->
<div id="question_set" class="clrscr">
<h2 class="ico_mug">Add a Practical</h2>
<form action="" method="post" name="practical">
Subject: <select name="pracSubject">';

$query = "SELECT * FROM mstSubject
		JOIN mstSubjectGroup ON mstSubjectGroup.subjectGroupId = mstSubject.subjectGroupId
		JOIN mstClass ON mstClass.classId = mstSubjectGroup.classId
		WHERE mstSubject.userRelId = '$adminId' AND mstSubject.pracStatus = 1";
		

//giving chapter output
$result = mysql_query($query,$conn);
while($chapter = mysql_fetch_array($result)){
echo '
<option value="'.$chapter['subjectId'].'">'.$chapter['class'].' - '.$chapter['subjectName'].'</option>';	
}

echo '
</select>
<br /><br />
Youtube Link: <input type="text" size="75" name="ans" placeholder="Practical Link"/><br /><br />
Practical Description: <br />
<textarea name="numerical" cols="115" rows="7"></textarea>
<br /><br />
Practical Procedure: <br />
<textarea name="numerical" cols="115" rows="15"></textarea>
<br /><br />
<!--<input type="submit" name="preview" value="Preview" class="btn"/>-->
<input type="submit" name="post" value="Post" class="btn"/>
</form>
</div>';
	}
}

}

//db is closed
}

}

?>