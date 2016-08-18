<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'hikerportal.inc.php'; ?>

<?php include 'templates/head.php'; ?>
	<link type="text/css" href="css/wysihtml.css"  rel="stylesheet" media="screen" />
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/wysihtml.js"></script>
	<script src="js/hike.min.js"></script>
	<script src="js/jqul.min.js"></script>
    <script src="js/jquery.lazyload.min.js"></script>
    <script src="js/gallery.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.date').datepicker({
				changeMonth: true
				, changeYear: true
				, maxDate: '+2d'
				, yearRange: '-100:+0'
			});
			$('#downloader').downloader({desc: true});
			$('.dt').DataTable({pageLength: 20, lengthChange: false, order: [2, 'desc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
			$('.selecttable').tablesorter();
			window.editor = new wysihtml.Editor('textbox_notes', {
				toolbar: 'wysihtml-toolbar'
				, parserRules: wysihtmlParserRules
				, stylesheets: 'css/wysihtml.css'
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
			
			<div class="col-xs-12">
				<div class="container-fluid content content-max" style="margin-bottom:15px;">
					
					<h4 class="content-header">
						<?php echo $ADK_HIKER->username; ?>
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<div class="col-xs-12" style="margin-bottom:12px;">
								<img src="includes/fileGetImage.php?_=<?php echo $ADK_HIKER->photoid; ?>&t=t" class="img-responsive profilephoto" alt="Photo - <?php echo $ADK_HIKER->name; ?>" title="<?php echo $ADK_HIKER->name; ?>" />
								<span><?php echo $ADK_HIKER->name; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Email</label><br />
								<span><a href="mailto:<?php echo $ADK_HIKER->email; ?>"><?php echo $ADK_HIKER->email; ?></a></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">Phone</label><br />
								<span><?php echo $ADK_HIKER->phone; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Age</label><br />
								<span><?php echo $ADK_HIKER->age; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Sex</label><br />
								<span><?php echo $ADK_HIKER->sex; ?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12 col-sm-6">
						<div class="hidden-xs hidden-lg" style="display:block;margin-bottom:14px;"></div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address<?php if($ADK_HIKER->address2 !== ''){ ?>, line 1<?php } ?></label><br />
								<span><?php echo $ADK_HIKER->address1; ?></span>
							</div>
						</div>
						<?php if($ADK_HIKER->address2 !== ''){ ?>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address, line 2</label><br />
								<span><?php echo $ADK_HIKER->address2; ?></span>
							</div>
						</div>
						<?php } ?>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">City</label><br />
								<span><?php echo $ADK_HIKER->city; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">State</label><br />
								<span><?php echo $ADK_HIKER->state; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Zip</label><br />
								<span><?php echo $ADK_HIKER->zip; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Country</label><br />
								<span><?php echo $ADK_HIKER->country; ?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Personal info</label><br />
								<span class="lgtext"><?php echo $ADK_HIKER->info; ?></span>
							</div>
						</div>
					</div>

                    <div class="col-xs-12 text-right">
						<a href="./gallery?_=<?php echo $ADK_HIKER->id; ?>">View Gallery</a>
					</div>
						
				</div>
			</div>
			
			<div class="col-xs-12">
				<div class="container-fluid content content-max" style="margin-bottom:15px;">
					
					<h4 class="content-header">
						My Staff Correspondent
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="col-xs-12">
						<div class="col-xs-12 col-sm-3" style="margin-bottom:12px;">
							<img src="includes/fileGetImage.php?_=<?php echo $ADK_CORRESPONDENT->photoid; ?>&t=t" class="img-responsive profilephoto" alt="Photo - <?php echo $ADK_CORRESPONDENT->name; ?>" title="<?php echo $ADK_CORRESPONDENT->name; ?>" />
							<span><?php echo $ADK_CORRESPONDENT->username; ?></span>
						</div>
						<div class="col-xs-12 col-sm-2">
							<label class="control-label control-label-sm">Name</label><br />
							<span><?php echo $ADK_CORRESPONDENT->name; ?></span>
						</div>
						<div class="col-xs-12 col-sm-7">
							<label class="control-label control-label-sm">Personal Info</label><br />
							<div class="scroll scroll100" style="word-break:break-word;">
								<span><?php echo $ADK_CORRESPONDENT->info; ?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12 text-right">
								<br />
								<a href="./messages?_=<?php echo $ADK_CORRESPONDENT->id; ?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-envelope" style="left:-2px;"></span>&nbsp;Send Message</a>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
			<?php include 'templates/hikes.php'; ?>

            <?php include 'templates/addUpdateHike.php'; ?>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>

    <div style="display:none;">
		<form method="post" action="includes/fileGet.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
	</div>

    <?php include 'templates/modal/hikenotes.html'; ?>
    <?php include 'templates/modal/loading.html'; ?>
    <?php include 'templates/modal/gallery.html'; ?>
	
</body>
</html>