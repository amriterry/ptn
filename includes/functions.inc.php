<?php
require("models/subject.php");
require("models/post.php");
require("models/comment.php");
require("models/like.php");
require("models/user.php");

function truncate($txt,$limit){
$ellipsis = '...';
$length = strlen($txt);
if($length > $limit){
	$truncated_txt = trim(substr($txt,0,$limit)).$ellipsis;
} else {
	$truncated_txt = $txt;
}
return $truncated_txt;	
}

function getRandomString($length,$validChars) {
	if($validChars == 'all'){
		$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
	} else {
		$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
	}
	
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
}


function ago($time)
{
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","1","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] ago ";
   //return count($lengths) - 1;
 }


function sanitize_text($text){
	$newtext = trim($text);
	$newtext = mysql_real_escape_string($newtext);
	$sanitaized_text = htmlentities($newtext);
	return $sanitaized_text;
}

function generate_error_msg($text){
	echo '
	<div class="error">
		'.$text.'
	</div>';
}

function resize_img($src_dir,$fileName,$thumbs_dir,$new_width,$suffix){
	$image_size = getimagesize($src_dir.$fileName);
	$image_width = $image_size[0];
	$image_height = $image_size[1];
	$aspect_ratio = $image_width / $image_height;

	$new_height = $new_width / $aspect_ratio;

	if($new_width == 100 && ($new_width < $new_height)){
		$new_height = 100;
	}

	$new_image = imagecreatetruecolor($new_width, $new_height);

	$imgTyp = $image_size['mime'];

	if($imgTyp == 'image/jpeg'){
		$oldimg = imagecreatefromjpeg($src_dir.$fileName);
	} else if($imgTyp == 'image/png'){
		$oldimg = imagecreatefrompng($src_dir.$fileName);
	} else {
		$oldimg = imagecreatefromgif($src_dir.$fileName);
	}

	imagecopyresampled($new_image, $oldimg, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
	

	if($suffix == "thumb"){
		if($imgTyp == 'image/jpeg'){
			imagejpeg($new_image,$thumbs_dir.$fileName.'.thumb.jpg');
		} else if($imgTyp == 'image/png'){
			imagepng($new_image,$thumbs_dir.$fileName.'.thumb.png');
		} else {
			imagegif($new_image,$thumbs_dir.$fileName.'.thumb.gif');
		}
	} else {
		if($imgTyp == 'image/jpeg'){
			imagejpeg($new_image,$thumbs_dir.$fileName);
		} else if($imgTyp == 'image/png'){
			imagepng($new_image,$thumbs_dir.$fileName);
		} else {
			imagegif($new_image,$thumbs_dir.$fileName);
		}
	}
}

function get_ext($fileName){
	return substr(strrchr($fileName,'.'),1);
}

function get_admin_info($adminId){
	$query = "SELECT 
	admin.adminId,
	admin.firstName,
	admin.lastName,
	admin.username,
	admin.email,
	admin.phone,
	admin.roleId,
	roles.roleName 
	FROM admin 
	JOIN roles ON roles.roleId = admin.roleId 
	WHERE admin.adminId = '$adminId'";
	$result = mysql_query($query);
	if(!$result){
		$admin = mysql_error();
	}
	$admin = mysql_fetch_array($result);
	return $admin;
}

function generate_link($postTitle,$postId){
	$hypenChars = array(" ","!","~",",");
	$spaceRemovalChars = array(".","'","\"","?","(",")");
	$postTitle = strtolower($postTitle);
	$postTitleNew = str_replace($hypenChars,'-', $postTitle);
	$postTitleNew = str_replace($spaceRemovalChars,"",$postTitleNew);
	
	global $website;
	$url = $website.'posts/'.$postTitleNew.'/'.$postId;
	return $url;
}

?>