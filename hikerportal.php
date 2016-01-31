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
	<script src="js/jquery-dl.min.js"></script>
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
			var editor = new wysihtml5.Editor('textbox_notes', {
				toolbar: 'wysihtml-toolbar'
				,parserRules: wysihtml5ParserRules
				,stylesheets: 'css/wysihtml.css'
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
								<img src="includes/getImage.php?_=<?php echo $ADK_HIKER->photoid; ?>" class="img-responsive profilephoto" alt="Photo - <?php echo $ADK_HIKER->name; ?>" title="<?php echo $ADK_HIKER->name; ?>" />
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
						<div class="col-xs-12 col-sm-2" style="margin-bottom:12px;">
							<img src="includes/getImage.php?_=<?php echo $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID']; ?>" class="img-responsive profilephoto" alt="Photo - <?php echo $ADK_CORRESPONDENT['ADK_USER_NAME']; ?>" title="<?php echo $ADK_CORRESPONDENT['ADK_USER_NAME']; ?>" />
							<span><?php echo $ADK_CORRESPONDENT['ADK_USER_USERNAME']; ?></span>
						</div>
						<div class="col-xs-12 col-sm-2">
							<label class="control-label control-label-sm">Name</label><br />
							<span><?php echo $ADK_CORRESPONDENT['ADK_USER_NAME']; ?></span>
						</div>
						<div class="col-xs-12 col-sm-8">
							<label class="control-label control-label-sm">Personal Info</label><br />
							<div class="scroll scroll100" style="word-break:break-word;">
								<span><?php echo $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO']; ?></span>
							</div>
						</div>

						<div class="form-group">
							<div class="col-xs-12 text-right">
								<br />
								<a href="./messages?_=<?php echo $ADK_CORRESPONDENT['ADK_USER_ID']; ?>" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-envelope" style="left:-2px;"></span>&nbsp;Send Message</a>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
			<?php include 'templates/hikes.php'; ?>

            <div class="col-xs-12">
				<div class="container-fluid content content-max" style="margin-bottom:15px;">
				
					<h4 class="content-header">
						<span id="h4span_addUpdateHike">Add Hike</span>
						<a class="pointer hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span id="span_maxminAddUpdateHike" class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid">
						<form id="form_addUpdateHike" method="post" onsubmit="addUpdateHike(this); return false;" data-toggle="validator" role="form" enctype="multipart/form-data" novalidate>
						
							<div class="col-xs-12">
								<div class="form-group">
									<div class="col-xs-12 col-sm-5">
										<label for="select_remainingpeaks" class="control-label control-label-sm">Peak*</label><br />
											<div class="input-group input-group-sm">
												<select id="select_remainingpeaks" class="form-control form-control-sm">
													<option />
													<?php foreach($ADK_PEAKS->peaks as $ADK_PEAK) echo '<option value="'.$ADK_PEAK->id.'">'.$ADK_PEAK->name.'</option>'; ?>
												</select>
												<span id="span_addPeak" class="input-group-addon btn-default pointer" onclick="addPeak(this.previousElementSibling);">Add</span>
											</div>
										<span class="help-block with-errors"></span>
										<div id="div_peaks_container"></div>
									</div>
									<div class="col-xs-12 col-sm-3 col-sm-offset-4">
										<div class="form-group">
											<label for="textbox_hikedate" class="control-label control-label-sm">Date*</label><br />
											<input type="text" id="textbox_hikedate" name="date" class="form-control form-control-sm date" maxlength="10" placeholder="MM/DD/YYYY" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" required />
											<span class="help-block with-errors"></span>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group">
											<label for="textbox_notes" class="control-label control-label-sm">Notes</label><br />
											<?php include 'templates/wysihtml-toolbar.php'; ?>
											<textarea id="textbox_notes" name="notes" class="form-control form-control-sm" style="min-height:100px;" placeholder="Notes, messages" maxlength="16384"></textarea>
											<span class="help-block with-errors"></span>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="jqdl-attachments form-group">
											<div class="col-xs-12">
												<label class="control-label control-label-sm">Attachments</label>
												<div class="scroll scroll100">
													<ul id="ul_hikeattachments" class="ul" style="padding-left:4px;"></ul>
												</div>
												<div id="downloader" style="padding:0;"></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-xs-12" style="margin-top:15px;">
											<span class="reqNote pull-left">* required</span>
											<div class="btn-group pull-right">
												<button type="button" class="btn btn-sm btn-default" onclick="cancelHike();">Cancel</button>
												<button type="submit" id="button_addUpdateHike" class="btn btn-sm btn-default">Add Hike</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Hidden -->
							<div style="display:none;">
								<input type="hidden" id="hikerId"name="id" value="<?php echo $ADK_HIKER->id; ?>" />
								<input type="hidden" id="hidden_peakids" name="peakids" />
								<input type="hidden" id="hidden_hikeid" name="hikeid" />
								<input type="hidden" id="hidden_prefileids" name="prefileids" />
							</div>
						
						</form>
					</div>
				
				</div>
			</div>
			
		</div>
		<?php include 'templates/footer.php'; ?>
	</div>

    <div style="display:none;">
		<form method="post" action="includes/dl.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
	</div>

    <?php include 'templates/modal/hikenotes.html'; ?>
    <?php include 'templates/modal/loading.html'; ?>
	
</body>
</html>