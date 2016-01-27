<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'hiker.inc.php'; ?>

<?php include 'includes/head.php'; ?>
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
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
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
							echo '<a href="editHiker.php?_='.$ADK_HIKER['ADK_USER_ID'].'">Edit</a>';
                        if($_SESSION['ADK_USERGROUP_CDE'] === 'ADM'){ ?>
                            <b>&nbsp;|&nbsp;</b>
						    <a href="#" onclick="if(confirm('Are you sure you want to delete this hiker?')) $('#button_submit_delete').click();">Delete</a>
                        <?php } ?>
					</div>
					
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12 col-sm-6" style="display:inline;">
								<label class="control-label control-label-sm">Username</label><br />
								<span><?php echo $ADK_HIKER['ADK_USER_USERNAME']; ?></span>
							</div>
							<div class="col-xs-12 col-sm-6 text-right" style="display:inline;">
								<label class="control-label control-label-sm">Last Active</label><br />
								<span class="font-italic"><?php echo strpos(date("n/j/y g:ma", strtotime($ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE'])), '1/1/70') === 0? '--': date("n/j/y g:ia", strtotime($ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE'])); ?></span>
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
								<span><?php echo $ADK_HIKER['ADK_USER_NAME']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Email</label><br />
								<span><a href="mailto:<?php echo $ADK_HIKER['ADK_USER_EMAIL']; ?>"><?php echo $ADK_HIKER['ADK_USER_EMAIL']; ?></a></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">Phone</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_PHONE']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Age</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_AGE']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Sex</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_SEX']; ?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12 col-sm-6">
						<div class="hidden-xs hidden-lg" style="display:block;margin-bottom:14px;"></div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address, line 1</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_ADDRESS1']; ?></span>
							</div>
						</div>
						<?php if($ADK_HIKER['ADK_HIKER_ADDRESS2'] !== ''){ ?>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address<?php if($ADK_HIKER['ADK_HIKER_ADDRESS2'] !== ''){ ?>, line 1<?php } ?></label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_ADDRESS2']; ?></span>
							</div>
						</div>
						<?php } ?>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">City</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_CITY']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">State</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_STATE']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Zip</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_ZIP']; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Country</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_COUNTRY']; ?></span>
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
								<span class="lgtext"><?php echo $ADK_HIKER['ADK_HIKER_PERSONALINFO']; ?></span>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12" style="margin-top:10px;">
						<div class="hr hr75"></div>
					</div>
					
					<div class="col-xs-12" style="margin-top:10px;">
						<div class="form-group">
							<div class="col-xs-6">
								<a href="./messages?_=<?php echo $ADK_HIKER['ADK_USER_ID']; ?>" class="btn btn-sm btn-default">Send Message</a>
							</div>
                            <div class="col-xs-6 text-right">
								<a href="./gallery?_=<?php echo $ADK_HIKER['ADK_USER_ID']; ?>">View Gallery</a>
							</div>
						</div>
					</div>
						
				</div>
			</div>
			
			<?php include 'templates/hikes.php'; ?>
			
			<?php if($_SESSION['ADK_USERGROUP_CDE'] !== 'EDT'){ ?>
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
														<?php
															foreach($ADK_HIKER['ADK_HIKER_REMAININGPEAKS'] as $ADK_PEAK){
																if($ADK_PEAK['ADK_PEAK_COMPLETE']) $disabled = ' disabled="disabled"';
																else $disabled = '';
																echo '<option value="'.$ADK_PEAK['ADK_PEAK_ID'].'"'.$disabled.'>'.$ADK_PEAK['ADK_PEAK_NAME'].'</option>';
															}
														?>
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
												<?php include 'includes/wysihtml-toolbar.php'; ?>
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
									<input type="hidden" id="hikerId" name="id" value="<?php echo $ADK_HIKER['ADK_USER_ID']; ?>" />
									<input type="hidden" id="hidden_peakids" name="peakids" />
									<input type="hidden" id="hidden_hikeid" name="hikeid" />
									<input type="hidden" id="hidden_prefileids" name="prefileids" />
								</div>
						
							</form>
						</div>
				
					</div>
				</div>
			<?php } ?>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		<form method="post" action="includes/hiker_delete.php" role="form" novalidate>
			<input type="hidden" name="id" value="<?php echo $ADK_HIKER['ADK_USER_ID']; ?>" />
			<button type="submit" id="button_submit_delete"></button>
		</form>
		<form method="post" action="includes/dl.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
		<?php if(isset($ADK_MESSAGE)) echo "<input type=\"hidden\" id=\"hidden_ADK_MESSAGE_JSON\" value=\"".$ADK_MESSAGE."\" />"; ?>
	</div>

	<?php include 'templates/modal/hikenotes.html'; ?>
    <?php include 'templates/modal/loading.html'; ?>
	
</body>
</html>