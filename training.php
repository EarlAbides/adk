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
			
			<?php if($_SESSION['ADK_USERGROUP_CDE'] === 'COR'){ ?>
				<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 content content-max" style="margin-bottom:15px;">
				
					<h4 class="content-header">
						Correspondent Training Videos
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>

					<iframe src="https://player.vimeo.com/video/193636304" style="width:94%;min-height:315px;margin:0 3%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
					<br /><br />
					<iframe src="https://player.vimeo.com/video/207014065" style="width:94%;min-height:315px;margin:0 3%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				
				</div>
			<?php } ?>

			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 content content-max">
				
				<h4 class="content-header">
					Hiker Training Videos
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>

				<iframe src="https://player.vimeo.com/video/207014061" style="width:94%;min-height:315px;margin:0 3%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
				
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>
