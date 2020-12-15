<?php
require '../sessions.php';
require_once '../db.php';

/* Get the name of the uploaded file */
$filename = $_FILES['file']['name'];

//$filename = $_POST['code_room'];

/* Choose where to save the uploaded file */
$location = "../files/".$filename;

/* Save the uploaded file to the local filesystem */
if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 
  echo 'Success'; 
} else { 
  echo 'Failure'; 
}

send_chat_Message( $_POST['code_my_usr'], $_POST['code_room'], "http://localhost/Operacion-Discordia/files/".$_FILES['file']['name']);
setNotView($_POST['codRoom'], $_SESSION['user']['cod_user']);

?>