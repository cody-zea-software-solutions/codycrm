<?php

session_start();


if (isset($_SESSION["a"])) {

    require_once "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        // Capture form inputs
        $pid = $_POST["pid"];
        $pc = $_POST["pc"];
        $pm = $_POST["pm"];
        $pt = $_POST["pt"];
        $pld = $_POST["pld"];

        // Validate inputs for empty values
        if (empty($pt)) {
            echo "Title is empty";
            exit();
        }

        if (empty($pc) || $pc == 0) {
            echo "Cook Type is empty";
            exit();
        }

        if (empty($pm) || $pm == 0) {
            echo "Meat Type is empty";
            exit();
        }

        if (empty($pld)) {
            echo "Description is empty";
            exit();
        }

        $p_detail = Databases::search("SELECT * FROM `product` WHERE `product_id`='" . $pid . "'");
        if ($p_detail->num_rows == 1) {

            // Initializing unique ID for images
            $img_id_uni = uniqid();

            // Establish database connection
            Databases::setUpConnection();

            // Prepare SQL statement
            $stmt = Databases::$connection->prepare("UPDATE product
            INNER JOIN cook_type ON cook_type.cook_type_id = product.cook_type_id
            INNER JOIN meat_type ON meat_type.meat_type_id = product.meat_type_id
            SET product.product_name = ?, 
            product.cook_type_id = ?,
            product.meat_type_id = ?,
            product.description = ?
            WHERE product.product_id = ?; -- Add your condition here
            ");

            // Bind parameters
            $stmt->bind_param("siisi", $pt, $pc, $pm, $pld, $pid);

            // Execute query
            if ($stmt->execute()) {
                $product_id = $pid;
                // $product_id = $stmt->insert_id;

                if (isset($_FILES["img1"]) && $_FILES["img1"]["error"] == UPLOAD_ERR_OK) {

                    $new_file_type = pathinfo($_FILES["img1"]['name'], PATHINFO_EXTENSION);
                    $file_name = "assets-admin/images/product_img/" . $img_id_uni . "_img1_" . uniqid() . "." . $new_file_type;

                    if (move_uploaded_file($_FILES["img1"]["tmp_name"], $file_name)) {
                        // Insert image path into database
                        $pa = Databases::Search("SELECT * FROM `product_img` WHERE `product_id` = '$product_id' ORDER BY `product_img_id` ASC LIMIT 1 OFFSET 0");
                        if ($pa->num_rows == 1) {
                            $pa_row = $pa->fetch_assoc();
                            $paid=$pa_row['product_img_id'];
                            $stmt_img = Databases::$connection->prepare("UPDATE `product_img` 
                            SET `product_img_path` = ? 
                            WHERE `product_id` = ? AND `product_img_id` = ?");
                            $stmt_img->bind_param("sii", $file_name, $product_id, $paid);
                            $stmt_img->execute();
                            $stmt_img->close();

                            $file_path = $pa_row['product_img_path'];
                            if (file_exists(filename: $file_path)) {
                                if (unlink($file_path)) {
                                }
                            }

                        } else {
                            echo "Error getting product image 1.";
                            exit();
                        }

                    } else {
                        echo "Error uploading Image 1.";
                        exit();
                    }

                }

                if (isset($_FILES["img2"]) && $_FILES["img2"]["error"] == UPLOAD_ERR_OK) {

                    $new_file_type = pathinfo($_FILES["img2"]['name'], PATHINFO_EXTENSION);
                    $file_name = "assets-admin/images/product_img/" . $img_id_uni . "_img2_" . uniqid() . "." . $new_file_type;

                    if (move_uploaded_file($_FILES["img2"]["tmp_name"], $file_name)) {
                        // Insert image path into database
                        $pa = Databases::Search("SELECT * FROM `product_img` WHERE `product_id` = '$product_id' ORDER BY `product_img_id` ASC LIMIT 1 OFFSET 1");
                        if ($pa->num_rows == 1) {
                            $pa_row = $pa->fetch_assoc();
                            $paid=$pa_row['product_img_id'];
                            $stmt_img = Databases::$connection->prepare("UPDATE `product_img` 
                            SET `product_img_path` = ? 
                            WHERE `product_id` = ? AND `product_img_id` = ?");
                            $stmt_img->bind_param("sii", $file_name, $product_id, $paid);
                            $stmt_img->execute();
                            $stmt_img->close();
                            $file_path = $pa_row['product_img_path'];
                            if (file_exists(filename: $file_path)) {
                                if (unlink($file_path)) {
                                }
                            }
                        } else {
                            echo "Error getting product image 2.";
                            exit();
                        }

                    } else {
                        echo "Error uploading Image 2.";
                        exit();
                    }

                }

                if (isset($_FILES["img3"]) && $_FILES["img3"]["error"] == UPLOAD_ERR_OK) {

                    $new_file_type = pathinfo($_FILES["img3"]['name'], PATHINFO_EXTENSION);
                    $file_name = "assets-admin/images/product_img/" . $img_id_uni . "_img3_" . uniqid() . "." . $new_file_type;

                    if (move_uploaded_file($_FILES["img3"]["tmp_name"], $file_name)) {
                        // Insert image path into database
                        $pa = Databases::Search("SELECT * FROM `product_img` WHERE `product_id` = '$product_id' ORDER BY `product_img_id` ASC LIMIT 1 OFFSET 2");
                        if ($pa->num_rows == 1) {
                            $pa_row = $pa->fetch_assoc();
                            $paid=$pa_row['product_img_id'];
                            $stmt_img = Databases::$connection->prepare("UPDATE `product_img` 
                            SET `product_img_path` = ? 
                            WHERE `product_id` = ? AND `product_img_id` = ?");
                            $stmt_img->bind_param("sii", $file_name, $product_id, $paid);
                            $stmt_img->execute();
                            $stmt_img->close();
                            $file_path = $pa_row['product_img_path'];
                            if (file_exists(filename: $file_path)) {
                                if (unlink($file_path)) {
                                }
                            }
                        } else {
                            echo "Error getting product image 3.";
                            exit();
                        }

                    } else {
                        echo "Error uploading Image 3.";
                        exit();
                    }

                }

                echo "Product has been updated.";
                
            } else {
                echo "Error inserting product into database.";
            }

        }

        // Close statement and connection
        $stmt->close();
        Databases::$connection->close();

    } else {
        echo "Something went wrong. Please try again.";
    }
}

?>