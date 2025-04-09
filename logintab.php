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
         <h1 class="text-center mb-4" style="background-color: #007bff; color: white; padding: 30px; border-radius: 5px; font-size: 2.5rem;">
            NEXUS GADGETS
         </h1>
         <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center w-25 mx-auto">
               <?php echo $error; ?>
            </div>
         <?php endif; ?>
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
            </form>
         </div>
      </div>
   </body>
</html>