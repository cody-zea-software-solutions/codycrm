<?php 

require "../connection.php";
session_start();


function convertToPercentage($value, $total) {
    if ($total == 0) {
        return 0; //  division by zero error
    }
    
    $percentage = ($value / $total) * 100;
    return $percentage;
}


if (isset($_SESSION["a"])) {
$qty = $_POST["qty"];
$discount  = $_POST["discount"];
$pid  = $_POST["product"];
$unit  = $_POST["unit"];

$version;


if (empty($qty) || empty($discount) || empty($pid) || empty($unit) ) {
    echo "All Details Required";
}else if (!is_numeric($discount)) {
    echo "Please Enter Valid Price";
} else{

  

    $formattedDiscount = number_format((float) $discount, 2, '.', '');

  if ($unit == 1) {
       $version = $formattedDiscount ; 
    }

    if ($unit == 2) {
        $version = convertToPercentage($formattedDiscount,100); 
    }


    $query = "INSERT INTO `discount` (`qty`,`discount_price`,`product_id`,`unit_id`) VALUES ('".$qty."','".$formattedDiscount."','".$pid."','".$unit."')";
    Database::iud($query);

    echo "success";
}



}else{
    echo "You Are Not A Admin";
    ?>
    <script>
        window.location.href = "authentication-login.php";
    </script>
    <?php
}



?>