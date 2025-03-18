<?php 

if (isset($_GET['error'])) {
	switch ($_GET['error']) {
   		case 'Invalid_credentials':
	  		$error = "Invalid username or password";
	  		break;
   		case 'login_error':
	  		$error = "Login error";
	  		break;
   		default:
	  		$error = "Login error";
		  	break;
	}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Popup Login Form Design | CodingNepal</title>
      <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
   </head>
   <body>
      <div class="center">
         <div class="container w-25">
            <div class="text">
               Login
            </div>
            <form action="php/login.php" method="POST">
               <div class="data">
                  <label>Username</label>
                  <input type="text" name="username" required>
               </div>
               <div class="data">
                  <label>Password</label>
                  <input type="password" name="password" required>
               </div>
               <div class="btn">
                  <div class="inner"></div>
                  <button type="submit" name="submit">login</button>
               </div>
               <div class="signup-link">
                  Not a member? <a href="php/register.php">Signup now</a>
               </div>
            </form>
         </div>
      </div>
   </body>
</html>