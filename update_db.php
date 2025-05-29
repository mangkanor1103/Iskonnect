<?php
// This script adds the how_to_apply column to the scholarship_posts table if it doesn't exist

// Include database connection
include 'components/conn.php';

// Check if the column exists
$check_query = "SHOW COLUMNS FROM scholarship_posts LIKE 'how_to_apply'";
$result = $conn->query($check_query);

if ($result->num_rows == 0) {
    // Column does not exist, so add it
    $sql = "ALTER TABLE scholarship_posts ADD COLUMN how_to_apply TEXT AFTER content";
    
    if ($conn->query($sql) === TRUE) {
        echo "Database updated successfully: 'how_to_apply' column added to scholarship_posts table.";
    } else {
        echo "Error updating database: " . $conn->error;
    }
} else {
    echo "Column 'how_to_apply' already exists in scholarship_posts table.";
}

// Close connection
$conn->close();
?>
