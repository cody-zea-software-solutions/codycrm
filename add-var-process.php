<?php
session_start();

if (isset($_SESSION["a"])) {

    require_once "db.php";  // Include the database connection

    $uemail = $_SESSION["a"]["email"];
    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        // Capture form inputs
        $vn = $_POST['vn'];  // Product ID
        $vb = $_POST['vb'];    // Meat Type ID
        $vp = $_POST['vp'];    // Price

        // Validate inputs
        if (empty($vn) || empty($vb) || empty($vp)) {
            echo "All fields are required.";
            exit();
        }

        // Validate price is not 0 or decimal with more than one decimal place
        if ($vn == 0 || $vb == 0 || $vp == 0 ) {
            echo "Invalid values.";
            exit();
        }
        
        if ($vp != 0 && !preg_match('/^\d+(\.\d{1,2})?$/', $vp)) {
            echo "Invalid price. Price can only have up to two decimal places.";
            exit();
        }

        // Set up the database connection
        Databases::setUpConnection();

        // Find the row in price_table based on product_product_id and box_type_box_type_id
        $sql = "SELECT * FROM price_table
                INNER JOIN box_type ON box_type.box_type_id = price_table.box_type_box_type_id
                INNER JOIN product ON product.product_id = price_table.product_product_id
                WHERE price_table.product_product_id = ? AND price_table.box_type_box_type_id = ?";

        if ($stmt = Databases::$connection->prepare($sql)) {
            // Bind parameters and execute query
            $stmt->bind_param("ii", $vn, $vb);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if a matching row was found
            if ($result->num_rows == 0) {
                // Update product details
                $update_sql = "INSERT INTO price_table (price, box_type_box_type_id, product_product_id) 
                VALUES (?, ?, ?)
                ";

                try {
                    if ($update_stmt = Databases::$connection->prepare($update_sql)) {
                        // Bind parameters for the update query
                        $update_stmt->bind_param("dii", $vp, $vb, $vn);

                        // Execute the update query
                        if ($update_stmt->execute()) {
                            echo "Variation has been updated.";
                        } else {
                            echo "Error updating product: " . $update_stmt->error;
                        }
                        // Close the update statement
                        $update_stmt->close();
                    } else {
                        echo "Error preparing update statement: " . Databases::$connection->error;
                    }
                } catch (mysqli_sql_exception $e) {
                    // Check for foreign key constraint violation (Error Code: 1451)
                    if ($e->getCode() == 1451) {
                        echo "This variation is already in the list.\nOr something went wrong. Please try again later.";  // Foreign key constraint violation
                    } else {
                        echo "Error: " . $e->getMessage();  // Other database errors
                    }
                }
            } else {
                echo "This variation is already in the list.";
            }

            // Close the select statement
            $stmt->close();
        } else {
            echo "Error preparing select statement: " . Databases::$connection->error;
        }

        // Close the database connection
        Databases::$connection->close();

    } else {
        echo "Something went wrong. Please try again.";
    }

} else {
    echo "Please log in first!";
}
?>
