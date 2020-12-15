<?php 
	require 'sessions.php';
	require_once 'db.php';
	check_session();
?>

    <div class="pantalla">
		<p id="nameMail"><a href="main.php">DISCORDIA</a></p>
		
		
			<button onclick="logOut()" class="logout">Log out</button>
		



        <div class="leftSide">

            <div class="buttons">
                <div class="newMsg">
                    <button class="newMsgBtn" onclick="showSB()">+ Send new message</button>
                </div>

            <div class="menu">
                <button class="tab" onclick="showContacts()">Messages</button>
                
                <?php 
                    if ($_SESSION['user']['rol'] == 0) {
                        echo '<button class="tab" onclick="showFriends()">Friends</button>';
                    }else {
                        echo '<button class="tab" onclick="showAllUsers()">All Users</button>';
                    }
                ?>

            </div>
            </div>

<div class="contacts" id="contacts">


</div>


<div class="userPerSpa">
    <div class="photo">
        
    <?php 
        $resul = load_name_user($_SESSION['user']['cod_user']);
     
        echo '
        <img src="images/avatar/'.$resul['photo'].'" class="profPict" alt="">
            </div>

            <div class="data">
        <div class="usrName">'.$resul['nick'].'</div>';
    ?>
    
		<button class="usrSpaBtn" onclick="showSBF()">
			Add friend
        </button>

        <button class="usrSpaBtn" onclick="showNewGroup()">
            New group
		</button>
		
		<button class="usrSpaBtn" onclick="showModifyProfile()">
			Profile
		</button>
              
    </div>


</div>

</div>

        
<div class="chat" id="chat1">


</div>
</div>
