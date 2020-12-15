<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$resul = register_user($_POST['name'], $_POST['surname'], $_POST['nick'], $_POST['email'], $_POST['password'], $_POST['gender']);
	
	if ($resul) {
		header("Location: Home.html");
	}else {
		echo "error";
	}
	
}

?>


<!DOCTYPE html>
<html>

<head>
	<title>Create profile</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/register.css">
</head>

<body>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	
		<div class="container">
        <label for="name"><b>Name</b></label>
          <input type="text" placeholder="Enter your name" name="name" required>
          
          <label for="name"><b>Surname</b></label>
		  <input type="text" placeholder="Enter your surname" name="surname" required>

		  <label for="nick"><b>Nickname</b></label>
		  <input type="text" placeholder="Enter your nick" name="nick" required>
	  
		  <label for="password"><b>Password</b></label>
		  <input type="password" placeholder="Enter your password" name="password" required>

		  <label for="email"><b>E-mail</b></label>
		  <input type="text" placeholder="Enter your E-mail" name="email" required>

		  <label for="gender"><b>Choose your gender</b></label>
		  <select name="gender">
			  <option value="male">Male</option>
			  <option value="female">Female</option>
			  <option value="other">Other</option>
		  </select>		
			  
		  <button type="submit" class="create">Create User</button>
		</div>

	  </form>
	  

</body>

</html>