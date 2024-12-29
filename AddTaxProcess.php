<?php
session_start();
require_once "../connection.php";

if (isset ($_SESSION["a"])) {
    if (isset ($_GET["vtax"])) {
        $tax = $_GET["vtax"];

        if (is_numeric($tax)) {
            // Establish database connection
        Database::setUpConnection();
        $query = "INSERT INTO `tax` (`tax_percentage`) VALUES (?)";
        $stmt = Database::$connection->prepare($query);
        $stmt->bind_param("d", $tax);  
        $stmt->execute();

        echo "success";
        }else{
            echo "Invalid tax value. Please provide a valid number.";
        }

      
    }
} else {
    echo "You Are Not An Admin";
}

  // Close statement and database connection
  $stmt->close();
  Database::$connection->close();
?>