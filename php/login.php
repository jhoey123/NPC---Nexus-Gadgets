<?php 
   session_start();

   if(isset($_POST['submit'])) {
      include "conn_db.php";
      $username = trim($_POST['username']);
      $password = trim($_POST['password']);

      
      if (empty($username) || empty($password)) {
         header("Location: ../index.php?error=Invalid_credentials");
         exit;
      }

      $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result();
      

      if ($result->num_rows == 1) {
         $user = $result->fetch_assoc();
         

         $username_db = $user['username'];
         $password_db = $user['password'];

         if (password_verify($password, $password_db)) {
            session_regenerate_id(true);
            $_SESSION['user'] = $username;

            $stmt = $conn->prepare("SELECT u.username, r.rank_name FROM users u JOIN ranks r ON u.rank_id = r.rank_id WHERE u.username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_rank = $result->fetch_assoc();
            $conn->close();
            
            if ($user_rank) {
               $rank = $user_rank['rank_name'];
               
               if ($rank === "Owner") {
                  header("Location: ../adminpanel.php");
                  exit;
               } else if ($rank === "staff") {
                  header("Location: ../defaultpanel.php");
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
         $conn->close();
         header("Location: ../index.php?error=Invalid_credentials4");
         exit;
      }
   } else {
      header("Location: ../index.php?error=login_error");
      exit;
   }
?>