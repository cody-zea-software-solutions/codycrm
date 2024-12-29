<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["cid"]) && isset ($_POST["cid2"]) && isset ($_POST["d_price"])) {

            if (!empty ($_POST["cid"]) && $_POST["cid"] != 0 && !empty ($_POST["cid2"]) && $_POST["cid2"] != 0) {

                if (!empty ($_POST["d_price"]) || $_POST["d_price"] == "0") {

                    if (is_numeric($_POST["d_price"]) && $_POST["d_price"] >= 0) {
                        $formattedNumber = number_format((float) $_POST["d_price"], 2, '.', '');

                        $cid = $_POST["cid"];
                        $cid2 = $_POST["cid2"];

                        $q = "SELECT * FROM `district` WHERE `district`.`id`='" . $cid . "'";
                        $d_d = Database::search($q);

                        $qq = "SELECT * FROM `district` WHERE `district`.`id`='" . $cid2 . "'";
                        $d_dq = Database::search($q);

                        if ($d_d->num_rows == 1 && $d_dq->num_rows == 1) {

                            $q2 = "SELECT * FROM `delivery_fee` WHERE `district_from`='" . $cid . "' AND `district_to`='" . $cid2 . "'";
                            $d_d_d = Database::search($q2);

                            if ($d_d_d->num_rows == 1) {
                                $q3 = "UPDATE `delivery_fee` SET `fee` = '" . $formattedNumber . "' WHERE `district_from` = '" . $cid . "' AND `district_to` = '" . $cid2 . "' ;";
                                Database::iud($q3);
                                echo "Delivey charges updated.";
                            } elseif ($d_d_d->num_rows == 0) {
                                $q4 = "INSERT INTO `delivery_fee` (`fee`,`district_from`,`district_to`) VALUES ('" . $formattedNumber . "','" . $cid . "','" . $cid2 . "')";
                                Database::iud($q4);
                                echo "Delivey charges updated.";
                            }

                        } else {
                            echo "Invalid city ID.";
                        }

                    } else {
                        echo "Invalid value.";
                    }

                } else {
                    echo "Please add a numeric value.";
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