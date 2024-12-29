<?php
session_start();

if (isset($_SESSION["a"])) {

    require_once "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the input values from POST
            $dname = trim($_POST['dname']);
            $damount = trim($_POST['damount']);
            $dper = trim($_POST['dper']);

            // Validate if inputs are empty
            if (empty($dname) || empty($damount) || empty($dper)) {
                echo "All fields must be filled out.";
                exit; // Stop further processing if any field is empty
            }

            // Validate that damount and dper are integers (without decimals)
            if (!ctype_digit($damount) || !ctype_digit($dper)) {
                echo "Discount amount and percentage must be valid integers without decimals.\nLike 20 , Not like 20.0 20.5";
                exit; // Stop further processing if validation fails
            }

            // Convert the values to integers to avoid SQL injection issues
            $damount = (int) $damount;
            $dper = (int) $dper;

            // Establish a database connection
            Databases::setUpConnection();

            // Prepare the SQL statement to insert into the discount table
            $stmt = Databases::$connection->prepare("INSERT INTO discount (discount_name, amount, percentage) VALUES (?, ?, ?)");

            // Bind parameters to the statement
            $stmt->bind_param("sii", $dname, $damount, $dper);

            // Execute the statement and check if the insert was successful
            if ($stmt->execute()) {
                echo "success"; // Respond with success if the insert was successful
            } else {
                echo "Error inserting discount into database.";
            }

            // Close the prepared statement and database connection
            $stmt->close();
            Databases::$connection->close();
        }

    } else {
        echo "Something went wrong.Please try again.";
    }
}

?>