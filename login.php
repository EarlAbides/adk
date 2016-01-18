<?php require_once 'includes/session.php'; ?>
<?php $page = explode("/", $_SERVER['REQUEST_URI']); $page = array_pop($page);?>

<?php include 'includes/head.php'; ?>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 content content-max">
					
				<div class="container-fluid">
					
					<h4 class="content-header">Log In</h4>
					
					<form id="form_login" action="includes/login.php" method="post" class="form-inline" data-toggle="validator" data-disable="false" role="form" novalidate>
						
						<div class="form-group<?php if(isset($haserror)) echo $haserror;?>">
							<div class="col-xs-12">
								<label for="textbox_username" class="control-label control-label-sm">Username</label><br />
								<input type="text" id="textbox_username" name="username" class="form-control form-control-sm" maxlength="40" placeholder="Username" required />
								<span class="help-block with-errors"></span>
							</div>
						</div>
						
						<div class="form-group<?php if(isset($haserror)) echo $haserror;?>">
							<div class="col-xs-12">
								<label for="textbox_password" class="control-label control-label-sm">Password</label><br />
								<input type="password" id="textbox_password" name="password" class="form-control form-control-sm" maxlength="40" placeholder="Password" required />
								<span class="help-block with-errors"></span>
							</div>
						</div>
						
						<br /><br />
						
						<div class="col-xs-12">
							<div class="container-fluid">
								<div class="col-xs-6">
									<a href="./forgot" style="font-size:0.8em;">Forgot password?</a>
								</div>
								<div class="col-xs-6">
									<button type="submit" id="button_submit" class="btn btn-sm btn-default pull-right" style="margin:4px 4px 0 0;">Log in</button>
								</div>
							</div>
						</div>
						
						<input type="hidden" name="page" value="<?php echo $page;?>" />
							
					</form>
					
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
</body>
</html>