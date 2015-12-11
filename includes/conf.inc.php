<?php

	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "plustwonotes.com";
	$debug = false;
	$website = "http://".$_SERVER['HTTP_HOST']."/plus/";
	$salt = "Piuwr01#00r1@+1uH!froe*1?BoEb!iu)_1xApi(a)^&#(#AF";
	if($debug){
		$e = "error! Debug On";
	} else {
		$e = '<div style="font-family:\'Open Sans\',Segoe UI;text-align:center;border-radius:10px;border:1px solid #DDD;">
		<span style="background:#008ED7;font-size:1.25em;padding:0.25em;display:block;border-radius:10px 10px 0 0;">
			<a href="'.$website.'" style="color:#fff;text-decoration:none;">Plus Two Notes</a>
		</span>
		<span style="padding:1em;display:block;background:#333;color:#CCC;font-weight:bold;border-radius:0 0 10px 10px;text-shadow: 0px 1px 0px rgba(255,255,255,.3), 0px -1px 0px rgba(0,0,0,.7);">
			Opps! Something Went Wrong. Please Try Again Later
		</span>
		</div>';
	}
	
	$conn = @mysql_connect($host,$username,$password) or die($e);
	@mysql_select_db($db,$conn) or die($e);
	
	session_start();

	define('cmsVersion', '1.0');

?>