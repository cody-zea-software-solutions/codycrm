<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["n_id"])) {

            if ($_POST["n_id"] != 0) {

                $nid = $_POST['n_id'];
                $news_d = Database::search("SELECT * FROM `news` WHERE `id` = '" . $nid . "' ");

                if ($news_d->num_rows == 1) {
                    $img_d = $news_d->fetch_assoc();
                    $img = $img_d["n_img"];

                    $q = "DELETE FROM `news` WHERE `id`='" . $nid . "' ";
                    Database::iud($q);

                    if (file_exists($img)) {
                        unlink($img);
                    }

                    echo "News Deleted Successfully";

                } else {
                    echo "News already deleted or cannot find.";
                }

            } else {
                echo "Something went wrong! Please try again later.";
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