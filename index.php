<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
    	
    	<form class="shadow w-450 p-5 rounded-4" action="php/login.php" method="post">
    		<h4 class="display-4  fs-1">LOGIN</h4><br>

    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>  
		    <?php } ?>

		  <div class="mb-3">
		    <label class="form-label">User name</label>
		    <input type="text" class="form-control" name="uname">
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Password</label>
		    <input type="password" class="form-control" name="pass">
		  </div>
		  
		  <button type="submit" name="login" class="btn btn-primary">Login</button>
		  <a href="index.php" class="link-secondary">Sign Up</a>
		</form>
    </div>
</body>
</html>