<?php 
	require '../sessions.php';
	require_once '../db.php';
    check_session();

    sendFriendship($_SESSION['user']['cod_user'], $_POST['nameUser']);
  
   
?>
