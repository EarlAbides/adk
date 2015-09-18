<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php';?>
<?php require_once 'includes/loginredir.php';?>
<?php require_once 'correspondent.inc.php';?>

<?php include 'includes/head.php';?>
	<script>
		$(document).ready(function(){
			var t = document.getElementById('table_assignCorr').children[1];
			for(var i = 0; i < t.children.length; i++){
				if($(t.children[i]).data('id') == <?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>)
					$(t.children[i]).find('input').prop('disabled', true);
			}
		});
	</script>
</head>

<body>
	<?php include 'includes/navbar.php';?>
	<?php include 'includes/logo.php';?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php';?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				<form method="post" action="includes/corr_update.php" data-toggle="validator" role="form" novalidate>
					
					<h4 class="content-header">
						Edit Staff Correspondent
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
				
						<div class="pull-right" style="margin-right:3%;">
							<a href="#" onclick="alert('Do you want this feature?');//if(confirm('Are you sure you want to delete this correspondent?')) document.getElementById('button_submit_delete').click();">Delete</a>
						</div>
					
						<div class="col-xs-12 col-sm-6">
							<div class="form-group">
								<div class="col-xs-12">
									<label class="control-label control-label-sm">Username*</label><br />
									<input type="text" name="username" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME'];?>" maxlength="20" placeholder="Username" pattern="[\S]*" data-remote="includes/ajax_checkApplicantAndUsername.php" data-errors-remote="&#8226;Username already in use" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
									<input type="text" name="name" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_NAME'];?>" maxlength="40" placeholder="First Middle Last" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
									<input type="text" name="email" class="form-control form-control-sm" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_EMAIL'];?>" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_personalinfo" class="control-label control-label-sm">Personal info</label><br />
									<textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required><?php echo $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO'];?></textarea>
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
				
					<!-- Hidden -->
					<input type="hidden" name="id" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>" />
					<input type="hidden" name="photoid" value="<?php echo $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID'];?>" />
					
				</form>
			</div>
			
			<div class="content-wrapper">
				<form method="post" action="includes/corr_reassignhikers.php" data-toggle="validator" role="form" novalidate>
				
					<div class="col-xs-12 content content-max">
					
						<h4 class="content-header">
							Reassign <?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME'];?>'s Hikers
							<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
								<span class="glyphicon glyphicon-chevron-down"></span>
							</a>
						</h4>
					
						<div class="container-fluid">
						
							<div class="col-xs-12 form-group">
								<div class="div_tablewrapper">
									<?php echo $table_correspondents;?>
									<span class="help-block with-errors"></span>
								</div>
							</div>
						
							<div class="col-xs-12">
								<div class="pull-right">
									<button type="submit" class="btn btn-sm btn-default">Reassign Hikers</button>
								</div>
							</div>
						</div>
					
					</div>
				
					<input type="hidden" name="id" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>" />
				
				</form>
			</div>
			
		</div>
		<?php include 'includes/footer.php';?>
	</div>
	
	<div style="display:none;">
		<form method="post" action="includes/corr_delete.php" role="form" novalidate>
			<input type="hidden" name="id" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>" />
			<button type="submit" id="button_submit_delete"></button>
		</form>
	</div>
	
</body>
</html>