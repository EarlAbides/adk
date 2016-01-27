<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'profile.inc.php'; ?>

<?php include 'includes/head.php'; ?>
	<?php if($ADK_USERGROUP_CDE === 'HIK'){ ?>
	<script>
		$(document).ready(function(){
			$('#select_country').change(function(){
				var label_select_state = document.getElementById('label_select_state');
				var select_state = document.getElementById('select_state');
				switch(this.value){
					case 'United States':
						label_select_state.innerHTML = 'State*';
						select_state.outerHTML = document.getElementById('template_state_us').innerHTML;
						break;
					case 'Canada':
						label_select_state.innerHTML = 'Province*';
						select_state.outerHTML = document.getElementById('template_state_ca').innerHTML;
						break;
					default:
						label_select_state.innerHTML = 'State/Region*';
						select_state.outerHTML = document.getElementById('template_stateregion').innerHTML;
				}
			});
		});
	</script>
	<?php } ?>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				
				<?php switch($ADK_USERGROUP_CDE){case 'ADM': case 'EDT':?>
				<form method="post" action="includes/user_update.php" data-toggle="validator" role="form" novalidate>
					
					<h4 class="content-header">
						<?php echo $ADK_USER['ADK_USER_USERNAME']; ?>
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
						
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<div class="col-xs-12">
									<label class="control-label control-label-sm">Username*</label><br />
									<input type="text" name="username" class="form-control form-control-sm" value="<?php echo $ADK_USER['ADK_USER_USERNAME']; ?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-remote="includes/ajax_checkApplicantAndUsername.php" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
									<input type="text" name="name" class="form-control form-control-sm" value="<?php echo $ADK_USER['ADK_USER_NAME']; ?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="text" name="email" class="form-control form-control-sm" value="<?php echo $ADK_USER['ADK_USER_EMAIL']; ?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
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
				
					<!-- Hidden -->
					<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
					
				</form>
				<?php break; case 'COR':?>
				
				<h4 class="content-header">
					<?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME']; ?>
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<div class="container-fluid">
				
					<div class="col-xs-12 col-sm-6">
						<form method="post" action="includes/corr_update.php" data-toggle="validator" role="form" novalidate>
							<div class="form-group">
								<div class="col-xs-12">
									<label class="control-label control-label-sm">Username*</label><br />
									<input type="text" name="username" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME']; ?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-remote="includes/ajax_checkApplicantAndUsername.php" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
									<input type="text" name="name" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_NAME']; ?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="text" name="email" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_EMAIL']; ?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_personalinfo" class="control-label control-label-sm">Personal info</label><br />
									<textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required><?php echo $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO']; ?></textarea>
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
						<form method="post" action="includes/corr_updatephoto.php" data-toggle="validator" role="form" enctype="multipart/form-data" novalidate>
							<div class="div_tablewrapper" style="padding:5px;">
								<img src="includes/getImage.php?_=<?php echo $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID']; ?>" class="img-responsive imghover" alt="Photo" title="Photo" />
							</div>
							<br />
							<div class="form-group">
								<div class="col-xs-6">
									<label for="file_corrphoto" class="control-label control-label-sm">Upload Profile Photo</label><br />
									<input type="file" id="file_corrphoto" name="corrphoto" required />
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
				
				
				<?php break; case 'HIK':?>
				
				<h4 class="content-header">
					<?php echo $ADK_HIKER['ADK_USER_USERNAME']; ?>
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
					
				<div class="container-fluid">
					<form method="post" action="includes/hiker_update.php" data-toggle="validator" role="form" novalidate>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-5">
									<label for="textbox_username" class="control-label control-label-sm">Username*</label><br />
									<input type="text" id="textbox_username" name="username" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_USER_USERNAME']; ?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-error="&#8226;Required, no spaces" data-remote="includes/ajax_checkApplicantAndUsername.php" data-errors-remote="&#8226;Username already in use" required />
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
									<input type="text" id="textbox_name" name="name" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_USER_NAME']; ?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="email" id="textbox_email" name="email" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_USER_EMAIL']; ?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 col-sm-6">
									<label for="textbox_phone" class="control-label control-label-sm">Phone</label><br />
									<input type="text" id="textbox_phone" name="phone" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_HIKER_PHONE']; ?>" maxlength="14" placeholder="x-xxx-xxx-xxxx" pattern="[\d\-]*" />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="textbox_age" class="control-label control-label-sm">Age</label><br />
									<input type="number" id="textbox_age" name="age" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_HIKER_AGE']; ?>" maxlength="3" placeholder="xxx" pattern="[\d]*" />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="select_sex" class="control-label control-label-sm">Sex</label><br />
									<select id="select_sex" name=sex class="form-control form-control-sm" placeholder="Sex">
										<option />
										<option value="M"<?php if($ADK_HIKER['ADK_HIKER_SEX'] == 'M') echo ' selected="selected"'; ?>>M</option>
										<option value="F"<?php if($ADK_HIKER['ADK_HIKER_SEX'] == 'F') echo ' selected="selected"'; ?>>F</option>
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
									<input type="text" id="textbox_address1" name="address1" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_HIKER_ADDRESS1']; ?>" maxlength="40" placeholder="123 xxx St." pattern="[\w\d\s\.\,\']*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_address2" class="control-label control-label-sm">Address, line 2</label><br />
									<input type="text" id="textbox_address2" name="address2" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_HIKER_ADDRESS2']; ?>" maxlength="40" pattern="[\w\d\s\.\,\']*" placeholder="Apt., Floor, etc." />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="select_country" class="control-label control-label-sm">Country*</label><br />
									<?php echo select_country($ADK_HIKER['ADK_HIKER_COUNTRY']); ?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 col-sm-6">
									<label for="textbox_city" class="control-label control-label-sm">City*</label><br />
									<input type="text" id="textbox_city" name="city" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_HIKER_CITY']; ?>" maxlength="40" placeholder="City" pattern="[\w\d\s\.\,\']*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label id="label_select_state" for="select_state" class="control-label control-label-sm">State*</label><br />
									<?php
										switch($ADK_HIKER['ADK_HIKER_COUNTRY']){
											case 'United States': echo select_state($ADK_HIKER['ADK_HIKER_STATE']); break;
											case 'Canada': echo select_state_ca($ADK_HIKER['ADK_HIKER_STATE']); break;
											default: echo textbox_stateregion($ADK_HIKER['ADK_HIKER_STATE']);
										}
									?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="textbox_zip" class="control-label control-label-sm">Zip*</label><br />
									<input type="text" id="textbox_zip" name="zip" class="form-control form-control-sm" value="<?php echo $ADK_HIKER['ADK_HIKER_ZIP']; ?>" maxlength="10" placeholder="Zip/Postal" pattern="[\w\d\-\s]*" required />
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
									<textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required><?php echo $ADK_HIKER['ADK_HIKER_PERSONALINFO']; ?></textarea>
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
						<input type="hidden" name="corrid" value="<?php echo $ADK_HIKER['ADK_HIKER_CORR_ID']; ?>" />
						
					</form>
				</div>
				
				<div class="container-fluid">
					<div class="col-xs-12 col-sm-6">
						<form method="post" action="includes/hikerPhoto.php" data-toggle="validator" role="form" enctype="multipart/form-data" novalidate>
							<div class="div_tablewrapper" style="padding:5px;">
								<img src="includes/getImage.php?_=<?php echo $ADK_HIKER->photoid; ?>" class="img-responsive imghover" alt="Photo" title="Photo" />
							</div>
							<br />
							<div class="form-group">
								<div class="col-xs-6">
									<label for="file_corrphoto" class="control-label control-label-sm">Upload Profile Photo</label><br />
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
							$default = $ADK_HIKER['ADK_HIKER_COUNTRY'] === 'United States'? $ADK_HIKER['ADK_HIKER_STATE']: 'NY';
							echo select_state($default);
						?>
					</template>
					<template id="template_state_ca">
						<?php
							$default = $ADK_HIKER['ADK_HIKER_COUNTRY'] === 'Canada'? $ADK_HIKER['ADK_HIKER_STATE']: 'ON';
							echo select_state_ca($default);
						?>
					</template>
					<template id="template_stateregion">
						<?php
							$default = ($ADK_HIKER['ADK_HIKER_COUNTRY'] !== 'United States' && $ADK_HIKER['ADK_HIKER_COUNTRY'] !== 'Canada')? $ADK_HIKER['ADK_HIKER_STATE']: '';
							echo textbox_stateregion($default);
						?>
					</template>
				</div>
				
				<?php break;} ?>
			</div>
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				<form method="post" action="includes/user_updatepw.php" data-toggle="validator" role="form" novalidate>
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
									<input type="password" id="textbox_oldpassword" name="oldpassword" class="form-control form-control-sm" maxlength="20" placeholder="Old password" pattern="[\S]*" data-remote="includes/ajax_checkUserOldpw.php" data-remote-id="<?php echo $ADK_USER_ID; ?>" data-errors-remote="&#8226;This does not match your existing password" required />
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
					
					<!-- Hidden -->
					<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
					
				</form>
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
</body>
</html>