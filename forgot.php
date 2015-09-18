<?php require_once 'includes/session.php';?>
<?php require_once 'includes/variables.php';?>
<?php require_once 'forgot.inc.php';?>

<?php include 'includes/head.php';?>
</head>

<body>
	<?php include 'includes/navbar.php';?>
	<?php include 'includes/logo.php';?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php';?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				
				<?php if($validHash){?>
					<form id="form_forgotpw" method="post" action="includes/user_updatepw.php" data-toggle="validator" role="form" novalidate>
						
						<h4 class="content-header">
							Reset Password - <?php echo $ADK_USER['ADK_USER_USERNAME'];?>
							<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
								<span class="glyphicon glyphicon-chevron-down"></span>
							</a>
						</h4>
						
						<div class="container-fluid">
							
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<div class="col-xs-12">
										<br />
										<p>
											Please enter and confirm your new password. You may log in using your new password after.
										</p>
									</div>
								</div>
							</div>

                            <div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<div class="col-xs-12">
										<label for="textbox_password" class="control-label control-label-sm">New Password*</label><br />
										<input type="password" id="textbox_password" name="password" class="form-control form-control-sm" maxlength="20" placeholder="xxxxxx" pattern="[\S]*" required />
										<span class="help-block with-errors"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<label for="textbox_confirmpassword" class="control-label control-label-sm">Confirm New Password*</label><br />
										<input type="password" id="textbox_confirmpassword" name="confirmpassword" class="form-control form-control-sm" maxlength="20" placeholder="xxxxxx" pattern="[\S]*" data-match="#textbox_password" data-errors-match="&#8226;Passwords do not match" required />
										<span class="help-block with-errors"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<br />
										<span class="pull-left reqNote" style="font-size:0.7em;">* required</span>
										<button type="submit" class="btn btn-sm btn-default pull-right">Reset Password</button>
									</div>
								</div>
							
								<div class="col-xs-12">
									<p><?php echo $errMess;?></p>
								</div>
							</div>
						
						</div>
						
						<!-- Hidden -->
						<div style="display:none;">
							<input type="hidden" name="id" value="<?php echo $ADK_USER_ID;?>" />
						</div>
					
					</form>
				<?php }else{?>
					<form id="form_forgotpw" method="post" action="includes/forgotpw.php" data-toggle="validator" role="form" novalidate>
					
						<h4 class="content-header">
							Forgot your password?
							<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
								<span class="glyphicon glyphicon-chevron-down"></span>
							</a>
						</h4>
					
						<div class="container-fluid">
						
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<div class="col-xs-12">
										<label for="textbox_username" class="control-label control-label-sm">Username*</label><br />
										<input type="text" id="textbox_username" name="username" class="form-control form-control-sm" maxlength="20" placeholder="Username" pattern="[\S]*" required />
										<span class="help-block with-errors"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
										<input type="text" id="textbox_email" name="email" class="form-control form-control-sm" maxlength="50" placeholder="Email" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
										<span id="span_servererror" class="help-block with-errors"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-xs-12">
										<br />
										<span class="pull-left reqNote">* required</span>
										<button type="submit" class="btn btn-sm btn-default pull-right">Send Email</button>
									</div>
								</div>
							
								<div class="col-xs-12">
									<p><?php echo $errMess;?></p>
								</div>
							</div>
						
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<div class="col-xs-12">
										<br />
										<p>
											Provide your username and email address and an email will be sent to it containing instructions
											on getting your password reset.
										</p>
									</div>
								</div>
							</div>
						
						</div>
					
					</form>
				<?php }?>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php';?>
	</div>
	
</body>
</html>