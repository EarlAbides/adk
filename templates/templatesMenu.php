<div class="dropdown">
	<a id="templates_dropdown" class="hoverbtn pointer dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		<span class="glyphicon glyphicon-tags"></span>&nbsp;Templates<span class="pull-right"><span class="caret"></span></span>
	</a>
	<ul id="ul_templates" class="dropdown-menu" aria-labelledby="templates_dropdown">
		
		<li class="dropdown-header-public"><a class="noselect dropdown-header">Public Templates</a></li>
		<?php foreach($ADK_MSG_TMPLS->public as $template) $template->renderMessageLi(); ?>

		<li class="dropdown-header-private"><a class="noselect dropdown-header">Private Templates</a></li>
		<?php foreach($ADK_MSG_TMPLS->private as $template) $template->renderMessageLi(); ?>

	</ul>
</div>