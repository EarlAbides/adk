<?php require_once 'includes/session.php'; ?>
<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php include 'includes/variables_site.php'; ?>

<?php include 'templates/head.php'; ?>
</head>

<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'templates/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 content content-max">
				
				<h4 class="content-header">
					Leave No Trace
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<iframe src="https://www.youtube.com/embed/rO7V3UayreE?list=PLuekIhaoBuWZ0c4R2jd3RE4PgjDwg9NOp" style="width:94%;min-height:315px;margin:0 3%;" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
								
				<br /><br />

				<div class="text-center">
					<h4><a href="https://lnt.org/" target="_blank">https://lnt.org/</a></h4>
				</div>

				<div class="hr hr75"></div>

				<h4 class="content-header">One for the kids...</h4>
				
				<div id="fb-root"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";  fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class="fb-video" data-allowfullscreen="1" data-href="/LeaveNoTraceCenter/videos/vb.7922603659/10153582423023660/?type=3"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/LeaveNoTraceCenter/videos/10153582423023660/"><a href="https://www.facebook.com/LeaveNoTraceCenter/videos/10153582423023660/">Learning the 7 Leave No Trace Principles</a><p>Learn, remember, and teach the #LeaveNoTrace Seven Principles in a fun and interactive way!  Curious about some of the things we said in the video?  Trek through our other blogs to find out more: https://lnt.org/blog/learning-7-principles</p>Posted by <a href="https://www.facebook.com/LeaveNoTraceCenter/">Leave No Trace Center for Outdoor Ethics</a> on Wednesday, April 6, 2016</blockquote></div></div>
								
				<br /><br />
				
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>