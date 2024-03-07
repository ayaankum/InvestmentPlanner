<?php
    function connect(){
        $dbHost= "localhost";
        $username= "root";
        $passwd= "";
        $dbName="investments";
        $port= 3307;

        $conn= $mysqli = new mysqli($dbHost, $username, $passwd, $dbName, $port); 
        //echo "connected";
        return $conn;
    }

    function closeConnect($cn){
        $cn->close();
    }
?>