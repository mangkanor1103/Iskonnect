<?php
include '../components/session_check.php';
include '../components/conn.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('ched');

// Array of columns to add
$columns = [
    "batch_number" => "VARCHAR(20) DEFAULT NULL",
    "batch_date" => "DATE DEFAULT NULL",
    "processed_by" => "VARCHAR(50) DEFAULT NULL"
];

$success = true;
$messages = [];

// Check if columns already exist
$result = mysqli_query($conn, "SHOW COLUMNS FROM students");
$existing_columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $existing_columns[] = $row['Field'];
}

// Add missing columns
foreach ($columns as $column => $definition) {
    if (!in_array($column, $existing_columns)) {
        $query = "ALTER TABLE students ADD COLUMN $column $definition";
        if (mysqli_query($conn, $query)) {
            $messages[] = "Added column '$column' successfully";
        } else {
            $success = false;
            $messages[] = "Error adding column '$column': " . mysqli_error($conn);
        }
    } else {
        $messages[] = "Column '$column' already exists";
    }
}

// Output results
echo "<h1>Database Update Results</h1>";
foreach ($messages as $message) {
    echo "<p>" . htmlspecialchars($message) . "</p>";
}

if ($success) {
    echo "<p>All required columns have been added successfully.</p>";
    echo "<p><a href='batch.php'>Return to Batch Processing</a></p>";
} else {
    echo "<p>Some errors occurred while updating the database structure.</p>";
}
?>