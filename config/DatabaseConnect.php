<?php
$host = "localhost";
$database = "blogging";
$username = "root";
$password = "";

$dsn = "mysql: host=$host;dbname=$database;";
try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e){
    echo "Connection Failed: " . $e->getMessage();
}


?>