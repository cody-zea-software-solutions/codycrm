<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["email"]) ) {

            if (!empty ($_POST["email"]) ) {

                $email = $_POST["email"];

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    function escapePlainText($input) {
                        return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    }
    
                    $email = escapePlainText($email);
    
                    $q = "UPDATE `content_management`
                    SET `contact_email` = '".$email."'
                    WHERE id=1;";
                    Database::iud($q);
                    echo "Contact email updated.";

                }else{
                    echo "Invalid email address.";
                }

            } else {
                echo "Contact email cannot be empty!";
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