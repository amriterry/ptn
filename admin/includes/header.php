<?php

if(!$admin['roleId'] == 1){

	$query = "SELECT * FROM message WHERE message.seenStatus = 1";
	$result = mysql_query($query,$conn);
	
	if(!$result){
		echo "";
	} else {
		$num_msg = mysql_num_rows($result);
	}
}

echo
'<header id="header">
	<hgroup class="wrapper">
		<span>Plus Two Notes | Admin Panel</span>
		<div id="adminInfo">
			Howdy! <span>'.$admin['firstName'].'</span> , '.$admin['roleName'].'	
		</div>';
		if(isset($_SESSION['login'])){
			echo '<a href="#" class="menu_link"></a>';
		}
		echo '
		<div class="cleaner"></div>
	</hgroup>
</header>';

?>