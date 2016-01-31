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
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					Thank you
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
					
					<div class="col-xs-12 text-center">
						<h2>Thank you</h2>
					</div>
					
					<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
						<p>
							&emsp;Your request has been sent to the administrator. You can expect to receive an email within
							two weeks with the name of your correspondent, as well as your password and instructions to log&nbsp;in.<br />
						</p>
                        <br />
						<p>
							Please be sure to check your spam&nbsp;filter.<br /><br />
						</p>
						<p>
							If you do not hear from anyone in two weeks, please contact
							<a href="mailto:<?php echo $gbl_admin['email']; ?>"><?php echo $gbl_admin['email']; ?></a>,
                            which is accessible via the Help Button at bottom of the page.
						</p>
						
					</div>
					
				</div>
				
				<br /><br />
				
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>