<?php
include "db.php";
$code = $_POST["code"];
$Deadline = $_POST["Deadline"];

$x = Databases::search("SELECT * FROM `ongoing_projects` WHERE   `call_id`='" . $code . "' ");
$xnum = $x->num_rows;
if ($xnum == 1) {
     Databases::iud("UPDATE `codyzea`.`ongoing_projects` SET 
     `deadline` = '" . $Deadline . "' WHERE (`call_id` = '" . $code . "');");
     echo "update Deadline";
} else {
     Databases::iud("INSERT INTO `ongoing_projects` ( `call_id`,`deadline`, `status_id`)
     VALUES ('" . $code . "','" . $Deadline . "', '1')");
     echo "insert Deadline";
}

