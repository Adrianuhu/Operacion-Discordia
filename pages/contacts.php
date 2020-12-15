
<?php


require '../sessions.php';
require_once '../db.php';
check_session();

    // select u.cod_user, nick, photo, count(*), ur.cod_room

        $room = load_room($_SESSION['user']['cod_user']);
        if ($room === false) {
            echo "<p class='error'>You have no chats :(</p>";
        } else {
            foreach($room as $ro){	
                $view = "";

                if ($ro["typeOfRoom"] == "chat") {
                    $picture = $ro["photo"];
                    $name = $ro["nick"];
                }else {
                    $picture = $ro["img_room"];
                    $name = $ro["codRoom"];
                }

                $view_MSG = load_view($_SESSION['user']['cod_user'], $ro["codRoom"] );
                if($view_MSG===false){
                    echo "<p class='error'>Error connecting to the database, or no room present</p>";
                }else{
                    if ($view_MSG['view'] == 0) {
                        $view = "notView";
                    }
                }

            
                $codRoomString = '\''.$ro["codRoom"].'\'';
                $pictureString = '\''.$picture.'\'';
                $nameString = '\''.$name.'\'';
                        
                    echo '

                    <div onclick="loadChat('.$codRoomString.','.$pictureString.', '.$nameString.')" class="person '.$view.'">

                    
                        <button class="person2">
                            <img class="profPict" src="images/avatar/'.$picture.'"alt="image_user">
                            <div class="friendName">'.$name.'</div>
                        </button>
    
                    </div>
                    ';
                
            }

        }

    ?>

