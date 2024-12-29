<?php

session_start();


if (isset($_SESSION["a"])) {

    require_once "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        // Capture form inputs
        $title = $_POST["t"];
        $weight = $_POST["weight"];
        $category = $_POST["cat"];
        $s_des = $_POST["s_des"];

        // Validate image
        for ($i = 1; $i <= 3; $i++) {
            if (!isset($_FILES["img" . $i]) || $_FILES["img" . $i]["error"] !== UPLOAD_ERR_OK) {
                echo "Image $i is empty or not uploaded correctly.";
                exit();
            }
        }

        // Validate inputs for empty values
        if (empty($title)) {
            echo "Title is empty";
            exit();
        }

        if (empty($category) || $category == 0) {
            echo "Cook Type is empty";
            exit();
        }

        if (empty($weight) || $weight == 0) {
            echo "Meat Type is empty";
            exit();
        }

        if (empty($s_des)) {
            echo "Description is empty";
            exit();
        }



        // Validate image type
        $allowed_image_extensions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml", "image/webp");

        for ($i = 1; $i <= 3; $i++) {
            $file_type = $_FILES["img" . $i]["type"];
            if (!in_array($file_type, $allowed_image_extensions)) {
                echo "Invalid image type for Image $i. Allowed types are JPG, JPEG, PNG, SVG, WEBP.";
                exit();
            }
        }

        // Initializing unique ID for images
        $img_id_uni = uniqid();

        // Establish database connection
        Databases::setUpConnection();

        // Prepare SQL statement
        $stmt = Databases::$connection->prepare("INSERT INTO `product` (`product_name`, `meat_type_id`, `cook_type_id`, `description`) 
                                         VALUES (?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param("siis", $title, $weight, $category, $s_des);

        // Execute query
        if ($stmt->execute()) {
            $product_id = $stmt->insert_id;

            // Process the image upload
            for ($i = 1; $i <= 3; $i++) {
                $new_file_type = pathinfo($_FILES["img" . $i]['name'], PATHINFO_EXTENSION);
                $file_name = "assets-admin/images/product_img/" . $img_id_uni . "_img" . $i . "_" . uniqid() . "." . $new_file_type;

                if (move_uploaded_file($_FILES["img" . $i]["tmp_name"], $file_name)) {
                    // Insert image path into database
                    $stmt_img = Databases::$connection->prepare("INSERT INTO `product_img` (`product_img_path`, `product_id`) VALUES (?, ?)");
                    $stmt_img->bind_param("si", $file_name, $product_id);
                    $stmt_img->execute();
                    $stmt_img->close();
                } else {
                    echo "Error uploading Image $i.";
                    exit();
                }
            }

            echo "success";

        } else {
            echo "Error inserting product into database.";
        }

        // Close statement and connection
        $stmt->close();
        Databases::$connection->close();

    } else {
        echo "Something went wrong. Please try again.";
    }
}

?>