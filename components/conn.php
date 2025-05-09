<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iskonnect";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert default admin credentials
$adminUsername = 'admin';
$adminPassword = password_hash('password', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT IGNORE INTO users (username, password, role) VALUES (?, ?, 'admin')");
$stmt->bind_param("ss", $adminUsername, $adminPassword);
$stmt->execute();
?>