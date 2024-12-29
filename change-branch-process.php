<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["bid"])) {

            if (!empty ($_POST["bid"])) {

                $bid = $_POST["bid"];

                $q = "SELECT * FROM `branches` WHERE `brc_id`='".$bid."'";
                $brc_d = Database::search($q);

                if($brc_d->num_rows==1){

                    $brc = $brc_d->fetch_assoc();
                    $data=array();
                    $data[]=$brc;
                    $jsonData = json_encode($data);
                    echo $jsonData;

                }else{
                    echo "Invalid branch ID";
                }

            } else {
                echo "Company vision or mission cannot be empty! ";
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