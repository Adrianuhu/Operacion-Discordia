<div id="login">
    <div class="containerLog" >
        <a class="linkT" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&list=PLahKLy8pQdCM0SiXNn3EfGIXX19QGzUG3">
            <div class="image"></div>
        </a>

        <div class="companyNameLog"> DISCORDIA</div>

		<form onsubmit = "return accessLogin();">
		
            <div class="log">
                <label for="user"><b>Username or E-mail</b></label>
                <input id="user" type="text" placeholder="Enter Username or E-mail" name="user" value = "<?php if(isset($user))echo $user;?>">

                <label for="password"><b>Password</b></label>
                <input id="password" type="password" placeholder="Enter Password" name="password" required>

                <button class="btn" type="submit">Login</button>
                <button class="singIn" onclick="window.location.href='register.php';">Sing in</button>
				
					<?php 
						if(isset($_GET["redirected"])){
						echo "<p>Login to continue</p>";
					}?>
					<?php 
						if(isset($err) and $err == true){
						echo '<p>Check user and password</p>';
					}?>

            </div>

        </form>

    </div>
    </div>