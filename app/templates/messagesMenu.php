<div class="row messages-menu">
	<div class="col-xs-5" style="padding:0;">
		<div class="container-fluid">
			<ul class="ul ul-left">
				<li class="col-xs-12 col-sm-4 col-md-12">
					<a class="hoverbtn pointer" style="font-size:1.2em;" onclick="newMessage();">
						<span class="glyphicon glyphicon-plus"></span>&nbsp;New
					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-xs-7" style="padding:0;">
		<div class="container-fluid">
			<ul class="ul ul-left message-folder-list">
				<li class="col-xs-12 col-sm-3 col-md-12">
					<a class="hoverbtn pointer folder active" onclick="getFolder(0);">
						<span class="glyphicon glyphicon-inbox"></span>&nbsp;Inbox
					</a>
				</li>
				<li class="col-xs-12 col-sm-3 col-md-12">
					<a class="hoverbtn pointer folder" onclick="getFolder(1);">
						<span class="glyphicon glyphicon-export"></span>&nbsp;Sent
					</a>
				</li>
				<li class="col-xs-12 col-sm-3 col-md-12">
					<a class="hoverbtn pointer folder" onclick="getFolder(2);">
						<span class="glyphicon glyphicon-file"></span>&nbsp;Drafts
					</a>
				</li>
				<?php if($ADK_USERGROUP_CDE === 'COR' || $ADK_USERGROUP_CDE === 'ADM'){ ?>
					<li class="col-xs-12 col-sm-3 col-md-12">
						<?php include 'templatesMenu.php'; ?>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>