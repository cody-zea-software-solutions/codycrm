<?php
session_start();
if (isset($_SESSION["a"])) {

    include "db.php";
    $uemail = $_SESSION["a"]["username"];
    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        $next_id = $_POST['next_id'];
        $priority = $_POST['priority'];
        $systemType = $_POST['systemType'];
        $budget = $_POST['budget'];
        $description = $_POST['description'];
        $next_date = $_POST['next_date'];
        $count = $_POST['count'];
        $call_code = $_POST['call_code'];

        // Only critical validations left
        if (empty($next_id) || $next_id == 0 || empty($next_date) || empty($count) || $count == 0 || empty($call_code)) {
            die("Something missing.");
        }

        if (!is_numeric($budget)) {
            die("Budget must be a number.");
        }

        if ($priority == 1 || $priority == 2 || $priority == 3) {
            $nextDateTime = date('Y-m-d H:i:s', strtotime($next_date . ' +96 hours'));
            $count = $count + 1;
            Databases::iud("UPDATE `next_call` SET `count` = '$count', `next_date` = '$nextDateTime' WHERE `next_id` = '$next_id'");
        }else{
            Databases::iud("UPDATE `calls` SET `st` = '0' WHERE `next_id` = '$next_id'");
        }

        $sql = "UPDATE `calls` SET `description` = '$description', `budget` = '$budget', `prioraty_id` = '$priority', `system_id` = '$systemType' WHERE `call_code` = '$call_code'";
        Databases::iud($sql);
        if (Databases::$connection->affected_rows > 0) {
            echo "success";
        } else {
            die("Something went wrong.");
        }
    }
}
