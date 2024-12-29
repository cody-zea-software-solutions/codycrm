<?php
require "db.php";

// Fetch sales counts for all months
$sql = "SELECT 
DATE_FORMAT(order_date, '%Y-%m') AS month,
            COUNT(*) AS sales_count
FROM `order_item`
INNER JOIN `order` ON `order`.`id`=`order_item`.`order_id`
GROUP BY
            DATE_FORMAT(order_date, '%Y-%m')
        ORDER BY
            DATE_FORMAT(order_date, '%Y-%m')";
$result = Database::search($sql);

// Prepare data
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[$row['month']] = $row['sales_count'];
}

// Encode data to JSON
$json_data = json_encode($data);

// Set the content type header to JSON
header('Content-Type: application/json');

// Output the JSON data
echo $json_data;
?>
