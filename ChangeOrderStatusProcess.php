<?php
session_start();
if (isset($_SESSION["a"])) {

    require_once "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {


        $orderID = $_POST["pid"];
        $status = $_POST["sid"];


        Databases::iud("UPDATE `order` SET `order_status_id` = '" . $status . "' WHERE `id` = '" . $orderID . "' ");



        echo "success";

    }
}





?>