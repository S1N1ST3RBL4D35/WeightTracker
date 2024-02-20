<?php
$serverName = "localhost";
$port = 3307;
$username = "root";
$password = "";
$dbName = "weight_tracker";

$conn = new mysqli($serverName . ':' . $port, $username, $password, $dbName);

if($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>