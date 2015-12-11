<?php

require("../includes/conf.inc.php");
require("../includes/functions.inc.php");

$sq = $_POST['search'];
$sqn = sanitize_text($sq);

$searchResult = post::searchPosts($sqn,'');

if($searchResult == false){
	echo $e;
} else if($searchResult == 'empty'){
	echo '<span class="search-wait">No Results Found</span>';
} else {
	$srOutput = '';
	foreach($searchResult as $sr){
		$srOutput .= '<a href="'.generate_link($sr['postTitle'],$sr['postId']).'">'.$sr['postTitle'].'</a>';
	}
	echo $srOutput;
}
?>