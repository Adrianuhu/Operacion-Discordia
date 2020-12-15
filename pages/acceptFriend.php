<?php 
	require '../sessions.php';
	require_once '../db.php';
    check_session();

    acceptFriend($_SESSION['user']['cod_user'], $_POST['codUser']);
    
    header ('Location: ../main.php');
?>
