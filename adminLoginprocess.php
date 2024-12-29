<?php

session_start();
require "db.php";

$username = $_POST["u"];
$password = $_POST["p"];

if (empty($password) || empty($password)) {
    echo "Please enter details.";
} else {
    $rs = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $username . "' AND `password`='" . $password . "'");
    $n = $rs->num_rows;

    if ($n == 1) {
        echo "success";
        $d = $rs->fetch_assoc();

        $_SESSION["a"] = $d;
    } else {
        echo "Invalid email or Password";
    }
}
