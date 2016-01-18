<?php $tmp = explode("\\", preg_replace('/\.php$/', '', __FILE__));$tmp = explode("/", array_pop($tmp));$GLOBALS['page'] = array_pop($tmp); ?>
<?php require_once 'includes/session.php'; ?>
<?php require_once 'includes/loginredir.php'; ?>
<?php require_once 'includes/variables.php'; ?>
<?php require_once 'messages.inc.php'; ?>

<?php include 'includes/head.php'; ?>
	<link type="text/css" href="css/wysihtml.css"  rel="stylesheet" media="screen" />
	<script src="js/wysihtml.js"></script>
	<script src="js/message.min.js"></script>
	<script src="js/jquery-dl.min.js"></script>
</head>

<body>
	<?php include 'includes/navbar.php'; ?>
	<?php include 'includes/logo.php'; ?>
	
	<div class="container-fluid">
		<?php include 'includes/navbar_sub.php'; ?>
		<div class="content-wrapper">
			
			<div class="col-xs-12 content content-max" style="margin-bottom:15px;">
				
				<h4 class="content-header">
					Messages
					<a href="#" class="hoverbtn" onclick="showHide_content(this.children[0], this.parentNode.parentNode);">
						<span class="glyphicon glyphicon-chevron-down"></span>
					</a>
				</h4>
					
				<div class="container-fluid">
				
					<div class="col-xs-12 col-md-3" style="padding:0;">
						<div class="div_tablewrapper" style="max-height:inherit;overflow-y:inherit">
							<div id="div_table_messages">
								<div id="div_table_messages">
									<?php echo $table_messages; ?>
								</div>
							</div>
							<div style="position:relative;bottom:0;">
								<div class="hr"></div>
								<div class="container-fluid" style="padding:0;">
									<div class="col-xs-6" style="padding:0 2px;">
										<div class="container-fluid" style="padding:0;">
											<div class="col-xs-12 text-center" style="padding:0;">
												<div class="btn-group">
													<button id="button_sortFromTo" class="btn btn-xs btn-default messageSort" data-sort="by">From</button>
													<button class="btn btn-xs btn-default messageSort active" data-sort="by">Date</button>
												</div>
											</div>
											<div class="col-xs-12 text-center" style="padding:0;">
												<div class="btn-group">
													<button class="btn btn-xs btn-default messageSort" data-sort="dir">Up</button>
													<button class="btn btn-xs btn-default messageSort active" data-sort="dir">Down</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-6" style="padding:0;">
										<ul class="ul" style="padding-left:4%;margin-bottom:0;">
											<li>
												<a class="hoverbtn pointer" style="display:block;" onclick="newMessage();">
													New<span class="glyphicon glyphicon-plus pull-right"></span>
												</a>
											</li>
											<li>
												<a class="hoverbtn pointer" style="display:block;" onclick="getFolder(0);">
													Inbox<span class="glyphicon glyphicon-inbox pull-right"></span>
												</a>
											</li>
											<li>
												<a class="hoverbtn pointer" style="display:block;" onclick="getFolder(1);">
													Sent<span class="glyphicon glyphicon-export pull-right"></span>
												</a>
											</li>
											<li>
												<a class="hoverbtn pointer" style="display:block;" onclick="getFolder(2);">
													Drafts<span class="glyphicon glyphicon-file pull-right"></span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<input type="hidden" id="hidden_userid" value="<?php echo $ADK_USER_ID; ?>" />
					<input type="hidden" id="hidden_usergroupcde" value="<?php echo $ADK_USERGROUP_CDE; ?>" />
					<?php if($ADK_TO_USER_ID !== '') echo '<input type="hidden" id="hidden_newMessage" />'; ?>
					<div id="div_messages_main" class="col-xs-12 col-md-9"></div>
					
				</div>
				
			</div>
			
		</div>
		<?php include 'includes/footer.php'; ?>
	</div>
	
	<div style="display:none;">
		
		<template id="template_newMessage">
			<form id="form_newMessage" action="includes/message_send.php" method="post" data-toggle="validator" role="form" enctype="multipart/form-data" novalidate>
				<div class="container-fluid content-max">
					
					<fieldset class="fieldset">
						<legend id="legend_newMessageReply">New Message</legend>
					
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-10 col-md-8">
									<?php if($ADK_USERGROUP_CDE == 'ADM' || $ADK_USERGROUP_CDE == 'COR'){?>
										<label for="select_to_username" class="control-label control-label-sm">To</label><br />
										<select id="select_to_username" name="to_username" class="form-control form-control-sm" required>
											<?php
												if($ADK_HIKERS !== ''){
													foreach($ADK_HIKERS as $ADK_HIKER){
														echo '<option value="'.$ADK_HIKER['ADK_USER_ID'].'">'.$ADK_HIKER['ADK_USER_NAME'].' ('.$ADK_HIKER['ADK_USER_USERNAME'].')</option>';
													}
												}
											?>
										</select>
										<span class="help-block with-errors"></span>
									<?php } elseif($ADK_USERGROUP_CDE == 'HIK'){?>
										<label for="textbox_to_username" class="control-label control-label-sm">To</label><br />
										<input type="text" id="textbox_to_username" name="to_username" class="form-control form-control-sm" readonly="readonly" required />
										<span class="help-block with-errors"></span>
									<?php }?>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="form-group">
								<div class="col-xs-12">
									<label for="textbox_subject" class="control-label control-label-sm">Subject</label><br />
									<input type="text" id="textbox_subject" name="subject" class="form-control form-control-sm" maxlength="45" placeholder="Subject" required />
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12" style="margin:2px 0 6px;">
							<div class="form-group">
								<div class="col-xs-12">
									<?php include 'includes/wysihtml-toolbar.php'; ?>
									<textarea id="textbox_message" name="message" class="form-control form-control-sm" style="min-height:100px;" maxlength="16384" placeholder="Message"></textarea>
									<span class="help-block with-errors"></span>
								</div>
							</div>
						</div>
						
						<div class="col-xs-12">
							<div class="jqdl-attachments form-group">
								<div class="col-xs-12">
									<label class="control-label control-label-sm">Attachments</label>
									<div class="scroll scroll100">
										<ul id="ul_messageattachments" class="ul" style="padding-left:4px;"></ul>
									</div>
									<div id="downloader" style="padding:0;"></div>
								</div>
							</div>
						</div>
												
						<div class="col-xs-12" style="margin:4px 0 2px;">
							<div class="form-group">
								<div class="col-xs-12">
									<button type="button" class="btn btn-sm btn-default" onclick="saveDraft();">Save as Draft</button>
									<div class="btn-group pull-right">
                                        <button type="button" class="btn btn-sm btn-default" onclick="cancelMessage();">Cancel</button>
										<button type="reset" class="btn btn-sm btn-default">Clear</button>
										<button type="submit" class="btn btn-sm btn-default">Send</button>
									</div>
								</div>
							</div>
						</div>
					
					</fieldset>
				
				</div>
								
				<div style="display:none;">
					<input type="hidden" name="id" value="<?php echo $ADK_USER_ID; ?>" />
					<input type="hidden" id="hidden_replyfileids" name="replyfileids" />
					<?php
						if(isset($ADK_TO_USER) && $ADK_TO_USER !== ''){
							$toID = $ADK_TO_USER['ADK_USER_ID']; $toUsername = $ADK_TO_USER['ADK_USER_USERNAME'];
							$toName = $ADK_TO_USER['ADK_USER_NAME']; $toEmail = $ADK_TO_USER['ADK_USER_EMAIL'];
						}
						else{$toID = ''; $toUsername = ''; $toName = ''; $toEmail = '';}
						echo '<input type="hidden" id="hidden_touserid" name="touserid" value="'.$toID.'" />';
						echo '<input type="hidden" id="hidden_touserusername" value="'.$toUsername.'" />';
						echo '<input type="hidden" id="hidden_tousername" value="'.$toName.'" />';
						echo '<input type="hidden" id="hidden_touseremail" name="toemail" value="'.$toEmail.'" />';
						
						if($ADK_USERGROUP_CDE == 'HIK'){
							echo '<input type="hidden" id="hidden_coruserid" name="touserid" value="'.$ADK_CORRESPONDENT['ADK_USER_ID'].'" />';
							echo '<input type="hidden" id="hidden_coruserusername" value="'.$ADK_CORRESPONDENT['ADK_USER_USERNAME'].'" />';
							echo '<input type="hidden" id="hidden_corusername" value="'.$ADK_CORRESPONDENT['ADK_USER_NAME'].'" />';
							echo '<input type="hidden" id="hidden_coruseremail" value="'.$ADK_CORRESPONDENT['ADK_USER_EMAIL'].'" />';
						}
					?>
				</div>
				
			</form>
		</template>
		
		<template id="template_viewMessage">
			<div class="container-fluid content-max">
					
				<fieldset class="fieldset">
					<legend>Message</legend>
					
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">From</label><br />
								<span id="span_messagefromusername"></span>
							</div>
							<div class="col-xs-12 col-sm-6 text-right">
								<label class="control-label control-label-sm">To</label><br />
								<span id="span_messagetousername"></span>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12 col-sm-6">
								<label class="control-label control-label-sm">Subject</label><br />
								<span id="span_messagesubject"></span>
							</div>
							<div class="col-xs-12 col-sm-6 text-right">
								<span id="span_messagedte" style="font-size:0.8em;"></span>
							</div>
							<div class="pull-right" style="margin-right:16px;">
								<a class="pointer hoverbtn" style="margin-right:25px;" onclick="deleteMessage();">
									<span class="glyphicon glyphicon-trash" title="Delete Message" data-toggle="tooltip" data-placement="left" data-container="body"></span>
								</a>
                                <a class="pointer hoverbtn" style="margin-right:25px;" onclick="printView();">
									<span class="glyphicon glyphicon-print" title="Print" data-toggle="tooltip" data-placement="bottom" data-container="body"></span>
								</a>
								<a class="pointer hoverbtn" onclick="loadModal_viewMessage();" data-toggle="modal" data-target="#div_modal_viewMessage">
									<span class="glyphicon glyphicon-fullscreen" title="Fullscreen" data-toggle="tooltip" data-placement="right" data-container="body"></span>
								</a>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12">
						<div class="hr hr75"></div>
						<div class="form-group">
							<div class="col-xs-12 col-sm-10 col-sm-offset-1 messagecontent scroll scroll300">
								<span id="span_messagecontent" class="lgtext"></span>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12">
						<div class="hr hr75"></div>
						<div class="form-group">
							<div class="col-xs-12 scroll scroll100">
								<label class="control-label control-label-sm">Attachments</label><br />
								<ul id="ul_messageattachments" class="ul" style="padding-left:4px;"></ul>
							</div>
						</div>
					</div>
					
					<div class="col-xs-12">
						<div class="form-group">
							<div class="col-xs-12">
								<?php if($ADK_USERGROUP_CDE == 'COR') echo '<a id="a_loghike" class="btn btn-sm btn-default">Log Hike</a>'; ?>
								<button type="button" id="button_reply" class="btn btn-sm btn-default pull-right" onclick="reply();">Reply</button>
							</div>
						</div>
					</div>
					
				</fieldset>

				<?php include 'templates/modal/message.html'; ?>
				
			</div>
			
			<!-- Hidden -->
			<div style="display:none;">
				<input type="hidden" id="hidden_viewmessageid" />
				<input type="hidden" id="hidden_viewfromid" />
				<input type="hidden" id="hidden_viewtoid" />
			</div>
			
		</template>
		
		<form method="post" action="includes/dl.php">
			<input type="hidden" id="hidden_fileid" name="id" />
			<input type="submit" id="button_download" />
		</form>
	
	</div>
</body>
</html>