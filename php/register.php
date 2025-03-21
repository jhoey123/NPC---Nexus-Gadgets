<?php 



?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Registration Form | Nexus Gadgets</title>
      <link rel="stylesheet" href="../css/styles.css">
      <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
   </head>
   <body>
      <div class="center">
         <div class="container w-25">
            <div class="text">
               Register
            </div>
            <form action="register_process.php" method="POST">
               <div class="data">
                  <label>Username</label>
                  <input type="text" name="username" required>
               </div>
               <div class="data">
                  <label>Email</label>
                  <input type="email" name="email" required>
               </div>
               <div class="data">
                  <label>Password</label>
                  <input type="password" name="password" required>
               </div>
               <div class="data">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password" required>
               </div>
               <div class="btn">
                  <div class="inner"></div>
                  <button type="submit" name="submit">Register</button>
               </div>
               <div class="login-link">
                  Already a member? <a href="../index.php">Login now</a>
               </div>
            </form>
         </div>
      </div>
   </body>
</html>