<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'signup.inc.php'; ?>
<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>

<?php include 'includes/head.php'; ?>
	<script>
		$(document).ready(function(){
			$('.date').datepicker({
				changeMonth: true
				,changeYear: true
				,maxDate: '+2d'
				,yearRange: '-100:+0'
			});
			
			$('#textbox_reqcorr').autocomplete({
				source: 'includes/ajax_getCorrNames.php',
				minLength: 2
			});
			
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

            $('#textbox_username').keyup(function(){
                $('.username-error').remove();
            });

			$('#form_signup').on('submit', function(){
				var peakids = [];
				$('input.peaks:checked').each(function(){
					peakids.push(this.getAttribute('data-id'));
				});
				document.getElementById('peakids').value = peakids.join(',');
			});
		});
	</script>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<form id="form_signup" method="post" action="includes/applicant_add.php" data-toggle="validator" role="form" novalidate>
				
				<div class="col-xs-12 content content-max">
					
					<h4 class="content-header">
						Sign Up
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
                        
                        <?php if(isset($_GET['u'])){?>
                            <div class="username-error col-xs-12 has-error">
							    <div class="form-group" style="display:inline;">
                                    <span class="help-block with-errors">&#8226;Username '<?php echo $_GET['u'];?>' already in use</span>
                                </div>
							</div>
                        <?php }?>
						
						<div class="col-xs-12">
							<div class="form-group" style="display:inline;">
								<div class="col-xs-12 col-sm-5">
									<label for="textbox_username" class="control-label control-label-sm">Username*</label><br />
									<input type="text" id="textbox_username" name="username" class="form-control form-control-sm" maxlength="20" placeholder="Username" pattern="[\S]*" data-error="&#8226;Required, no spaces" data-remote="includes/ajax_checkApplicantAndUsername.php" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group" style="display:inline;">
								<div class="col-xs-12 col-sm-5 col-sm-offset-2">
									<label for="textbox_reqcorr" class="control-label control-label-sm">Requested Staff Correspondent</label><br />
									<input type="text" id="textbox_reqcorr" name="reqcorr" class="form-control form-control-sm" maxlength="80" placeholder="Name or Username" />
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
									<label for="textbox_name" class="control-label control-label-sm">Full name, as you wish it to appear on your Certificate of Accomplishment*</label><br />
									<input type="text" id="textbox_name" name="name" class="form-control form-control-sm" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="email" id="textbox_email" name="email" class="form-control form-control-sm" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
                            <div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_confirmemail" class="control-label control-label-sm">Confirm Email*</label><br />
									<input type="email" id="textbox_confirmemail" class="form-control form-control-sm" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" data-match="#textbox_email" data-errors-match="&#8226;Email addresses do not match" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 col-sm-6">
									<label for="textbox_phone" class="control-label control-label-sm">Phone</label><br />
									<input type="text" id="textbox_phone" name="phone" class="form-control form-control-sm" maxlength="14" placeholder="x-xxx-xxx-xxxx" pattern="[\d\-]*" />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="textbox_age" class="control-label control-label-sm">Age</label><br />
									<input type="number" id="textbox_age" name="age" class="form-control form-control-sm" maxlength="3" placeholder="xxx" pattern="[\d]*" />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="select_sex" class="control-label control-label-sm">Sex</label><br />
									<select id="select_sex" name=sex class="form-control form-control-sm" placeholder="Sex">
										<option />
										<option value="M">M</option>
										<option value="F">F</option>
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
									<input type="text" id="textbox_address1" name="address1" class="form-control form-control-sm" maxlength="40" placeholder="123 xxx St." pattern="[\w\d\s\.\,\']*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_address2" class="control-label control-label-sm">Address, line 2</label><br />
									<input type="text" id="textbox_address2" name="address2" class="form-control form-control-sm" maxlength="40" pattern="[\w\d\s\.\,\']*" placeholder="Apt., Floor, etc." />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="select_country" class="control-label control-label-sm">Country*</label><br />
									<?php echo select_country('United States');?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 col-sm-6">
									<label for="textbox_city" class="control-label control-label-sm">City*</label><br />
									<input type="text" id="textbox_city" name="city" class="form-control form-control-sm" maxlength="40" placeholder="City" pattern="[\w\d\s\.\,\']*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label id="label_select_state" for="select_state" class="control-label control-label-sm">State*</label><br />
									<?php echo select_state('NY');?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6 col-sm-3">
									<label for="textbox_zip" class="control-label control-label-sm">Zip*</label><br />
									<input type="text" id="textbox_zip" name="zip" class="form-control form-control-sm" maxlength="10" placeholder="Zip/Postal" pattern="[\w\d\-\s]*" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12" style="margin-top:18px;">
							<div class="hr hr75"></div>
						</div>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_personalinfo" class="control-label control-label-sm">Information about yourself*</label><br />
									<textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required></textarea>
									<span class="help-block with-errors"></span>
								</div>
							</div>

							<div class="col-xs-12" style="margin-top:18px;">
								<div class="hr hr75"></div>
							</div>

							<div class="col-xs-12 col-sm-4" style="margin:0;">
								<label class="control-label control-label-sm">List any peaks you've climbed</label><br />
								<ul class="peaklist">
									<?php for($i = 0; $i < 16; $i++) echo makeCheckbox($ADK_PEAKS[$i]);?>
								</ul>
							</div>

							<div class="col-xs-12 col-sm-4" style="margin:0;">
								<div class="hidden-xs">&emsp;</div>
								<ul class="peaklist">
									<?php for($i = 16; $i < 31; $i++) echo makeCheckbox($ADK_PEAKS[$i]);?>
								</ul>
							</div>

							<div class="col-xs-12 col-sm-4" style="margin:0;">
								<div class="hidden-xs">&emsp;</div>
								<ul class="peaklist">
									<?php for($i = 31; $i < 46; $i++) echo makeCheckbox($ADK_PEAKS[$i]);?>
								</ul>
							</div>

							<div class="col-xs-12" style="margin-top:18px;">
								<div class="hr hr75"></div>
							</div>

							<div class="col-xs-12" style="margin-top:45px;">
								<p class="font-italic">
									I acknowledge that my Adirondack 46er Correspondent does not speak for the Adirondack 46ers Club and
									that the club is not responsible accuracy, content, completeness, legality, or reliability of the
									information contained or relayed on this website.  Further the club is not responsible for any injury
									relating to information received and acted upon within the correspondent process.
								</p>
								<label class="pull-right" style="margin-right:5%;">Click here to agree&nbsp;<input type="checkbox" required></input>
							</div>

							<div class="form-group">
								<div class="col-xs-12">
									<br />
									<span class="reqNote pull-left">* required</span>
									<button type="submit" class="btn btn-default pull-right" style="margin-right:5%;">Sign Up</button>
									<br /><br />
								</div>
							</div>
						</div>
						
					</div>
				</div>

				<input type="hidden" id="peakids" name="peakids" />
				
			</form>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		<template id="template_state_us">
			<?php echo select_state('NY');?>
		</template>
		<template id="template_state_ca">
			<?php echo select_state_ca('ON');?>
		</template>
		<template id="template_stateregion">
			<?php echo textbox_stateregion('');?>
		</template>
	</div>
	
</body>
</html>