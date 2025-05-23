<?php 
   session_start();

   if(isset($_POST['email']) && isset($_POST['password'])) {
      include "conn_db.php";
      $email = trim($_POST['email']);
      $password = trim($_POST['password']);

      if (empty($email) || empty($password)) {
         echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password1.']);
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
               if ($rank === "Admin") {
                  echo json_encode(['success' => true, 'redirect' => 'adminpanel.php']);
                  exit;
               } else if ($rank === "Staff") {
                  echo json_encode(['success' => true, 'redirect' => 'defaultpanel.php']);
                  exit;
               } else if ($rank === "Customer") {
                  echo json_encode(['success' => true, 'redirect' => 'customer.php']);
                  exit;
               } else {
                  echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password2.']);
                  exit;
               }
            } else {
               echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password3.']);
               exit;
            }
         } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password4.']);
            exit;
         }
      } else {
         $conn->close();
         echo json_encode(['success' => false, 'message' => 'Invalid credentials. Please check your email and password5.']);
         exit;
      }
   } else {
      echo json_encode(['success' => false, 'message' => 'An unexpected error occurred. Please try again6.']);
      exit;
   }
?>