<?php 
	require '../sessions.php';
	require_once '../db.php';
    check_session();

    create_group($_SESSION['user']['cod_user'], $_POST['users'], $_POST['nameGroup']);
   
?>
