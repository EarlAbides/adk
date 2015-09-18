<?php
	
	$newMessageHtml = '';
	
	if(!isset($_SESSION['ADK_USER_ID'])){
		if(isset($_GET['e'])){
			$error = $_GET['e'];
			
			//Login 
			if(strpos($error, 'l') != -1){
				$open = ' open';
				$haserror = ' has-error';
				echo "<script>
						$(document).ready(function(){
							var a = document.createElement('a');
							a.innerHTML = '&#8226;';
							var bullet = a.innerHTML;
						
							var span_passworderror = document.getElementById('span_passworderror');
							span_passworderror.innerHTML = '<ul class=\"list-unstyled\"><li>' + bullet + 'Invalid username or password</li></ul>';
						
							$('#input_username, #input_password, #a_logindropdown').one('click', function(){
								span_passworderror.innerHTML = '';
								$('#form_login').find('.form-group').each(function(){this.classList.remove('has-error');});
							});
						});
					</script>";
			}
		}
	}
	else{//Logged in
	
		echo "<script>
				$(document).ready(function(){
							$.get('includes/ajax_messageGetNewCount.php?_=".$_SESSION['ADK_USER_ID']."',
								function(ret){
									if(parseInt(ret) > 0){
										var html = '<span class=\"badge newmessages\">' + ret + '</span>';
										document.getElementById('span_messages').innerHTML = html;
									}
								});
						});
					</script>";
	}
	
?>

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		
		<?php if(!isset($_SESSION['ADK_USER_ID'])){//Not logged in?>
			<div class="collapse navbar-collapse" id="navbar">
				<form id="form_nav_login" action="includes/login.php" method="post" class="form-inline" data-toggle="validator" role="form" novalidate>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown<?php if(isset($open)) echo $open;?>">
							<a href="#" id="a_logindropdown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Login <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li>
									<div class="form-group<?php if(isset($haserror)) echo $haserror;?>">
										<div class="col-xs-12" style="padding:0 12px;">
											<label for="input_username" class="control-label control-label-sm" style="margin:0;">Username</label><br />
											<input type="text" id="input_username" name="username" class="form-control input-sm" required />
											<span class="help-block with-errors"></span>
										</div>
									</div>
									<div class="form-group<?php if(isset($haserror)) echo $haserror;?>">
										<div class="col-xs-12" style="padding:0 12px;">
											<label for="input_password" class="control-label control-label-sm" style="margin:0;">Password</label><br />
											<input type="password" id="input_password" name="password" class="form-control input-sm" required />
											<span id="span_passworderror" class="help-block with-errors"></span>
										</div>
									</div>
								</li>
								<li style="display:inline;margin-top:4px;">
									<div style="display:inline;padding:0 4px;">
										<a href="./forgot" style="font-size:0.8em;display:inline;position:absolute;bottom:4px;">Forgot password?</a>
									</div>
									<input type="hidden" name="page" value="<?php if(isset($page)) echo $page;?>" />
									<button type="submit" class="btn btn-sm btn-default pull-right" style="margin:4px 4px 0 0;">Log in</button>
								</li>
							</ul>
						</li>
					</ul>
				</form>
			</div>
		<?php }else{//Is logged in?>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="./messages" style="padding-right:0;">
							<span id="span_messages" class="glyphicon glyphicon-envelope" title="Messages" data-toggle="tooltip" data-placement="bottom" data-container="body"></span>
							<span class="hidden-sm hidden-md hidden-lg">&nbsp;Messages</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="#" id="a_logindropdown" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;
							<?php echo $_SESSION['ADK_USER_USERNAME'];?>&nbsp;<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="./profile">Edit Profile <span class="glyphicon glyphicon-home pull-right"></span></a>
							</li>
							<li>
								<a href="includes/logout.php">Logout <span class="glyphicon glyphicon-log-out pull-right"></span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		<?php }?>		
	</div>
</nav>