<?php

require "../connection.php";
session_start();

if (isset($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset($_POST["did"]) && !empty($_POST["did"]) && $_POST["did"] != 0) {
            $did = $_POST["did"];

            if (isset($_POST["town_col_count"]) || empty($_POST["town_col_count"]) || !is_numeric($_POST["town_col_count"])) {
                $town_col_count = $_POST["town_col_count"];

                $doneFlag = false;

                if ($town_col_count >= 1) {

                    for ($z = 1; $z <= $town_col_count; $z++) {
                        if (!isset($_POST["tnid" . $z]) || empty($_POST["tnid" . $z])) {
                            die("Town " . $z . " name cannot be empty.\n");
                        }
                    }

                    Database::setUpConnection();

                    for ($i = 1; $i <= $town_col_count; $i++) {

                        if (isset($_POST["tnid" . $i]) && !empty($_POST["tnid" . $i])) {

                            $value = $_POST["tnid" . $i];

                            $stmt = Database::$connection->prepare("INSERT INTO `town`(`t_name`,`district_id`) VALUES(?,?)");
                            $stmt->bind_param("si", $value, $did);
                            if ($stmt->execute()) {
                                $doneFlag = true;
                            } else {
                                $doneFlag = false;
                            }
                            ;

                        } else {
                            die("Town name cannot be empty.\n");
                        }
                    }

                    if ($doneFlag == true) {
                        echo "Towns added successfully !";
                    } else {
                        echo "Something went wrong !";
                    }

                    $stmt->close();
                    Database::$connection->close();

                } else {
                    echo "Please add some towns.";
                }

            } else {
                echo "Please try again later.";
            }

        } else {
            echo "Please select a district first.";
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