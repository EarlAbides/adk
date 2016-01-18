<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'correspondent.inc.php'; ?>

<?php include 'includes/head.php'; ?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.selecttable').DataTable({pageLength: 15, lengthChange: false});
		});
	</script>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
					
				<h4 class="content-header">
					46er Staff Correspondent
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
					
				<div class="container-fluid">
				
					<div class="pull-right" style="margin-right:3%;">
						<a href="editCorrespondent.php?_=<?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>">Edit</a> <b>|</b> 
						<a href="#" onclick="alert('Do you want this feature?');//if(confirm('Are you sure you want to delete this correspondent?')) $('#button_submit_delete').click();">Delete</a>
					</div>
					
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Username</label><br />
								<span><?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Name</label><br />
								<span><?php echo $ADK_CORRESPONDENT['ADK_USER_NAME'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Email</label><br />
								<span><a href="mailto:<?php echo $ADK_CORRESPONDENT['ADK_USER_EMAIL'];?>"><?php echo $ADK_CORRESPONDENT['ADK_USER_EMAIL'];?></a></span>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6">
						<div class="container-fluid">
							<img src="includes/getImage.php?_=<?php echo $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID'];?>" class="img-responsive imghover" alt="Photo - <?php echo $ADK_CORRESPONDENT['ADK_USER_NAME'];?>" title="<?php echo $ADK_CORRESPONDENT['ADK_USER_NAME'];?>" />
						</div>
					</div>
						
					<div class="col-xs-12 col-sm-10 sol-sm-offset-1">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Personal info</label><br />
								<span class="lgtext"><?php echo $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO'];?></span>
							</div>
						</div>
					</div>
						
				</div>
				
			</div>
			
			<div class="col-xs-12 content content-max">
			
				<h4 class="content-header">
					<?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME'];?>'s Hikers
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<div class="container-fluid">
					<div class="col-xs-12">
						<div class="div_tablewrapper tablewrapper500">
							<?php echo $table_hikers;?>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		<form method="post" action="includes/corr_delete.php" role="form" novalidate>
			<input type="hidden" name="id" value="<?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>" />
			<button type="submit" id="button_submit_delete"></button>
		</form>
	</div>
	
</body>
</html>