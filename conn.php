<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM sales");
$stmt->execute();

$result = $stmt->get_result();
echo "<pre>";
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());
print_r($result->fetch_assoc());

echo "</pre>";
