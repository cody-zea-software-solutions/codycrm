<?php

session_start();
require "db.php";

$username = $_POST["u"];
$password = $_POST["p"];

 if (empty($password)) {
    echo "Please enter your Password";
} else if (strlen($password) < 4 || strlen($password) > 15) {
    echo "Password must be between 4 and 15 characters";
} else {
    $rs = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $username . "' AND password='" . $password . "'");
    $n = $rs->num_rows;

    if ($n == 1) {
        echo "success";
        $d = $rs->fetch_assoc();


        $_SESSION["a"] = $d;

    } else {
        echo "Invalid email or Password";
    }
}


?>