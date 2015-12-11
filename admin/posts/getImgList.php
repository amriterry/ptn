<?php

$path = "../../contents/img/";
$thumb_path = "../../contents/thumbs/";
require("../../includes/functions.inc.php");

if(is_dir($path)){

	$dir_handle = opendir($path);

	$img = array();
	$i = 0;
	while(($dir = readdir()) !== false){
		if(is_dir($dir)){
			continue;
		} else {
			$extensions = array('jpg','jpeg','png','gif');
			if(in_array(get_ext($dir),$extensions)){
				$img[$i]['imgName'] = $dir;
				$imgSize = getimagesize($path.$dir);
				$img[$i]['imgWidth'] = $imgSize[0];
				$img[$i]['imgHeight'] = $imgSize[1];
				$img[$i]['imgPath'] = $path.$dir;
				$img[$i]['thumbPath'] = $thumb_path.$dir.'.thumb.'.get_ext($dir);
				$img[$i]['fileSize'] = filesize($path.$dir);
				if(!file_exists($img[$i]['thumbPath'])){
					resize_img($path,$dir,$thumb_path,100,'thumb');
				}
				$i++;
			} else {
				continue;
			}
		}
	}

	closedir();

	echo json_encode($img);

}

?>