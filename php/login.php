<?php 
   session_start();

   if(isset($_POST['submit'])) {
      include "conn_db.php";
      $username = $_POST['username'];
      $password = $_POST['password'];

      $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows == 1) {
         $user = $result->fetch_assoc();

         $username_db = $user['username'];
         $password_db = $user['password'];

         if ($username_db === $username) {
            if (password_verify($password, $password_db)) {
               session_regenerate_id(true);
               $_SESSION['user'] = $username;

               header("Location: ../home.php");
               exit;
            } else {
               header("Location: ../index.php?error=Invalid_credentials1");
               exit;
            }
         } else {
            header("Location: ../index.php?error=Invalid_credentials2");
            exit;
         }
      } else {
         header("Location: ../index.php?error=Invalid_credentials3");
         exit;
      }
   } else {
      header("Location: ../index.php?error=login_error");
      exit;
   }
?>