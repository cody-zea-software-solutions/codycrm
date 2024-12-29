<?php

include "db.php";

class ProductDeletion
{
     public static function deleteProduct($productId)
     {
          if (!isset($productId)) {
               return "Product id is missing.";
          }
          $product = Databases::search("SELECT * FROM `products` WHERE `product_id`='" . $productId . "' ");
          $productCount = $product->num_rows;
          if ($productCount != 1) {
               return "Product not found.";
          }
          $updateQuery = "UPDATE products SET on_delete = 1 WHERE product_id = $productId";
          Databases::iud($updateQuery);
          return "Product deleted successfully.";
     }
}

session_start();
if (isset($_SESSION["a"])) {
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (isset($_POST["productid"])) {
               echo ProductDeletion::deleteProduct($_POST["productid"]);
          } else {
               echo "Product id is missing.";
          }
     } else {
          echo "Invalid request method.";
     }
}
