<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'hiker.inc.php'; ?>

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
				,changeYear: true
				,maxDate: '+2d'
				,yearRange: '-100:+0'
			});
			$('#downloader').downloader({desc: true});
			$('.dt').DataTable({pageLength: 20, lengthChange: false, order: [2, 'desc'], columnDefs: [{targets: 0, searchable: false, sortable: false}]});
			$('.selecttable').tablesorter();
			var editor = new wysihtml.Editor('textbox_notes', {
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
						Hiker
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="pull-right" style="margin-right:3%;">
						<?php if($_SESSION['ADK_USERGROUP_CDE'] !== 'EDT')
							echo '<a href="editHiker?_='.$ADK_HIKER->id.'">Edit</a>';
                        if($_SESSION['ADK_USERGROUP_CDE'] === 'ADM'){ ?>
                            <b>&nbsp;|&nbsp;</b>
						    <a href="#" onclick="if(confirm('Are you sure you want to delete this hiker?')) $('#button_submit_delete').click();">Delete</a>
                        <?php } ?>
					</div>
					
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12 col-sm-6" style="display:inline;">
								<img src="includes/fileGetImage.php?_=<?php echo $ADK_HIKER->photoid; ?>&t=t" class="img-responsive profilephoto" alt="Photo - <?php echo $ADK_HIKER->name; ?>" title="<?php echo $ADK_HIKER->name; ?>" />
								<span><?php echo $ADK_HIKER->username; ?></span>
							</div>
							<div class="col-xs-12 col-sm-6 text-right" style="display:inline;">
								<label class="control-label control-label-sm">Last Active</label><br />
								<span class="font-italic"><?php echo strpos(date("n/j/y g:ma", strtotime($ADK_HIKER->lastactive)), '1/1/70') === 0? '--': date("n/j/y g:ia", strtotime($ADK_HIKER->lastactive)); ?></span>
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
								<label class="control-label control-label-sm">Address, line 1</label><br />
								<span><?php echo $ADK_HIKER->address1; ?></span>
							</div>
						</div>
						<?php if($ADK_HIKER->address2 !== ''){ ?>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address<?php if($ADK_HIKER->address2 !== ''){ ?>, line 2<?php } ?></label><br />
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
						<div class="hr hr75"></div>
					</div>
						
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Personal info</label><br />
								<span class="lgtext"><?php echo $ADK_HIKER->info; ?></span>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12" style="margin-top:10px;">
						<div class="hr hr75"></div>
					</div>
					
					<div class="col-xs-12" style="margin-top:10px;">
						<div class="form-group">
							<div class="col-xs-6">
								<a href="./messages?_=<?php echo $ADK_HIKER->id; ?>" class="btn btn-sm btn-default">Send Message</a>
							</div>
                            <div class="col-xs-6 text-right">
								<a href="./gallery?_=<?php echo $ADK_HIKER->id; ?>">View Gallery</a>
							</div>
						</div>
					</div>
						
				</div>
			</div>
			
			<?php include 'templates/hikes.php'; ?>
			
			<?php if($_SESSION['ADK_USERGROUP_CDE'] !== 'EDT') include 'templates/addUpdateHike.php'; ?>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		<?php if($_SESSION['ADK_USERGROUP_CDE'] === 'ADM'){ ?>
			<form method="post" action="includes/hikerDelete.php" role="form" novalidate>
				<input type="hidden" name="id" value="<?php echo $ADK_HIKER->id; ?>" />
				<button type="submit" id="button_submit_delete"></button>
			</form>
		<?php } ?>
		<form method="post" action="includes/fileGet.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
		<?php if(isset($ADK_MESSAGE)) echo "<input type=\"hidden\" id=\"hidden_ADK_MESSAGE_JSON\" value=\"".htmlspecialchars(json_encode($ADK_MESSAGE))."\" />"; ?>
	</div>

	<?php include 'templates/modal/hikenotes.html'; ?>
    <?php include 'templates/modal/loading.html'; ?>
    <?php include 'templates/modal/gallery.html'; ?>
	
</body>
</html>