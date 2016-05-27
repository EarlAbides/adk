<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'hikers.inc.php'; ?>

<?php include 'templates/head.php'; ?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.selecttable').DataTable({pageLength: 15, lengthChange: false, order: [1, 'asc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
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
					Hikers
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
					
				<div class="container-fluid">
					<div class="col-xs-12">
						<div id="div_hikertable" class="div_tablewrapper">
							<?php 
								$ADK_HIKERS->renderTable(); 
								if($ADK_USERGROUP_CDE === 'ADM') echo '<a href="includes/reportHikers.php">Export</a>';								
							?>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
</body>
</html>