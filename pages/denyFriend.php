<?php 
	require '../sessions.php';
	require_once '../db.php';
    check_session();

    denyFriend($_SESSION['user']['cod_user'], $_POST['codUser']);
    
    header ('Location: ../main.php');
?>
