<?php require_once 'includes/session.php'; ?>
<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php include 'includes/variables_site.php'; ?>

<?php include 'includes/head.php'; ?>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					News
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<div class="container-fluid">
					<div class="col-xs-12 text-center">
						<img src="img/adk_logo2.png" class="img-responsive" style="opacity:0.7;display:inline;" />
					</div>
				</div>
					
				<div class="container-fluid">
					
					<div class="col-xs-12 col-sm-10 col-sm-offset-1">

						<h3 class="text-center">ADK 46er Correspondents Meeting</h3>
						<h4 class="text-right">January 16th 2016</h4>
						
						<p class="text-center">
							Click below to download the meeting minutes from the first correspondent meeting.
						</p>

						<div class="text-center" style="width:100%;">
							<a href="https://drive.google.com/file/d/0B2sofMrC5zc2ZkF0c3d6LWs1aUU/view?usp=sharing" target="_blank" class="hoverbtn ">
								<img src="img/1-16-16 meeting.png" style="max-height:300px;" />
							</a>
						</div>
						
					</div>
					
				</div>
				
				<br /><br />
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
</body>
</html>