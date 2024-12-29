<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["vision"]) && isset ($_POST["mission"])) {

            if (!empty ($_POST["vision"]) && !empty ($_POST["mission"])) {

                $vision = $_POST["vision"];
                $mission = $_POST["mission"];
                
                function escapePlainText($input) {
                    return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }

                $vision = escapePlainText($vision);
                $mission = escapePlainText($mission);

                $q = "UPDATE `content_management`
                SET `vision` = '".$vision."', `mission` = '".$mission."'
                WHERE id=1;";
                Database::iud($q);
                echo "Company Vision and Mission updated.";

            } else {
                echo "Company vision or mission cannot be empty!";
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