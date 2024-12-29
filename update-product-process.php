<?php
session_start();

if (isset($_SESSION["a"])) {

    require_once "db.php";  // Include the database connection

    $uemail = $_SESSION["a"]["email"];
    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        // Capture form inputs
        $pid = $_POST['pid'];  // Product ID
        $bid = $_POST['bid'];    // Meat Type ID
        $pb = $_POST['pb'];    // Box Type ID
        $pp = $_POST['pp'];    // Price

        // Validate inputs
        if (empty($pid) || empty($bid) || empty($pb) || empty($pp)) {
            echo "All fields are required.";
            exit();
        }

        if ($pp != 0 && !preg_match('/^\d+(\.\d{1,2})?$/', $pp)) {
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
            $stmt->bind_param("ii", $pid, $bid);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if a matching row was found
            if ($result->num_rows == 1) {
                // Update product details
                $update_sql = "UPDATE price_table
                               INNER JOIN box_type ON box_type.box_type_id = price_table.box_type_box_type_id
                               INNER JOIN product ON product.product_id = price_table.product_product_id 
                               SET price_table.price = ?, 
                                   price_table.box_type_box_type_id = ?
                               WHERE price_table.product_product_id = ? AND price_table.box_type_box_type_id = ? AND product.on_delete=0";

                try {
                    if ($update_stmt = Databases::$connection->prepare($update_sql)) {
                        // Bind parameters for the update query
                        $update_stmt->bind_param("diii", $pp, $pb, $pid, $bid);

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
                echo "No matching row found to update.";
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
