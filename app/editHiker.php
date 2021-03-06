<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'hiker.inc.php'; ?>

<?php include 'templates/head.php'; ?>
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
			
			<?php if($_SESSION['ADK_USERGROUP_CDE'] == 'ADM'){ ?>
			(function(){
				var t = document.getElementById('table_assignCorr').children[1];
				for(var i = 0; i < t.children.length; i++){
					if($(t.children[i]).data('id') == <?php echo $ADK_HIKER->corrid; ?>)
						$(t.children[i]).find('input').prop('disabled', true);
				}
			})();
			<?php } ?>
		});
	</script>
</head>

<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'templates/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<form method="post" action="includes/hikerUpdate.php" data-toggle="validator" role="form" novalidate>
				
				<div class="col-xs-12 content content-max">
					
					<h4 class="content-header">
						Edit Hiker
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
						
						<div class="pull-right" style="margin-right:3%;">
							<?php if($_SESSION['ADK_USERGROUP_CDE'] === 'ADM'){ ?>
								<a href="#" onclick="if(confirm('Are you sure you want to delete this hiker?')) $('#button_submit_delete').click();">Delete</a>
							<?php } ?>
						</div>
						
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
										<option value="M"<?php if($ADK_HIKER->sex == 'M') echo ' selected="selected"'; ?>>M</option>
										<option value="F"<?php if($ADK_HIKER->sex == 'F') echo ' selected="selected"'; ?>>F</option>
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
											case 'United States': echo select_state($ADK_HIKER->state); break;
											case 'Canada': echo select_state_ca($ADK_HIKER->state); break;
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
						
					</div>
				</div>
				
				<input type="hidden" name="id" value="<?php echo $ADK_HIKER->id; ?>" />
				<input type="hidden" id="hidden_corrid" name="corrid" value="<?php echo $ADK_HIKER->corrid; ?>" />
				
			</form>
		</div>
		
		<?php if($_SESSION['ADK_USERGROUP_CDE'] == 'ADM'){ ?>
		<div class="content-wrapper">
			<form method="post" action="includes/hikerUpdateCorr.php" data-toggle="validator" role="form" novalidate>
				
				<div class="col-xs-12 content content-max">
					
					<h4 class="content-header">
						Reassign Correspondent
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
						
						<div class="col-xs-12 form-group">
							<div class="div_tablewrapper">
								<?php $ADK_CORRESPONDENTS->renderSelectTable(); ?>
								<span class="help-block with-errors"></span>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="pull-right">
								<button type="submit" class="btn btn-sm btn-default">Reassign Correspondent</button>
							</div>
						</div>
					</div>
					
				</div>
				
				<input type="hidden" name="id" value="<?php echo $ADK_HIKER->id; ?>" />
				
			</form>
		</div>
		<?php } ?>
		
		<?php include 'templates/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		<form method="post" action="includes/hikerDelete.php" role="form" novalidate>
			<input type="hidden" name="id" value="<?php echo $ADK_HIKER->id; ?>" />
			<button type="submit" id="button_submit_delete"></button>
		</form>
	</div>
	
	<div style="display:none;">
		<template id="template_state_us">
			<?php
				$default = $ADK_HIKER->country === 'United States'? $ADK_HIKER->state: 'NY';
				echo select_state($default);
			?>
		</template>
		<template id="template_state_ca">
			<?php
				$default = $ADK_HIKER->country === 'Canada'? $ADK_HIKER->state: 'ON';
				echo select_state_ca($default);
			?>
		</template>
		<template id="template_stateregion">
			<?php
				$default = ($ADK_HIKER->country !== 'United States' && $ADK_HIKER->country !== 'Canada')? $ADK_HIKER->state: '';
				echo textbox_stateregion($default);
			?>
		</template>
	</div>
	
</body>
</html>