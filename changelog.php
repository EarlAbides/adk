<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'changelog.inc.php'; ?>

<?php include 'includes/head.php'; ?>
	<script>
		$(document).ready(function(){
			$('.checkbox_done').click(function(){a(this.value, this.checked);});
			$('#table_changelog tr').click(function(){d(this);});
		});
		function a(b,c){c=(c?1:0);$.post('includes/ajax_updateChangeDone.php',{ADK_CHANGE_ID:b,ADK_CHANGE_DONE:c});}
		function d(e){var f=e.nextElementSibling,s=e.children[0].children[0];if(f.style.display=='none'){f.style.display='';s.className=s.className.replace('right','down');}else{f.style.display='none';s.className=s.className.replace('down','right');}}
	</script>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					Change log
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
				
				<div class="container-fluid">
					<div class="col-xs-12">
						<form method="post" action="includes/changelog_add.php" data-toggle="validator" role="form" novalidate>
							<div class="col-xs-12 col-sm-10">
								<div class="form-group">
									<label for="textbox_title" class="control-label control-label-sm">Title*</label><br />
									<input type="text" id="textbox_title" name="title" class="form-control form-control-sm" maxlength="40" placeholder="Title" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="form-group">
									<label for="textbox_priority" class="control-label control-label-sm">Priority*</label><br />
									<input type="number" id="textbox_priority" name="priority" class="form-control form-control-sm" maxlength="1" placeholder="1-5" min="1" max="5" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<label for="textbox_desc" class="control-label control-label-sm">Description</label><br />
									<textarea id="textbox_desc" name="desc" class="form-control form-control-sm" placeholder="Any info"></textarea>
									<span class="help-block with-errors"></span>
								</div>
								<div class="form-group">
									<span class="reqNote pull-left">* required</span>
									<button type="submit" class="btn btn-sm btn-default pull-right">Add</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				
				<div class="hr"></div>
				
				<div class="container-fluid">
					<div class="col-xs-12">
						<div class="div_tablewrapper">
							<?php echo $table_changelog; ?>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
</body>
</html>