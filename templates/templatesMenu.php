<div class="dropdown">
	<a id="templates_dropdown" class="hoverbtn pointer dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		<span class="glyphicon glyphicon-tags"></span>&nbsp;Templates<span class="pull-right"><span class="caret"></span></span>
	</a>
	<ul id="ul_templates" class="dropdown-menu" aria-labelledby="templates_dropdown">
		
		<li><a class="noselect dropdown-header">Public Templates</a></li>
		<li role="separator" class="divider templates-bar-public"></li>
		<?php
			foreach($ADK_MSG_TMPLS->public as $template){
				echo '<li><a class="pointer template" data-id="'.$template->id.'">'.$template->name.'</a></li>';
			}
		?>

		<li><a class="noselect dropdown-header" style="padding-top:12px;">Private Templates</a></li>
		<li role="separator" class="divider templates-bar-private"></li>
		<?php
			foreach($ADK_MSG_TMPLS->private as $template){
				echo '<li><a class="pointer template" data-id="'.$template->id.'">'.$template->name.'</a></li>';
			}
		?>

	</ul>
</div>