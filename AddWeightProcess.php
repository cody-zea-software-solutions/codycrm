<?php 
require "db.php";
$cname = $_GET["cname"];

// echo $cname;

if (empty($cname)) {
    echo "Please Enter Meat Name";
}else{

Databases::iud("INSERT INTO `meat_type` (`meat_type_name`) VALUES ('".$cname."')");

echo "success";
}

?>