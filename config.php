<?php
// config.php
$host = "localhost";
$username = "root";
$password = "";
$database = "taj_restaurant";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
