<?php
	require_once '../sessions.php';	
	check_session();
	$_SESSION = array();
	session_destroy();	
	setcookie(session_name(), 123, time() - 1000);
echo "pipas";
?>
