<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["cid"]) && isset ($_POST["cid2"])) {

            if (!empty ($_POST["cid"]) && $_POST["cid"] != 0 && !empty ($_POST["cid2"]) && $_POST["cid2"] != 0) {

                $cid = $_POST["cid"];
                $cid2 = $_POST["cid2"];

                $q1 = "SELECT * FROM `district` WHERE `id`='" . $cid . "' ";
                $qs = Database::search($q1);

                $q2 = "SELECT * FROM `district` WHERE `id`='" . $cid2 . "'  ";
                $qs2 = Database::search($q1);

                if ($qs->num_rows == 1 && $qs2->num_rows==1) {

                    $q = "SELECT * FROM `delivery_fee` WHERE `district_from`='" . $cid . "' AND `district_to`='" . $cid2 . "'";
                    $brc_d = Database::search($q);

                    if ($brc_d->num_rows == 1) {
                        $b_d = $brc_d->fetch_assoc();

                        echo ($b_d['fee']);

                    }else{
                        echo "nc";
                    }

                } else {
                    echo "Invalid city ID.";
                }

            } else {
                echo "Please select a city.";
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