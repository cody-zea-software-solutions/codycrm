<?php
session_start();
if (isset($_SESSION["a"])) {

    include "db.php";
    $uemail = $_SESSION["a"]["username"];
    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        $u_det = $u_detail->fetch_assoc();
        $user_id = $u_det["admin_id"];

        // Directly capture the form data
        $name = $_POST['name'] ;
        $mobile = $_POST['mobile'] ;
        $priority = $_POST['priority'] ;
        $systemType = $_POST['systemType'] ;
        $district = $_POST['district'] ;
        $budget = $_POST['budget'] ;
        $description = $_POST['description'] ;

        // Only critical validations left
        if (empty($name) || empty($mobile) || empty($budget) || empty($description) || $priority == 0 || $systemType == 0 || $district == 0) {
            die("Required fields are missing or incorrect.");
        }

        if (!preg_match('/^(07[0-9]{8}|04[0-9]{8})$/', $mobile)) {
            die("Invalid mobile number.");
        }
        

        if (!is_numeric($budget)) {
            die("Budget must be a number.");
        }

        // Time zone and datetime
        date_default_timezone_set('Asia/Colombo');
        $currentDateTime = date('Y-m-d H:i:s');
        $nextDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +48 hours'));

        // Get unique call code - directly use last number from database instead of file
        $lastNumber = Databases::search("SELECT `last_code` FROM `code_tracker` LIMIT 1")->fetch_assoc()['last_code'] ?? 1203;
        $newNumber = $lastNumber + 1;
        $uniqueCode = 'W' . $newNumber;

        // Update the last code in the database
        Databases::iud("UPDATE `code_tracker` SET `last_code` = $newNumber");

        if($priority == 1 || $priority == 2 || $priority == 3) {
            Databases::iud("INSERT INTO `next_call`(`count`,`call_code`,`next_date`) VALUES ('2','$uniqueCode','$nextDateTime')");
        }

        // Insert the data
        $sql = "INSERT INTO `calls` (`call_code`, `name`, `mobile`, `date_time`, `description`, `budget`, `prioraty_id`, `system_id`, `district_id`, `user_id`) 
                VALUES ('$uniqueCode', '$name', '$mobile', '$currentDateTime', '$description', '$budget', '$priority', '$systemType', '$district', '$user_id')";
        Databases::iud($sql);
        if (Databases::$connection->affected_rows > 0) {
            echo "success";
        } else {
            die("Something went wrong.");
        }
    }
}
?>
