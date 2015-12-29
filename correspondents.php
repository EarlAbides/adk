<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php';?>
<?php require_once 'includes/loginredir.php';?>
<?php require_once 'correspondents.inc.php';?>

<?php include 'includes/head.php';?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.selecttable').DataTable({pageLength: 15, lengthChange: false});
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
					
				<h4 class="content-header">
					46er Staff Correspondents
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
					
				<div class="container-fluid">
					<div class="col-xs-12">
						<div class="div_tablewrapper tablewrapper500">
							<?php echo $table_correspondents;?>
						</div>
					</div>
				</div>
				
			</div>

            <div class="col-xs-12 content content-max">
				
                <h4 class="content-header">
					Create Correspondent
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>

                <form method="post" action="includes/corr_add.php" data-toggle="validator" role="form" novalidate>
					
				    <div class="container-fluid">
				    
					    <div class="col-xs-12 col-sm-6">
						    <div class="form-group">
							    <div class="col-xs-12">
								    <label class="control-label control-label-sm">Username*</label><br />
								    <input type="text" name="username" class="form-control form-control-sm" maxlength="20" placeholder="Username" pattern="[\S]*" data-remote="includes/ajax_checkApplicantAndUsername.php" data-errors-remote="&#8226;Username already in use" required />
								    <span class="help-block with-errors"></span>
							    </div>
						    </div>
						    <div class="form-group">
							    <div class="col-xs-12">
								    <label for="textbox_name" class="control-label control-label-sm">Name*</label><br />
								    <input type="text" name="name" class="form-control form-control-sm" maxlength="40" placeholder="First Middle Last" required />
								    <span class="help-block with-errors"></span>
							    </div>
						    </div>
						    <div class="form-group">
							    <div class="col-xs-12">
								    <label for="textbox_email" class="control-label control-label-sm">Email*</label><br />
								    <input type="text" name="email" class="form-control form-control-sm" maxlength="50" placeholder="xxx@abc.com" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required />
								    <span class="help-block with-errors"></span>
							    </div>
						    </div>
					    </div>
						
					    <div class="col-xs-12">
						    <div class="form-group">
							    <div class="col-xs-12">
								    <label for="textbox_personalinfo" class="control-label control-label-sm">Personal info*</label><br />
								    <textarea id="textbox_personalinfo" name="personalinfo" class="form-control form-control-sm" maxlength="1024" placeholder="Personal information" required></textarea>
								    <span class="help-block with-errors"></span>
							    </div>
						    </div>
						    <div class="form-group">
							    <div class="col-xs-12">
								    <br />
								    <span class="reqNote pull-left">* required</span>
								    <button type="submit" class="btn btn-sm btn-default pull-right">Add</button>
								    <br /><br />
							    </div>
						    </div>
					    </div>
						
				    </div>
				
			    </div>
			</form>
		</div>
		<?php include 'includes/footer.php';?>
	</div>
	
</body>
</html>