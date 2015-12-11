<?php
$output_dir = "../../contents/img/";
$thumbs_dir = "../../contents/thumbs/";
require("../../includes/functions.inc.php");

if(isset($_FILES["file"]))
{
	$ret = array();
	
//	This is for custom errors;	
/*	$custom_error= array();
	$custom_error['jquery-upload-file-error']="File already exists";
	echo json_encode($custom_error);
	die();
*/
	$error =$_FILES["file"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["file"]["name"])) //single file
	{
 	 	$fileName = $_FILES["file"]["name"];

 		move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir.$fileName);


 	 	$imgSize = getimagesize($output_dir.$fileName);
 	 	if($imgSize[0] > 600){
 	 		resize_img($output_dir,$fileName,$output_dir,600,'');
 	 	}
 		
 		resize_img($output_dir,$fileName,$thumbs_dir,100,'thumb');
 		
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
	  $fileCount = count($_FILES["file"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["file"]["name"][$i];
		move_uploaded_file($_FILES["file"]["tmp_name"][$i],$output_dir.$fileName);

		$imgSize = getimagesize($output_dir.$fileName);
 	 	if($imgSize[0] > 600){
 	 		resize_img($output_dir,$fileName,$output_dir,600,'');
 	 	}
 		
 		resize_img($output_dir,$fileName,$thumbs_dir,100,'thumb');

	  	$ret[]= $fileName;
	  }
	
	}
    echo json_encode($ret);
 }
 ?>