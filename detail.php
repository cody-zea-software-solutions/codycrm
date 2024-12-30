<?php
require 'db.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['callecode'])) {
    $callCode = $_POST['callecode'];
    $result = Databases::search("SELECT * FROM `calls` WHERE `call_code` = '$callCode'");
    if ($result->num_rows > 0) {
        $callData = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'code'=>$callData['call_code']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid call code.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No call code provided.']);
}
?>
