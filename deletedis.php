<?php
session_start();
if (isset($_SESSION["a"])) {

    require_once "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ddelete = trim($_POST['ddelete']);

            if (empty($ddelete) || $ddelete == 0) {
                echo "Invalid discount ID.";
                exit;
            }

            Databases::setUpConnection();

            $stmt = Databases::$connection->prepare("SELECT * FROM discount WHERE discount_id = ?");
            $stmt->bind_param("i", $ddelete);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt_delete = Databases::$connection->prepare("DELETE FROM discount WHERE discount_id = ?");
                $stmt_delete->bind_param("i", $ddelete);
                if ($stmt_delete->execute()) {
                    echo "deleted";
                } else {
                    echo "Error deleting discount.";
                }
                $stmt_delete->close();
            } else {
                echo "Discount not found.";
            }

            $stmt->close();
            Databases::$connection->close();
        }

    } else {
        echo "Something went wrong. Please try again.";
    }
}
?>