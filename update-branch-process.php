<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["branch_id"]) && isset ($_POST["branch_name"]) && isset ($_POST["branch_number"]) && isset ($_POST["branch_address"])) {

            if (!empty ($_POST["branch_id"]) && !empty ($_POST["branch_name"]) && !empty ($_POST["branch_number"]) && !empty ($_POST["branch_address"])) {

                $branch_id = $_POST["branch_id"];
                $branch_name = $_POST["branch_name"];
                $branch_number = $_POST["branch_number"];
                $branch_address = $_POST["branch_address"];
                
                function escapePlainText($input) {
                    return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }

                $branch_id = escapePlainText($branch_id);
                $branch_name = escapePlainText($branch_name);
                $branch_number = escapePlainText($branch_number);
                $branch_address = $branch_address;

                 $q = "UPDATE `branches`
                 SET `brc_name` = '".$branch_name."', `brc_num` = '".$branch_number."', `brc_address` = '".$branch_address."'
                 WHERE brc_id='".$branch_id."';";
                 Database::iud($q);
                echo "Branch Details Updated.";

            } else {
                echo "Details cannot be empty!";
            }

        } else {
            echo "Please try again later!";
        }
        ;

    } else {
        echo "Invalid user!";
    }
    ;

} else {
    echo "Please log in first!";
}

?>