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
							
				<?php if($_SESSION['ADK_USERGROUP_CDE'] !== 'EDT'){ ?>
					<div class="col-sm-12 text-right">
						<a class="pointer" onclick="editHike();">Edit</a>
						<b>&nbsp;|&nbsp;</b>
						<a class="pointer" onclick="if(confirm('Are you sure you want to delete this hike?')) deleteHike();" style="margin-right:5%;">Delete</a>
					</div>
				<?php } ?>
								
				<div class="col-xs-12 col-sm-4">
					<div class="div_tablewrapper">
						<h4 class="content-header">Peaks</h4>
						<table id="table_hikespeaks" class="selecttable">
							<thead>
								<tr>
									<th class="pointer" style="width:63%;">Name</th>
									<th class="pointer" style="width:18%;">Date</th>
									<th class="pointer" style="width:29%;">Height <small><a id="a_heightFormat" class="pointer hoverbtn" onclick="convertFormat(this);">(ft)</a></small></th>
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
						<h4 class="content-header">
							Notes
							<a class="pointer hoverbtn" onclick="modal_hike();" data-toggle="modal" data-target="#div_modal_hike">
								<span class="glyphicon glyphicon-fullscreen" title="Fullscreen" data-toggle="tooltip" data-placement="bottom" data-container="body"></span>
							</a>
							<a class="pointer hoverbtn" style="margin-right:25px;" onclick="printView();">
								<span class="glyphicon glyphicon-print" title="Print" data-toggle="tooltip" data-placement="bottom" data-container="body"></span>
							</a>
						</h4>
						<span id="span_hikenotes" class="lgtext"></span>
					</div>
				</div>
							
			</div>
		</div>
					
	</div>
</div>

<input type="hidden" id="hidden_ADK_HIKER_NAME" value="<?php echo $ADK_HIKER->name; ?>" />
<input type="hidden" id="hidden_ADK_HIKER_USERNAME" value="<?php echo $ADK_HIKER->username; ?>" />