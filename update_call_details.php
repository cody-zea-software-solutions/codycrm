<?php
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cid'], $_POST['des'], $_POST['note'])) {
        $callid = $_POST['cid'];
        $description = $_POST['des'];
        $note = $_POST['note'];
         Databases::iud("UPDATE `calls` 
         SET `description` = '".$description."', `note` = '".$note."'
          WHERE (`call_code` = '".$callid."');
         ");
        echo "Call details updated successfully!";
    } else {
        echo "Error: Missing required fields.";
    }
}
?>
