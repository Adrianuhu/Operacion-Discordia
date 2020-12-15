
<?php 

require '../sessions.php';
require_once '../db.php';
check_session();

   if (!empty($_POST['text'])) {
        if ((isset($_SESSION['user']['cod_user']) && isset($_POST['codRoom']) && $_POST['text'] != "")) {
            send_chat_Message($_SESSION['user']['cod_user'], $_POST['codRoom'], $_POST['text']);
            setNotView($_POST['codRoom'], $_SESSION['user']['cod_user']);
        }
    }else{

        
        
        echo "Error";
    }

