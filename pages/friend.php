<?php 
	require '../sessions.php';
	require_once '../db.php';
	check_session();


        $room = load_friends($_SESSION['user']['cod_user']);
        if ($room === false) {
            echo "<p class='error'>You have no friends </p>";
        } else {
            foreach($room as $ro){	

                $picture = $ro["photo"];
                $name = $ro["nick"];
                $codUser = $ro["cod_user"];
                
               if ($ro["status"] == 2) {

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


            $friendReq = checkAcceptDeny($_SESSION['user']['cod_user']);
        
            foreach($friendReq as $ro){	

                $picture = $ro["photo"];
                $name = $ro["nick"];
                $codUser = $ro["cod_user"];
                
               if ($ro["status"] == 0) {
                   echo'
                   <div class="person">

                   <img class="profPict" src="images/avatar/'.$picture.'"alt="image_user">
                        <div class="rest">
                            <div class="friendName">'.$name.'</div>
                            
                            <div class="acDecBut">
                                <button onclick="acceptFriend('.$codUser.')" class="ac">Y</button>
                                <button onclick="denyFriend('.$codUser.')" class="dec">N</button>
                            </div>
                        </div>
                    </div>
    
                </div>

                   ';
               }               
            }
         

        }

    ?>
