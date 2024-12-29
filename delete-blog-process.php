<?php

require "../connection.php";
session_start();

if (isset ($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset ($_POST["b_id"])) {

            if ($_POST["b_id"] != 0) {

                $bid = $_POST['b_id'];
                $blog_d = Database::search("SELECT * FROM `blog` WHERE `id` = '" . $bid . "' ");

                if ($blog_d->num_rows == 1) {
                    $img_d = $blog_d->fetch_assoc();
                    $img = $img_d["b_img"];

                    $q = "DELETE FROM `blog` WHERE `id`='" . $bid . "' ";
                    Database::iud($q);

                    if (file_exists($img)) {
                        unlink($img);
                    }

                    echo "Blog Deleted Successfully";

                } else {
                    echo "Blog already deleted or cannot find.";
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