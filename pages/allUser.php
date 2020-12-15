<?php 
	require '../sessions.php';
	require_once '../db.php';
	check_session();


        $room = load_allUser();
        if ($room === false) {
            echo "<p class='error'>Not exist users yet</p>";
        } else {
            foreach($room as $ro){	

                $picture = $ro["photo"];
                $name = $ro["nick"];
                $codUser = $ro["cod_user"];
            
                echo '

                <div onclick="loadFriendProfile('.$codUser.')" class="person" method = "POST">

        
                    <input name = "name_chat" type="hidden" value = '.$name.'>
                    <input name = "avatar_chat" type="hidden" value = "'.$picture.'">                        
                    <button type="submit" class="person2">
                        <img class="profPict" src="images/avatar/'.$picture.'"alt="image_user">
                        <div class="friendName">'.$name.'</div>
                    </button>

                </div>
                ';
                  
            }

        }

    ?>
