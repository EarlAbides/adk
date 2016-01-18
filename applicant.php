<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'applicant.inc.php'; ?>

<?php include 'includes/head.php'; ?>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12">
				<div class="container-fluid content content-max" style="margin-bottom:15px;">
					
					<h4 class="content-header">
						New Applicant
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="pull-right" style="margin-right:3%;">
						<a href="editApplicant.php?_=<?php echo $ADK_APPLICANT['ADK_APPLICANT_ID'];?>">Edit</a> <b>|</b> 
						<a href="#" onclick="if(confirm('Are you sure you want to delete this applicant?')) $('#button_submit_delete').click();">Delete</a>
					</div>
					
					<div class="col-xs-12">
						<div class="form-group" style="display:inline;">
							<div class="col-xs-12 col-sm-5">
								<label class="control-label control-label-sm">Username</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_USERNAME'];?></span>
							</div>
						</div>
						<div class="form-group" style="display:inline;">
							<div class="col-xs-12 col-sm-5 col-sm-offset-2">
								<label class="control-label control-label-sm">Requested Staff Correspondent</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_REQ_CORR'];?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12">
						<div class="hr hr75"></div>
					</div>
						
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Name</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_NAME'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Email</label><br />
								<span><a href="mailto:<?php echo $ADK_APPLICANT['ADK_APPLICANT_EMAIL'];?>"><?php echo $ADK_APPLICANT['ADK_APPLICANT_EMAIL'];?></a></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">Phone</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_PHONE'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Age</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_AGE'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Sex</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_SEX'];?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12 col-sm-6">
						<div class="hidden-xs hidden-lg" style="display:block;margin-bottom:14px;"></div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address, line 1</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1'];?></span>
							</div>
						</div>
						<?php if($ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'] !== ''){?>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address<?php if($ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'] !== ''){?>, line 2<?php }?></label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'];?></span>
							</div>
						</div>
						<?php }?>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">City</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_CITY'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">State</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_STATE'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Zip</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_ZIP'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Country</label><br />
								<span><?php echo $ADK_APPLICANT['ADK_APPLICANT_COUNTRY'];?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12">
						<div class="hr hr75"></div>
					</div>
						
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Personal info</label><br />
								<span class="lgtext"><?php echo $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO'];?></span>
							</div>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="hr hr75"></div>
					</div>

					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Peaks</label><br />
								<span class="lgtext"><?php echo $ADK_APPLICANT['ADK_APPLICANT_PEAKLIST'];?></span>
							</div>
						</div>
					</div>
						
				</div>
			</div>
			
			<div class="col-xs-12">
				<div class="container-fluid content content-max">
					
					<h4 class="content-header">
						Assign a Staff Correspondent
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<form method="post" action="includes/corr_assign.php" data-toggle="validator" role="form" novalidate>
							
						<div class="col-xs-12 form-group">
							<div class="div_tablewrapper">
								<?php echo $table_correspondents;?>
								<span class="help-block with-errors"></span>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="pull-right">
								<button type="submit" class="btn btn-sm btn-default">Assign Correspondent</button>
							</div>
						</div>
						
						<input type="hidden" name="id" value="<?php echo $ADK_APPLICANT['ADK_APPLICANT_ID'];?>" />
						<input type="hidden" name="usergroupid" value="2" />
						<input type="hidden" name="username" value="<?php echo $ADK_APPLICANT['ADK_APPLICANT_USERNAME'];?>" />
						<input type="hidden" name="name" value="<?php echo $ADK_APPLICANT['ADK_APPLICANT_NAME'];?>" />
						<input type="hidden" name="email" value="<?php echo $ADK_APPLICANT['ADK_APPLICANT_EMAIL'];?>" />
						
					</form>
					
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		<form method="post" action="includes/applicant_delete.php" role="form" novalidate>
			<input type="hidden" name="id" value="<?php echo $ADK_APPLICANT['ADK_APPLICANT_ID'];?>" />
			<button type="submit" id="button_submit_delete"></button>
		</form>
	</div>
	
</body>
</html>