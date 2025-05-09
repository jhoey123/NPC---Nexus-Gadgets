<?php 
   session_start();

   if(isset($_POST['email']) && isset($_POST['password'])) {
      include "conn_db.php";
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      if (empty($email) || empty($password)) {
         echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password.']);
         exit;
      }

      $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();

      if ($result->num_rows == 1) {
         $user = $result->fetch_assoc();
         $email_db = $user['email'];
         $password_db = $user['password'];

         if (password_verify($password, $password_db)) {
            $_SESSION['email'] = $email_db;
            $stmt = $conn->prepare("SELECT u.email, r.rank_name FROM users u JOIN ranks r ON u.rank_id = r.rank_id WHERE u.email = ?");
            $stmt->bind_param("s", $email_db);
            $stmt->execute();
            $result = $stmt->get_result();
            $user_rank = $result->fetch_assoc();
            $stmt->close();
            $conn->close();

            if ($user_rank) {
               session_regenerate_id(true);
               $rank = $user_rank['rank_name'];
               if ($rank === "Owner") {
                  echo json_encode(['success' => true]);
                  exit;
               } else if ($rank === "staff") {
                  echo json_encode(['success' => false, 'message' => 'Access restricted to staff.']);
                  exit;
               } else {
                  echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password.']);
                  exit;
               }
            } else {
               echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password.']);
               exit;
            }
         } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password.']);
            exit;
         }
      } else {
         $conn->close();
         echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password.']);
         exit;
      }
   } else {
      echo json_encode(['success' => false, 'message' => 'An unexpected error occurred. Please try again.']);
      exit;
   }
?>