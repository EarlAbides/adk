<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/User.php';
	
	$errMess = '';
	$validHash = false;
	
	if(isset($_GET['__'])){//Reset password
		if(($_GET['__'] !== '') && (strlen($_GET['__']) > 8)){
			$con = connect_db();//Connect to db
			if(mysqli_connect_errno())
			    return 'Error';
			
			$last8hash = substr($_GET['__'], 0, 8);
			$ADK_USER_ID = intval(substr($_GET['__'], 8, count($_GET['__'])));
            $validHash = checkValidHash($con, $ADK_USER_ID, $last8hash);
			if($validHash) $ADK_USER = getUser($con, $ADK_USER_ID);
			
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