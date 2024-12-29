<?php
session_start();

if (isset($_SESSION["a"])) {
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          require "db.php";

          $email = $_POST["email"];
          $user = Databases::search("SELECT * FROM `user` WHERE `email`='" . $email . "' ");
          $user_num = $user->num_rows;

          if ($user_num == 1) {
               $user_data = $user->fetch_assoc();
               if ($user_data["user_status"] == 1) {
                    $query = "UPDATE `user` SET `user_status` = '0' WHERE `email` = '" . $user_data["email"] . "'";
                    Databases::iud($query);
                    echo $user_data["fname"] . " " . $user_data["lname"] . " BLOCK";
               } else {
                    $query = "UPDATE `user` SET `user_status` = '1' WHERE `email` = '" . $user_data["email"] . "'";
                    Databases::iud($query);
                    echo $user_data["fname"] . " " . $user_data["lname"] . " UNBLOCK"; 
               }
          } else {
               echo "You are not a valid user";
          }
     } else {
          echo "Invalid request method";
     }
} else {
     echo "Session not set";
}
?>
