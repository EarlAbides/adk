<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp);?>
<?php require_once 'includes/session.php';?>
<?php require_once 'includes/loginredir.php';?>
<?php require_once 'includes/variables.php';?>
<?php require_once 'hikerportal.inc.php';?>

<?php include 'includes/head.php';?>
	<script src="js/jquery.tablesorter.min.js"></script>
	<script src="js/hike.min.js"></script>
	<script src="js/jquery-dl.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.date').datepicker({
				changeMonth: true,
				changeYear: true
			});
			$('#downloader').downloader({desc: true});
			$('.selecttable').tablesorter();
		});
	</script>
</head>

<body>
	<?php include 'includes/navbar.php';?>
	<?php include 'includes/logo.php';?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php';?>
		<div class="content-wrapper">
			
			<div class="col-xs-12">
				<div class="container-fluid content content-max" style="margin-bottom:15px;">
					
					<h4 class="content-header">
						<?php echo $ADK_HIKER['ADK_USER_USERNAME'];?>
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="col-xs-12 col-sm-6">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Name</label><br />
								<span><?php echo $ADK_HIKER['ADK_USER_NAME'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Email</label><br />
								<span><a href="mailto:<?php echo $ADK_HIKER['ADK_USER_EMAIL'];?>"><?php echo $ADK_HIKER['ADK_USER_EMAIL'];?></a></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">Phone</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_PHONE'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Age</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_AGE'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Sex</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_SEX'];?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12 col-sm-6">
						<div class="hidden-xs hidden-lg" style="display:block;margin-bottom:14px;"></div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address<?php if($ADK_HIKER['ADK_HIKER_ADDRESS2'] !== ''){?>, line 1<?php }?></label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_ADDRESS1'];?></span>
							</div>
						</div>
						<?php if($ADK_HIKER['ADK_HIKER_ADDRESS2'] !== ''){?>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Address, line 2</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_ADDRESS2'];?></span>
							</div>
						</div>
						<?php }?>
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">City</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_CITY'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">State</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_STATE'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-3">
								<label class="control-label control-label-sm">Zip</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_ZIP'];?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Country</label><br />
								<span><?php echo $ADK_HIKER['ADK_HIKER_COUNTRY'];?></span>
							</div>
						</div>
					</div>
						
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Personal info</label><br />
								<span class="lgtext"><?php echo $ADK_HIKER['ADK_HIKER_PERSONALINFO'];?></span>
							</div>
						</div>
					</div>

                    <div class="col-xs-12 text-right">
						<a href="./gallery?_=<?php echo $ADK_HIKER['ADK_USER_ID'];?>">View Gallery</a>
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
						<div class="form-group">
							<div class="col-xs-12">
								<label class="control-label control-label-sm">Personal Info</label><br />
								<div class="scroll scroll100" style="word-break:break-word;">
									<span><?php echo $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO'];?></span>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-xs-12">
								<div class="hr"></div>
								<a href="./messages?_=<?php echo $ADK_CORRESPONDENT['ADK_USER_ID'];?>" class="btn btn-sm btn-default">Send Message</a>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6">
						<div class="hidden-md hidden-lg" style="display:block;">&emsp;</div>
						<div class="div_tablewrapper" style="padding:5px;">
							<img src="includes/getImage.php?_=<?php echo $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID'];?>" class="img-responsive imghover" alt="Photo - <?php echo $ADK_CORRESPONDENT['ADK_USER_NAME'];?>" title="<?php echo $ADK_CORRESPONDENT['ADK_USER_NAME'];?>" />
						</div>
					</div>
					
				</div>
			</div>
			
			<div class="col-xs-12">
				<div class="container-fluid content content-max" style="margin-bottom:15px;">
				
					<h4 class="content-header">
						My Hikes
						<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</a>
					</h4>
					
					<div class="container-fluid" style="margin-bottom:-5px;">
						<div class="col-xs-12">
							<div class="pull-right">
								<label class="control-label control-label-sm">Total Peaks:&nbsp;</label>
								<span id="span_totalpeaks"><?php echo $ADK_HIKER['ADK_HIKER_NUMPEAKS'];?></span>
							</div>
							<div id="div_table_hikes" class="div_tablewrapper">
								<?php echo $table_hikes;?>
							</div>
						</div>
					</div>
					
					<div class="container-fluid content-min">
						<div id="div_hike_data" style="margin-top:40px;">
							
							<h4 class="content-header" style="width:94%;">&nbsp;
								<a id="a_maxmin_hike_data" class="hoverbtn pointer" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
									<span class="glyphicon glyphicon-chevron-up"></span>
								</a>
							</h4>
							
							<div class="col-sm-12 text-right">
								<a class="pointer" onclick="editHike();" style="margin-right:5%;">Edit</a>
							</div>
								
							<div class="col-xs-12 col-sm-4">
								<div class="div_tablewrapper">
									<h4 class="content-header">Peaks</h4>
									<table id="table_hikespeaks" class="selecttable">
										<thead>
											<tr>
												<th class="pointer" style="width:66%;">Name</th>
												<th class="pointer" style="width:34%;">Height <small><a id="a_heightFormat" class="pointer hoverbtn" onclick="convertFormat(this);">(ft)</a></small></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
							
							<div class="col-xs-12 col-sm-8">
								<div class="hidden-sm hidden-md hidden-lg" style="display:block;">&emsp;</div>
								<div class="div_tablewrapper">
									<h4 class="content-header">Attachments</h4>
									<table id="table_hikeattachments" class="selecttable">
										<thead>
											<tr>
												<th style="width:4%;"></th>
												<th class="pointer" style="width:25%;">Name</th>
												<th class="pointer" style="width:44%;">Description</th>
												<th class="pointer" style="width:15%;">Type</th>
												<th class="pointer" style="width:12%;">Size</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
														
							<div class="col-xs-12">
								<div style="display:block;">&emsp;</div>
								<div class="div_tablewrapper">
									<h4 class="content-header">Notes</h4>
									<span id="span_hikenotes" class="lgtext"></span>
								</div>
							</div>
							
						</div>
					</div>
					
				</div>
			</div>

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
											<textarea id="textbox_notes" name="notes" class="form-control form-control-sm" style="min-height:100px;" placeholder="Notes, messages"></textarea>
											<span class="help-block with-errors"></span>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group">
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
								<input type="hidden" name="id" value="<?php echo $ADK_HIKER['ADK_USER_ID'];?>" />
								<input type="hidden" id="hidden_peakids" name="peakids" />
								<input type="hidden" id="hidden_hikeid" name="hikeid" />
								<input type="hidden" id="hidden_prefileids" name="prefileids" />
							</div>
						
						</form>
					</div>
				
				</div>
			</div>
			
		</div>
		<?php include 'includes/footer.php';?>
	</div>

    <div style="display:none;">
		<form method="post" action="includes/dl.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
	</div>

    <div id="div_modal_loading" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="h4_modal_loading">
		<div class="modal-dialog modal-sm" role="loading">
			<div class="modal-content" style="background-color:transparent;border:0;">
				<div class="modal-body">
					<br /><br /><br /><br /><br /><br />
					<img src="img/loading.gif" class="img-responsive" />
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>