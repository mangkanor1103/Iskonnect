<?php
// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

// Validate data
if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please provide valid name, email and message']);
    exit;
}

// Database connection
$host = 'localhost';
$dbname = 'iskonnect';  // Make sure this database exists
$username = 'root';     // Default XAMPP username
$password = '';         // Default XAMPP password (empty)

try {
    // Create database connection
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if database exists, if not create it
    $conn->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $conn->exec("USE `$dbname`");
    
    // Check if table exists, if not create it
    $conn->exec("
        CREATE TABLE IF NOT EXISTS `feedback` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `full_name` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `message` text NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
    
    // Insert data
    $stmt = $conn->prepare("INSERT INTO feedback (full_name, email, message, created_at) VALUES (?, ?, ?, NOW())");
    $result = $stmt->execute([$name, $email, $message]);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Thank you for your feedback! We will get back to you soon.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to save your message. Please try again.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'A database error occurred. Please try again later.']);
    
    // Log error (not displayed to user)
    error_log('Database Error: ' . $e->getMessage());
}
?>