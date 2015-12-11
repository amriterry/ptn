<?php
echo '<aside id="right-nav">
		
			<div class="news">
				<h2>Recent <span>Posts</span></h2>';
$rpContents = post::rp();
if($rpContents == 'empty'){
	echo '<center><img src="'.$website.'assets/img/smile_face.png" /><br /><p style="color:#AAA;font-size:1.5em;">No Recent Posts to Show</p></center>';
} else {
	foreach($rpContents as $rp){
		$dateArray = getdate(strtotime($rp['postDate']));
		echo '<a href="'.generate_link($rp['postTitle'],$rp['postId']).'" class="rp-link">
					<div class="rp">
						<span class="date"><span>'.$dateArray['mday'].'</span><br /><span>'.substr($dateArray['month'],0,3).'</span></span>
						<h3>'.$rp['postTitle'].'</h3>
						<p>'.$rp['class'].' | '.$rp['facultyName'].' | '.$rp['subjectName'].' | '.$rp['postTyp'].'</p>
						<div class="cleaner"></div>
					</div><!--end of .rp -->
					<div class="cleaner"></div>
				</a><!--end of .rp-link -->';
	}
}
	
echo '	
			</div> <!--end of .news --> 	

			<div class="news">
				<h2>We are <span>Social</span></h2>
				<div id="social-sites">
					<a href="https://www.facebook.com/plustwonotes"><img src="'.$website.'assets/img/facebook.png" alt="Plus Two Notes Facebook Page"/></a>
					<a href="https://plus.google.com/+Plustwonotespage/"><img src="'.$website.'assets/img/googleplus.png" alt="Plus Two Notes Google+ Page"/></a>
					<a href="https://www.youtube.com/user/plustwonotes"><img src="'.$website.'assets/img/youtube.png" alt="Plus Two Notes Youtube Channel"/></a>
				</div>
			</div><!-- end of .news -->
			
		</aside><!-- end of #right-nav -->';

?>