<?php 
require "db.php";
$cname = $_GET["cname"];

// echo $cname;

if (empty($cname)) {
    echo "Please Enter Category Name";
}else{

Databases::iud("INSERT INTO `cook_type` (`cook_type_name`) VALUES ('".$cname."')");

echo "success";
}

?>