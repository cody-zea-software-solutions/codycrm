<?php

require "../connection.php";
session_start();

if (isset($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM `admin` WHERE `user_name`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset($_POST["did"])) {

            if (!empty($_POST["did"]) && $_POST["did"] != 0) {

                $did = $_POST["did"];

                $q1 = "SELECT * FROM `town` WHERE `district_id`='" . $did . "' ";
                $qs = Database::search($q1);

                while ($data = $qs->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $data['id'] ?>">
                        <?php echo $data['t_name'] ?>
                    </option>
                    <?php
                }

            } else {
                echo "Please select a ditsrict.";
            }

        } else {
            echo "Error";
        }
        ;

    } else {
        echo "Error";
    }
    ;

} else {
    echo "Error";
}

?>