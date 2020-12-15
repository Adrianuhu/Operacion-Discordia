<?php 
	require '../sessions.php';
	require_once '../db.php';
    check_session();

    send_Message($_SESSION['user']['cod_user'], $_POST['user'], $_POST['text']);
    
    header ('Location: main.php');
?>
