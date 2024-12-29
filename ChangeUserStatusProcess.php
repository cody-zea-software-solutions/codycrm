<?php
session_start();
if (isset($_SESSION["a"])) {

    require_once "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        $ue = $_POST["ue"];
        $st = $_POST["st"];

        if($st==1){
            $st=0;
        }else{
            $st=1;
        }


        Databases::iud("UPDATE `user` SET `status` = '" . $st . "' WHERE `email` = '" . $ue . "' ");

        echo "User status changed.";

    }
}

?>