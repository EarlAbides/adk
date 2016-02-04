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
							<ul id="ul_addpeaks"></ul>
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
				
				<div style="display:none;">
					<input type="hidden" id="hikerId" name="id" value="<?php echo $ADK_HIKER->id; ?>" />
					<input type="hidden" id="hidden_peaks" name="peaks" />
					<input type="hidden" id="hidden_hikeid" name="hikeid" />
					<input type="hidden" id="hidden_prefileids" name="prefileids" />
				</div>
				
			</form>
		</div>
		
	</div>
</div>