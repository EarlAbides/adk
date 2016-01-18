<?php require_once 'includes/session.php'; ?>
<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php include 'includes/variables_site.php'; ?>

<?php include 'includes/head.php'; ?>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
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
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
</body>
</html>