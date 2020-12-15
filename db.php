<?php

// load db data
function load_config($name, $schema){
	$config = new DOMDocument();
	$config->load($name);
	$res = $config->schemaValidate($schema);
	if ($res===FALSE){ 
	   throw new InvalidArgumentException("Check configuration file");
	} 		
	$data = simplexml_load_file($name);	
	$ip = $data->xpath("//ip");
	$name = $data->xpath("//name");
	$user = $data->xpath("//user");
	$password = $data->xpath("//password");	
	$conn_string = sprintf("mysql:dbname=%s;host=%s", $name[0], $ip[0]);
	$result = [];
	$result[] = $conn_string;
	$result[] = $user[0];
	$result[] = $password[0];
	return $result;
}

// return name from a coduser
function load_name_user($coduser){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "SELECT * FROM `user` 
	WHERE cod_user like '$coduser'";
	
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
	}
	
    $r = $resul->fetch();
	return $r;	
}

// check the nick and password from a user
function check_user($nick, $password){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select cod_user, rol from user where (nick = '$nick' or mail ='$nick')";
	
	
	$resul = $db->query($ins);

	if($resul->rowCount() === 1){	

		$hash = "select password_hash from user where (nick = '$nick' or mail ='$nick')";
		$hash_resul = $db->query($hash);
		$pass = $hash_resul->fetch();
		$pass_hash = $pass['password_hash'];

		if(password_verify($password, $pass_hash)){		
			return $resul->fetch();	
		}else{
			return FALSE;
		}	

	}else{
	return FALSE;
	}		

}

// register a user
function register_user($name, $surname, $nick, $email, $password, $gender){
	
        $res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
		$db = new PDO($res[0], $res[1], $res[2]);

		$password_hash = password_hash($password, PASSWORD_DEFAULT);

		$ins = "INSERT INTO `user` 
		(`cod_user`, `name`, `surname`, `nick`, `mail`, `photo`, `password_hash`, `description`, `gender`, `rol`) VALUES 
		(NULL, '$name', '$surname', '$nick', '$email', 'default.png', '$password_hash', '', '$gender',0)";

		$resul = $db->query($ins);
		
		if (!$resul) {
			return FALSE;
		}
		
		return $resul;

}


// insert a new message into the chat, if the chat not exits it is created
function send_Message($myUser, $toUser, $message){

		$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);

	$severalUser = explode(" ", $toUser);

	foreach ($severalUser as $toUser ) {
		$insCod = "select cod_user from user 
	where nick like '$toUser'";
	$resulCod = $db->query($insCod);

	
	if ($resulCod->rowCount() !== 0) {    
		$CodResult = $resulCod->fetch();

	$ins = "select count(*) as count, group_concat(cod_user separator ',') as users, cod_room
    from user_room 
    group by cod_room
    having count like 2";
	
	$resul = $db->query($ins);
	$r = $resul->fetch();
	
    $result = $db->query($ins);
    
    if (!$r) {
		createTable ($myUser, $CodResult[0]);
	}
	
	$cod_room = "";
	
    foreach($result as $re){

			if ($re['users']==($myUser.",".$CodResult[0]) || $re['users']==($CodResult[0].",".$myUser)) {
				$cod_room = $re['cod_room'];
			   }else {
				$cod_room = createTable($myUser, $CodResult[0]);
			   }
	}

	$ins = "INSERT INTO `message` (`cod_message`, `cod_user`, `text_message`, `date_message`, `cod_room`) VALUES (NULL, '$myUser', '$message', current_timestamp(), '$cod_room')";
	$insertMessage = $db->query($ins);
	}
	}

}


// create a room  with 2 users
function createTable ($userA, $userB){
    $res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	
	$userFirst ="";
	$userSecond ="";

	if ($userA > $userB) {
		$userFirst = $userB;
		$userSecond = $userA;
	}else {
		$userFirst = $userA;
		$userSecond = $userB;
	}
    
    $ins = " INSERT INTO `room` (`cod_room`, `img_room`, `typeOfRoom`) VALUES ('$userFirst-$userSecond', '', 'chat')"; 
    $resul = $db->query($ins);

    $ins = " INSERT INTO `user_room` (`cod_user`, `cod_room`, `view`) VALUES ('$userFirst', '$userFirst-$userSecond', '1'), ('$userSecond', '$userFirst-$userSecond', '0')"; 
	$resul = $db->query($ins);
	return $userFirst.'-'.$userSecond;
}


// load a list of active chats
function load_room($cod){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select u.cod_user as codUser, nick, photo, count(*) as count, ur.cod_room as codRoom, img_room, max(date_message) as date_msg, typeOfRoom from user as u
	join user_room as ur
	on u.cod_user = ur.cod_user
    join room as r
    on r.cod_room = ur.cod_room
    join message as m
    on r.cod_room = m.cod_room
	where ur.cod_room in
	(select ur.cod_room from user as u
	join user_room as ur
	on u.cod_user = ur.cod_user
	where u.cod_user like '$cod'
	group by ur.cod_room)
	and u.cod_user not like '$cod'
	group by ur.cod_room
    order by date_msg desc";
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
    }
	//if there is one or more
	return $resul;	
}


// load a list with the user's friends
function load_friends($myUser){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select nick, photo, cod_user, status from
    (select if(userA not like '$myUser', userA, userB) as otherUser, sum(status) as status from friend as f
    where userA like '$myUser' or userB like '$myUser'
    group by code) as inter
    join user as u
    on inter.otherUser = u.cod_user";
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
    }
	//if there is one or more
	return $resul;	
}


