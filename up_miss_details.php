<?php
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['code'], $_POST['snote'])) {
        $callid = $_POST['code'];
        $note = $_POST['snote'];
        Databases::iud("UPDATE `calls` 
        SET  `note` = '".$note."'
         WHERE (`call_code` = '".$callid."');
        ");
        echo "Note for Call ID " . htmlspecialchars($callid) . " has been saved: " . htmlspecialchars($note);
    } else {
        echo "Error: Missing required fields.";
    }
}
?>
