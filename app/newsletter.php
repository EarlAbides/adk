<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'newsletter.inc.php'; ?>

<?php include 'templates/head.php'; ?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
</head>

<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'templates/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					Quarterly Newsletter
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h3>
					
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-12">
							<form>
								<div class="form-group">
									<textarea id="textbox_report" name="report" class="form-control form-control-sm" style="min-height:400px" required><?php echo $report; ?></textarea>
								</div>

								<?php //<div class="form-group">
									//<br />
									//<button type="submit" class="btn btn-default pull-right">Send</button>
									//<br /><br />
								//</div> ?>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<h4>Correspondents</h4>
							<textarea class="form-control form-control-sm" style="min-height:200px"><?php echo implode("; ", $_corrEmails); ?></textarea>
						</div>
						<div class="col-xs-12 col-sm-6">
							<h4>Hikers</h4>
							<textarea class="form-control form-control-sm" style="min-height:200px"><?php echo implode("; ", $_hikerEmails); ?></textarea>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>
