<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'applicants.inc.php'; ?>

<?php include 'templates/head.php'; ?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
			$.extend(jQuery.fn.dataTableExt.oSort, {
				'custom-date-asc': function(a, b) {
					if(a === '--') return -1;
					if(b === '--') return 1;
					var x = new Date(a.replace(/(am|pm)/, '')), y = new Date(b.replace(/(am|pm)/, ''));
					return ((x < y) ? -1 : ((x > y) ?  1 : 0));
				},
				'custom-date-desc': function(a, b) {
					if(a === '--') return 1;
					if(b === '--') return -1;
					var x = new Date(a.replace(/(am|pm)/, '')), y = new Date(b.replace(/(am|pm)/, ''));
					return ((x > y) ? -1 : ((x < y) ?  1 : 0));
				}
			});
			$('.selecttable').DataTable({pageLength: 15, lengthChange: false, order: [1, 'asc'],
				columnDefs: [{targets: 0, searchable: false, sortable: false}, {targets: 6, type: 'custom-date'}]
			});
		});
	</script>
</head>

<body>
	<?php include 'templates/navbar.php'; ?>
	<?php include 'templates/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'templates/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max">
					
				<h4 class="content-header">
					New Applicants
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h3>
					
				<div class="container-fluid">
					<div class="col-xs-12">
						<div class="div_tablewrapper">
							<?php echo $ADK_APPLICANTS->renderTable(); ?>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>
