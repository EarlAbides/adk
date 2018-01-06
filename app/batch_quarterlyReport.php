<?php

	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/email.php';
	require_once 'includes/classes/Batch.php';
	require_once 'includes/classes/Correspondent.php';
	require_once 'includes/classes/Hiker.php';
	require_once 'includes/classes/Message.php';

	$con = connect_db();

	Batch::batch_quarterlyReport($con);

	$con->close();

?>
