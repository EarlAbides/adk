<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'profile.inc.php'; ?>

<?php include 'templates/head.php'; ?>
	<script src="js/profile.min.js"></script>
</head>

<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include "templates/navbar_sub.php"; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				
				<?php switch($ADK_USERGROUP_CDE){case "ADM": case "EDT": ?>
				<form method="post" action="includes/userUpdate.php" data-toggle="validator" role="form" novalidate>
					
					<h4 class="content-header">
						<?php echo $ADK_USER->username; ?>
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
						
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<div class="col-xs-12">
									<label class="control-label control-label-sm">Username*</label><br />
									<input type="text" name="username" class="form-control form-control-sm" value="<?php echo $ADK_USER->username; ?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-remote="includes/userIsUnique.php?_=<?php echo $ADK_USER->username; ?>" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
									<input type="text" name="name" class="form-control form-control-sm" value="<?php echo $ADK_USER->name; ?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="text" name="email" class="form-control form-control-sm" value="<?php echo $ADK_USER->email; ?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12">
									<br />
									<span class="reqNote pull-left">* required</span>
									<button type="submit" class="btn btn-sm btn-default pull-right">Update</button>
									<br /><br />
								</div>
							</div>
						</div>
						
					</div>
				
					<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
					
				</form>
				<?php break; case "COR":?>
				
				<h4 class="content-header">
					<?php echo $ADK_CORRESPONDENT->username; ?>
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<div class="container-fluid">
				
					<div class="col-xs-12 col-sm-6">
						<form method="post" action="includes/corrUpdate.php" data-toggle="validator" role="form" novalidate>
							<div class="form-group">
								<div class="col-xs-12">
									<label class="control-label control-label-sm">Username*</label><br />
									<input type="text" name="username" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT->username; ?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-remote="includes/userIsUnique.php?_=<?php echo $ADK_CORRESPONDENT->username; ?>" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
									<input type="text" name="name" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT->name; ?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="text" name="email" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT->email; ?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_personalinfo" class="control-label control-label-sm">Personal info</label><br />
									<textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required><?php echo $ADK_CORRESPONDENT->info; ?></textarea>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<br />
									<span class="reqNote pull-left">* required</span>
									<button type="submit" class="btn btn-sm btn-default pull-right">Update</button>
									<br /><br />
								</div>
							</div>
							<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
						</form>
					</div>
					
					<div class="col-xs-12 col-sm-6">
						<form method="post" action="includes/corrPhoto.php" data-toggle="validator" role="form" enctype="multipart/form-data" novalidate>
							<div class="div_tablewrapper" style="padding:5px;">
								<img src="includes/fileGetImage.php?_=<?php echo $ADK_CORRESPONDENT->photoid; ?>" class="img-responsive imghover" alt="Photo" title="Photo" />
							</div>
							<br />
							<div class="form-group">
								<div class="col-xs-6">
									<label for="file_photo" class="control-label control-label-sm">Upload Profile Photo</label><br />
									<input type="file" id="file_photo" name="photo" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<button type="submit" class="btn btn-sm btn-default pull-right">Upload</button>
								</div>
							</div>
							<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
						</form>
					</div>
					
				</div>
				
				
				<?php break; case "HIK":?>
				
				<h4 class="content-header">
					<?php echo $ADK_HIKER->username; ?>
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
					
				<div class="container-fluid">
					<form method="post" action="includes/hikerUpdate.php" data-toggle="validator" role="form" novalidate>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-5">
									<label for="textbox_username" class="control-label control-label-sm">Username*</label><br />
									<input type="text" id="textbox_username" name="username" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->username; ?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-error="&#8226;Required, no spaces" data-remote="includes/userIsUnique.php?_=<?php echo $ADK_HIKER->username; ?>" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="hr hr75"></div>
						</div>
						
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
									<input type="text" id="textbox_name" name="name" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->name; ?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="email" id="textbox_email" name="email" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->email; ?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 col-sm-6">
									<label for="textbox_phone" class="control-label control-label-sm">Phone</label><br />
									<input type="text" id="textbox_phone" name="phone" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->phone; ?>" maxlength="14" placeholder="x-xxx-xxx-xxxx" pattern="[\d\-]*" />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="textbox_age" class="control-label control-label-sm">Age</label><br />
									<input type="number" id="textbox_age" name="age" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->age; ?>" maxlength="3" placeholder="xxx" pattern="[\d]*" />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="select_sex" class="control-label control-label-sm">Sex</label><br />
									<select id="select_sex" name=sex class="form-control form-control-sm" placeholder="Sex">
										<option />
										<option value="M"<?php if($ADK_HIKER->sex == "M") echo " selected=\"selected\""; ?>>M</option>
										<option value="F"<?php if($ADK_HIKER->sex == "F") echo " selected=\"selected\""; ?>>F</option>
									</select>
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-6">
							<div class="hidden-xs hidden-lg" style="display:block;margin-bottom:14px;"></div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_address1" class="control-label control-label-sm">Address, line 1*</label><br />
									<input type="text" id="textbox_address1" name="address1" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->address1; ?>" maxlength="40" placeholder="123 xxx St." pattern="[\w\d\s\.\,\']*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_address2" class="control-label control-label-sm">Address, line 2</label><br />
									<input type="text" id="textbox_address2" name="address2" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->address2; ?>" maxlength="40" pattern="[\w\d\s\.\,\']*" placeholder="Apt., Floor, etc." />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="select_country" class="control-label control-label-sm">Country*</label><br />
									<?php echo select_country($ADK_HIKER->country); ?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 col-sm-6">
									<label for="textbox_city" class="control-label control-label-sm">City*</label><br />
									<input type="text" id="textbox_city" name="city" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->city; ?>" maxlength="40" placeholder="City" pattern="[\w\d\s\.\,\']*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label id="label_select_state" for="select_state" class="control-label control-label-sm">State*</label><br />
									<?php
										switch($ADK_HIKER->country){
											case "United States": echo select_state($ADK_HIKER->state); break;
											case "Canada": echo select_state_ca($ADK_HIKER->state); break;
											default: echo textbox_stateregion($ADK_HIKER->state);
										}
									?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="textbox_zip" class="control-label control-label-sm">Zip*</label><br />
									<input type="text" id="textbox_zip" name="zip" class="form-control form-control-sm" value="<?php echo $ADK_HIKER->zip; ?>" maxlength="10" placeholder="Zip/Postal" pattern="[\w\d\-\s]*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="hr hr75"></div>
						</div>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_personalinfo" class="control-label control-label-sm">Personal info*</label><br />
									<textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required><?php echo $ADK_HIKER->info; ?></textarea>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<br />
									<span class="reqNote pull-left">* required</span>
									<button type="submit" class="btn btn-sm btn-default pull-right">Update</button>
									<br /><br />
								</div>
							</div>
						</div>
					
						<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
						<input type="hidden" name="corrid" value="<?php echo $ADK_HIKER->corrid; ?>" />
						
					</form>
				</div>

				<div class="container-fluid">
					<div class="col-xs-12 col-sm-4 col-sm-offset-4">
						<form method="post" action="includes/hikerPhoto.php" data-toggle="validator" role="form" enctype="multipart/form-data" novalidate>
							<div class="div_tablewrapper" style="padding:5px;">
								<img src="includes/fileGetImage.php?_=<?php echo $ADK_HIKER->photoid; ?>" class="img-responsive imghover" alt="Photo" title="Photo" />
							</div>
							<br />
							<div class="form-group">
								<div class="col-xs-6">
									<label for="file_photo" class="control-label control-label-sm">Upload Profile Photo</label><br />
									<input type="file" id="file_photo" name="photo" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<button type="submit" class="btn btn-sm btn-default pull-right">Upload</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<div style="display:none;">
					<template id="template_state_us">
						<?php
							$default = $ADK_HIKER->country === "United States" ? $ADK_HIKER->state: "NY";
							echo select_state($default);
						?>
					</template>
					<template id="template_state_ca">
						<?php
							$default = $ADK_HIKER->country === "Canada" ? $ADK_HIKER->state: "ON";
							echo select_state_ca($default);
						?>
					</template>
					<template id="template_stateregion">
						<?php
							$default = ($ADK_HIKER->country !== "United States" && $ADK_HIKER->country !== "Canada")? $ADK_HIKER->state: "";
							echo textbox_stateregion($default);
						?>
					</template>
				</div>
				
				<?php break; } ?>
			</div>

			<?php if($ADK_USERGROUP_CDE === "HIK" || $ADK_USERGROUP_CDE === "COR"){ ?>
				<div id="div_preferences" class="col-xs-12 content content-max" style="margin-bottom:15px;">
					<form method="post" action="includes/userUpdatePrefs.php" data-toggle="validator" role="form" novalidate>
						<h4 class="content-header">
							Preferences
							<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
								<span class="glyphicon glyphicon-chevron-down"></span>
							</a>
						</h4>

						<div class="col-xs-12">
							<h4>Communications</h4>
							<?php if($ADK_USERGROUP_CDE === "HIK"){ ?>
								<div class="form-group">
									<div class="col-xs-12">
										<div class="col-sm-5">
											<label for="hiker_receive-inactive-user-emails" class="control-label control-label-sm">Reminder if you're inactive for over six months</label><br />
											<input type="checkbox" id="hiker_receive-inactive-user-emails" name="hiker_receive-inactive-user-emails" value="true" <?php echo ($ADK_PREFS->get("hiker_receive-inactive-user-emails") ? "checked" : ""); ?> />
											<span class="help-block with-errors"></span>
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="form-group">
								<div class="col-xs-12">
									<div class="col-sm-5">
										<label for="user_receive-newsletter" class="control-label control-label-sm">Quarterly newsletter</label><br />
										<input type="checkbox" id="user_receive-newsletter" name="user_receive-newsletter" value="true" <?php echo $ADK_PREFS->get("user_receive-newsletter") ? "checked" : ""; ?> />
										<span class="help-block with-errors"></span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<br />
									<button type="submit" class="btn btn-sm btn-default pull-right">Submit</button>
									<br /><br />
								</div>
							</div>
						</div>
					
						<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
					
					</form>
				</div>
			<?php } ?>
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				<form method="post" action="includes/userUpdatePW.php" data-toggle="validator" role="form" novalidate>
					<h4 class="content-header">
						Password
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<div class="col-sm-5">
									<label for="textbox_oldpassword" class="control-label control-label-sm">Old Password*</label><br />
									<input type="password" id="textbox_oldpassword" name="oldpassword" class="form-control form-control-sm" maxlength="20" placeholder="Old password" pattern="[\S]*" data-remote="includes/userIsOldPassword.php" data-remote-id="<?php echo $ADK_USER_ID; ?>" data-errors-remote="&#8226;This does not match your existing password" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="col-sm-5">
									<label for="textbox_password" class="control-label control-label-sm">New Password*</label><br />
									<input type="password" id="textbox_password" name="password" class="form-control form-control-sm" maxlength="20" placeholder="xxxxxx" pattern="[\S]*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="col-sm-5">
									<label for="textbox_confirmpassword" class="control-label control-label-sm">Confirm New Password*</label><br />
									<input type="password" id="textbox_confirmpassword" name="confirmpassword" class="form-control form-control-sm" maxlength="20" placeholder="xxxxxx" pattern="[\S]*" data-match="#textbox_password" data-errors-match="&#8226;Passwords do not match" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12">
									<br />
									<span class="reqNote pull-left">* required</span>
									<button type="submit" class="btn btn-sm btn-default pull-right">Reset Password</button>
									<br /><br />
								</div>
							</div>
						</div>
					</div>
					
					<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
					<input type="hidden" name="checkold" />
					
				</form>
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>
