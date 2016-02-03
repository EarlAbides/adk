<?php
	
	$errMess = '';
	$validHash = false;
	
	if(isset($_GET['_'])){//Reset password
		if(($_GET['_'] !== '') && (strlen($_GET['_']) > 8)){			
			require_once 'includes/db/db_conn.php';
			require_once 'includes/db/SELECT.php';
			require_once 'includes/classes/User.php';
			
			$con = connect_db();
			
			$last8hash = substr($_GET['_'], 0, 8);

			$ADK_USER = new User();
			$ADK_USER->id = intval(substr($_GET['_'], 8));
            if($ADK_USER->isValidHash($con, $last8hash)) $ADK_USER->get($con);
			
            $con->close();
		}
	}
	else if(isset($_GET['s'])){//Success message
		if($_GET['s'] !== ''){
			$errMess = '<span><span class="font-italic">&#8226;Email sent to </span><a href="mailto:'.$_GET['s'].'">'.$_GET['s'].'</a></span>';
		}
	}
	else if(isset($_GET['ue'])){//Error message
		$errMess = "<script>
						$(document).ready(function(){
							var a = document.createElement('a');
							a.innerHTML = '&#8226;';
							var bullet = a.innerHTML;
							
							$('#form_forgotpw').find('.form-group').each(function(){this.classList.add('has-error');});
							
							var span_servererror = document.getElementById('span_servererror');
							span_servererror.innerHTML = '<ul class=\"list-unstyled\"><li>' + bullet + 'Invalid username or email</li></ul>';
							
							$('#textbox_username, #textbox_email').one('click', function(){
								span_servererror.innerHTML = '';
								$('#form_forgotpw').find('.form-group').each(function(){this.classList.remove('has-error');});
							});
						});
					</script>";
	}
	
?>