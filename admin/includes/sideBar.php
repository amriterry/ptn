<?php

echo '
<div id="navigation">
	<ul class="menu">
		<li>
			<a href="'.$website.'admin/" class="ico_home">Home</a>
		</li>
		<li>
			<a href="'.$website.'" target="_blank" class="ico_visitSite">Visit Site</a>
		</li>
		<li>
			<a href="#" class="ico_posts">Posts</a>
			<ul>';
			if($admin['roleId'] == 1){
				echo'
				<li><a href="'.$website.'admin/posts/" class="ico_managePosts">Manage posts</a></li>';
			} else if($admin['roleId'] == 2){
				echo'
				<li><a href="'.$website.'admin/posts/" class="ico_managePosts">Manage Posts</a></li>';
			} else if($admin['roleId'] == 3){
				echo '
				<li><a href="'.$website.'admin/posts/add.php" class="ico_addPost">Add posts</a></li>
				<li><a href="'.$website.'admin/posts/" class="ico_managePosts">View posts</a></li>';
			}

			if($admin['roleId'] != 3){
				echo '
				<li><a href="'.$website.'admin/posts/trash.php" class="ico_trashPosts">Trash</a></li>';
			}
			
			echo '
			</ul>
		</li>

		<li>
			<a href="#" class="ico_admins">Admins</a>
			<ul>';

				if($admin['roleId'] == 1){
					echo '
					<li><a href="'.$website.'admin/profile/add.php" class="ico_addAdmin">Add Admins</a></li>
					<li><a href="'.$website.'admin/profile/manage.php" class="ico_manageAdmins">Manage Admins</a></li>';
				} 
				echo '
				<li><a href="'.$website.'admin/profile/edit.php" class="ico_editAdmin">Edit Your Profile</a></li>
			</ul>
		</li>
		<li>
			<a href="'.$website.'admin/logout.php" class="ico_logout">Log Out</a>
		</li>
	</ul>
</div>';

?>