// admin function to load all registered users 
function load_allUser(){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select nick, photo, cod_user
    from user
    where rol not like '1'";
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
    }
	//if there is one or more
	return $resul;	
}


// load content from a specific chat
function load_chat($cod){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select u.cod_user as codUser, nick, photo, cod_room as codRoom, text_message, date_message from user as u
    join message as m
    on u.cod_user = m.cod_user
	where m.cod_room like '$cod'
	order by date_message";
	
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
    }
	return $resul;	
}


// insert a  meesage into a chat
function send_chat_Message($myUser, $room, $message){

	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);

    $ins = "INSERT INTO `message` (`cod_message`, `cod_user`, `text_message`, `date_message`, `cod_room`) VALUES (NULL, '$myUser', '$message', current_timestamp(), '$room');";
    $result = $db->query($ins);

}


// function to create a group
function create_group($myUser, $toUserGroup, $name_group){

	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);

	$severalUser = explode(" ", $toUserGroup);
	
	$ins = "select * from room
	where cod_room like '$name_group'";

	$resul = $db->query($ins);
		if ($resul->rowCount() !== 0) {    
		return FALSE;
	}

	$ins = "INSERT INTO `room` (`cod_room`, `img_room`, `typeOfRoom`) VALUES ('$name_group', 'default_group.jpg', 'group')";
	$result = $db->query($ins);
	

	$ins = "INSERT INTO `user_room` (`cod_user`, `cod_room`, `view`) VALUES ('$myUser', '$name_group', '1')";
	$result = $db->query($ins);
	
	foreach ($severalUser as $toUser ) {	
	$insCod = "select cod_user from user 
	where nick like '$toUser'";
	$resulCod = $db->query($insCod);

	if ($resulCod->rowCount() !== 0) {
		$CodResult = $resulCod->fetch();
		$ins = "INSERT INTO `user_room` (`cod_user`, `cod_room`, `view`) VALUES ('$CodResult[0]', '$name_group', 0)";
		
		$result = $db->query($ins);
	}

	}

	$ins = "INSERT INTO `message` (`cod_message`, `cod_user`, `text_message`, `date_message`, `cod_room`) VALUES (NULL, '$myUser', 'Welcome to this group', current_timestamp(), '$name_group'); ";
	
	$result = $db->query($ins);
}


// function to check if a user has visited a chat with new messages
function load_view($coduser, $codroom){
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select * from user_room
	where cod_user like '$coduser' and cod_room like '$codroom';";
	
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
	}
	
    $r = $resul->fetch();
	return $r;	
}


// function to set as "not view" a chat from one or more users
function setNotView($codRoom, $codUser)
{
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	
	$ins = "UPDATE user_room SET view='0' WHERE cod_room='$codRoom' and cod_user not like '$codUser' ";
	
	$result = $db->query($ins);
}


// function to set as "view" a chat from one or more users 
function setView($codRoom, $codUser)
{
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);

	$ins = "UPDATE user_room SET view='1' WHERE cod_room='$codRoom' and cod_user like '$codUser' ";
	
	$result = $db->query($ins);
}


// function to update user's profiles
function updateProf($name, $surname, $description, $photo){
	$myUser = $_SESSION['user']['cod_user'];
	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");

	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "UPDATE `user` SET `name`='$name',`surname`='$surname', `photo`='$photo', `description`='$description'
	WHERE cod_user like'$myUser'"; 
	
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
	}
	
    $r = $resul->fetch();
	return $r;	
}


// accept friendship
function acceptFriend($myUser, $otherUser){

	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "UPDATE `friend` SET `status`='1'
	WHERE (userA like'$myUser' and userB like '$otherUser') or (userB like'$myUser' and userA like '$otherUser')"; 

	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
	}
	
    $r = $resul->fetch();
	return $r;	
}


// deny friendship
function denyFriend($myUser, $otherUser){

	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "DELETE from `friend`
	WHERE (userA like'$myUser' and userB like '$otherUser') or (userB like'$myUser' and userA like '$otherUser')"; 

	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
	}
	
    $r = $resul->fetch();
	return $r;	
}


// function to show pending users to accept or deny friendship
function checkAcceptDeny($myUser){

	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);
	$ins = "select nick, photo, cod_user, status from
    (select if(userA not like '$myUser', userA, userB) as otherUser, (status) as status from friend as f
    where userA like '$myUser') as inter
    join user as u
    on inter.otherUser = u.cod_user";
	$resul = $db->query($ins);	
	if (!$resul) {
		return FALSE;
	}
	if ($resul->rowCount() === 0) {    
		return FALSE;
    }
	//if there is one or more
	return $resul;	
}


// send friendship
function sendFriendship($myUser, $NameOtherUser){

	$res = load_config(dirname(__FILE__)."/configuration.xml", dirname(__FILE__)."/configuration.xsd");
	$db = new PDO($res[0], $res[1], $res[2]);

	$ins = "select cod_user from user
	where nick like '$NameOtherUser'";
	
    $resul = $db->query($ins);
	$r = $resul->fetch();
	$otherUser = $r[0];

	$varMin = "";
	$varMax = "";

	if ($myUser > $otherUser ) {
		$varMax = $myUser;
		$varMin = $otherUser;
	}else {
		$varMax = $otherUser;
		$varMin = $myUser;
	}

    $ins = "INSERT INTO `friend` (`userA`, `userB`, `status`, `code`) 
	VALUES ('$varMin', '$varMax', '0', '$varMin-$varMax'), ('$varMax', '$varMin', '1', '$varMin-$varMax')";
	
    $result = $db->query($ins);
}



