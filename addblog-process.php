<?php

require "../connection.php";
session_start();

if (isset($_SESSION["a"])) {

    $uemail = $_SESSION["a"]["user_name"];

    $u_detail = Database::search("SELECT * FROM admin WHERE user_name='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        if (isset($_POST["b_id"]) && isset($_POST["b_name"]) && isset($_POST["b_body"])) {

            if (!empty($_POST["b_name"]) && !empty($_POST["b_body"])) {

                if ($_POST["b_id"] == 0) {

                    $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml","image/webp");

                    if (isset($_FILES["b_img"])) {

                        $image_file = $_FILES["b_img"];
                        $file_extention = $image_file["type"];
                        $file_size = $image_file["size"];
                        $maxFileSize = 1024 * 1024 * 5;

                        if (in_array($file_extention, $allowed_image_extentions)) {

                            if ($file_size <= $maxFileSize) {

                                $b_name = $_POST["b_name"];
                                $b_body = $_POST["b_body"];

                                function escapePlainText($input)
                                {
                                    return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                }

                                $b_name = escapePlainText($b_name);
                                $b_body = escapePlainText($b_body);

                                function encodeEmojisToHtmlEntities($input)
                                {
                                    // Split the input string into an array of characters
                                    $characters = preg_split('//u', $input, null, PREG_SPLIT_NO_EMPTY);

                                    // Initialize an empty array to store encoded characters
                                    $encodedCharacters = [];

                                    // Iterate through each character in the input string
                                    foreach ($characters as $character) {
                                        // Get the Unicode code point of the character
                                        $codePoint = mb_ord($character);

                                        // If the character is an emoji (in the specified range)
                                        if ($codePoint >= 0x1F300 && $codePoint <= 0x1F6FF) {
                                            // Encode the character as a HTML entity
                                            $encodedCharacter = "&#x" . dechex($codePoint) . ";";
                                        } else {
                                            // If the character is not an emoji, keep it as it is
                                            $encodedCharacter = $character;
                                        }

                                        // Add the encoded character to the array
                                        $encodedCharacters[] = $encodedCharacter;
                                    }

                                    // Concatenate the encoded characters array into a string
                                    $encodedString = implode("", $encodedCharacters);

                                    // Return the encoded string
                                    return $encodedString;
                                }

                                $b_name = encodeEmojisToHtmlEntities($b_name);
                                $b_body = encodeEmojisToHtmlEntities($b_body);

                                // set new extention to image file
                                $new_img_extention;

                                if ($file_extention == "image/jpg") {
                                    $new_img_extention = ".jpg";
                                } else if ($file_extention == "image/jpeg") {
                                    $new_img_extention = ".jpeg";
                                } else if ($file_extention == "image/png") {
                                    $new_img_extention = ".png";
                                } else if ($file_extention == "image/svg+xml") {
                                    $new_img_extention = ".svg";
                                } else if ($file_extention == "image/webp") {
                                    $new_img_extention = ".webp";
                                }

                                $currentDateTime = date('Y-m-d H:i:s');

                                // image file store
                                $file_name = "assets-admin//images//blog//" . uniqid() . $new_img_extention;

                                if (move_uploaded_file($image_file["tmp_name"], $file_name)) {
                                    $stmt = Database::$connection->prepare("INSERT INTO blog(b_name,b_body,b_img,blog_date) VALUES (?, ?, ?, ?)");
                                    $stmt->bind_param("ssss", $b_name, $b_body, $file_name, $currentDateTime);
                                    if ($stmt->execute()) {
                                        echo "New Blog added Successfully.";
                                    } else {
                                        echo "Something went wrong! Please try again";
                                    }
                                    $stmt->close();
                                } else {
                                    echo "Something went wrong with image file! Please try again later.";
                                }
                                Database::$connection->close();

                            } else {
                                echo "Maximum image size is 5 MB";
                            }

                        } else {
                            echo "Unsupported image type.";
                        }

                    }

                } else {
                    echo "Something went wrong! Please try again later.";
                }

            } else {
                echo "Blog title or body cannot be empty!";
            }

        } else {
            echo "Please try again later!";
        }
        ;

    } else {
        echo "Invalid user!";
    }
    ;

} else {
    echo "Please log in first!";
}

?>