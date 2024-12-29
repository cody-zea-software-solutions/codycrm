<?php

class Databases{

    public static $connection;

    public static function setUpConnection(){
        if(!isset(Databases::$connection)){
           // Databases::$connection = new mysqli("localhost","root","denuwan123A","u426526638_coir","3306");
         Databases::$connection = new mysqli("localhost", "u426526638_booze", "denuwan123A", "u426526638_boozebites", "3306");
        }
    }

    public static function iud($q){
        Databases::setUpConnection();
        Databases::$connection->query($q);
    }

    public static function search($q){
        Databases::setUpConnection();
        $resultset = Databases::$connection->query($q);
        return $resultset;
    }

}


?>