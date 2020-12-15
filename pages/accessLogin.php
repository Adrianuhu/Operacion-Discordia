<?php
require_once '../db.php';

	$usu = check_user($_POST['user'], $_POST['password']);
	if($usu===false){
		$err = true;
		$user = $_POST['user'];
	}else{
		session_start();
		// $usu has two fields: mail and codRes
		$_SESSION['user'] = $usu;
		return;
    }	
?>