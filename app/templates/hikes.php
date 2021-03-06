<div class="col-xs-12">
	<div class="container-fluid content content-max" style="margin-bottom:15px;">
				
		<h4 id="div_myhikes" class="content-header">
			<?php
				if(basename($_SERVER["PHP_SELF"], '.php') === 'hiker') echo $ADK_HIKER->username.'\'s Hikes';
				else echo 'My Hikes';
			?>
			<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
				<span class="glyphicon glyphicon-chevron-down"></span>
			</a>
		</h4>
					
		<div class="container-fluid" style="margin-bottom:-5px;">
			<div class="col-xs-12">
				<div class="pull-right" style="margin-right:1%;">
					<label class="control-label control-label-sm">Total Climbed:&nbsp;</label><span id="span_numclimbed"><?php echo $ADK_HIKER->numclimbed; ?></span><br />
					<label class="control-label control-label-sm">Total Peaks:&nbsp;</label><span id="span_numpeaks"><?php echo $ADK_HIKER->numpeaks.' ('.$ADK_HIKER->percent.'%)'; ?></span>
				</div>
				<div id="div_table_hikes" class="div_tablewrapper tablewrapper500">
					<?php $ADK_HIKES->renderTable($ADK_HIKER->numpeaks, $ADK_HIKER->numclimbed, $ADK_HIKER->percent); ?>
					<a href="includes/reportHiker.php?_=<?php echo $ADK_HIKER->id; ?>">Export</a>
				</div>
			</div>
		</div>
					
		<div class="container-fluid content-min">
			<div id="div_hike_data" style="margin-top:40px;">
							
				<h4 class="content-header">&nbsp;
					<a id="a_maxmin_hike_data" class="hoverbtn pointer" onclick="showHide_content(this.children[0], this.parentNode.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-up"></span>
					</a>
				</h4>
				
				<?php if($_SESSION['ADK_USERGROUP_CDE'] !== 'EDT'){ ?>
					<div class="col-sm-12 text-right">
						<a class="pointer" onclick="editHike();">Edit</a>
						<b>&nbsp;|&nbsp;</b>
						<a class="pointer" onclick="if(confirm('Are you sure you want to delete this hike?')) deleteHike();" style="margin-right:5%;">Delete</a>
					</div>
				<?php } ?>
				
				<div class="col-xs-12">
					<div class="div_tablewrapper" style="max-height:600px;">
						<div class="container-fluid">
							<div class="row">
								
								<div class="col-xs-12 col-sm-3">
									<table id="table_hikespeaks" class="selecttable">
										<thead>
											<tr class="content-header">
												<th class="pointer" style="width:55%;">Name</th>
												<th class="pointer" style="width:20%;">Date</th>
												<th class="pointer" style="width:35%;">Height <small><a id="a_heightFormat" class="pointer hoverbtn" onclick="convertFormat(this);">(ft)</a></small></th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
								
								<div class="col-xs-12 col-sm-9">
									<h4 class="content-header">
										Notes
										<a class="pointer hoverbtn" onclick="modal_hike();" data-toggle="modal" data-target="#div_modal_hike">
											<span class="glyphicon glyphicon-fullscreen" title="Fullscreen" data-toggle="tooltip" data-placement="bottom" data-container="body"></span>
										</a>
										<a class="pointer hoverbtn" style="margin-right:25px;" onclick="printView();">
											<span class="glyphicon glyphicon-print" title="Print" data-toggle="tooltip" data-placement="bottom" data-container="body"></span>
										</a>
									</h4>
									<p id="p_hikenotes" class="lgtext"></p>
								</div>
								
							</div>
							
							<div class="row">
								<br /><br /><br />
								<div class="col-xs-12">
									<div id="div_photos" class="scroll" style="max-height:750px;">
										<ul class="row gallery-photo"></ul>
									</div>
								</div>
								<div class="col-xs-12">
									<h4 class="gallery-video-header">Videos</h4>
									<div id="div_videos" class="scroll" style="max-height:750px;">
										<ul class="row gallery-video"></ul>
									</div>
								</div>
								<div class="col-xs-12">
									<h4 class="gallery-doc-header">Documents and Files</h4>
									<div id="div_videos" class="scroll" style="max-height:750px;">
										<ul class="row gallery-files"></ul>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
							
			</div>
		</div>
					
	</div>
</div>

<input type="hidden" id="hidden_ADK_HIKER_NAME" value="<?php echo $ADK_HIKER->name; ?>" />
<input type="hidden" id="hidden_ADK_HIKER_USERNAME" value="<?php echo $ADK_HIKER->username; ?>" />