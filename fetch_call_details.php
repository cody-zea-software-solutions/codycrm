<?php
require 'db.php'; // Include your database connection

header('Content-Type: application/json');

if (isset($_POST['callecode'])) {
    $callCode = $_POST['callecode'];
    $result = Databases::search("SELECT * FROM `calls` WHERE `call_code` = '$callCode'");

    if ($result->num_rows > 0) {
        $callData = $result->fetch_assoc();

        // Fetch system type details
        $systemTypeResult = Databases::search("SELECT * FROM `system_type` WHERE `type_id` = '{$callData['system_id']}'");
        $systemType = $systemTypeResult->fetch_assoc();

        $diss = Databases::search("SELECT * FROM `district` WHERE `district_id`='".$callData['district_id']."' ");
        if($distric = $diss->fetch_assoc()){
          $districname = $distric["district_name"];
        }else{
          $districname = "empty";
        }

        echo json_encode([
            'success' => true,
            'code'=>$callData['call_code'],
            'name' => $callData['name'],
            'date_time' => $callData['date_time'],
            'district' =>  $districname,
            'system_type' => $systemType['type_name'],
            'description' => $callData['description']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid call code.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No call code provided.']);
}
?>
