<?php

	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/email.php';
	require_once 'includes/classes/Batch.php';
	require_once 'includes/classes/Hiker.php';

	$con = connect_db();

	Batch::inactiveUsers($con);

	$con->close();

?>
