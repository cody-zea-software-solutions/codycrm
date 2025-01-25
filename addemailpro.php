<?php
$email = $_POST["email"];
$callcode = $_POST["callcode"];

if (empty($email)) {
     return "Please enter your email";
 } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     return "Invalid email format";
 } else if (strlen($email) > 101) {
     return "Email is too long";
 }else{
     include_once "db.php";
     Databases::iud("UPDATE `calls` SET `email` = '".$email."' 
     WHERE (`call_code` = '".$callcode."');");
     echo "Updated";
 }

?>