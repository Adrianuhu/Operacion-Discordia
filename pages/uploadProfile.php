<?php
	require '../sessions.php';
	require_once '../db.php';
    check_session();

    
	$res = move_uploaded_file($_FILES["myfile"]["tmp_name"],"../images/avatar/".$_POST['nick'].".jpg");

    updateProf($_POST['name'], $_POST['surname'], $_POST['description'], $_POST['nick'].".jpg");

    
    header ('Location: ../Home.html');
 
?>


