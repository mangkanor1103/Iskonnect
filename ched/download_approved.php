<?php
include '../components/session_check.php';

// Check if user is logged in and has staff role
redirect_if_not_authorized('ched');

include '../components/conn.php';

// Get filter and search parameters
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build the query based on the filter - only show approved students
$query = "SELECT * FROM students WHERE status = 'Approved'";

if ($filter == 'financial') {
    $query .= " AND scholarship_type = 'Financial Assistantship'";
} elseif ($filter == 'student') {
    $query .= " AND scholarship_type = 'Student Assistantship Program'";
}

// Add search functionality
if (!empty($search)) {
    $query .= " AND (last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR student_id LIKE '%$search%')";
}

// Execute query
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Set headers for Excel download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="approved_students_' . date('Y-m-d') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Output Excel content
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">';
echo '<Worksheet ss:Name="Approved Students">';
echo '<Table>';
echo '<Row>';
echo '<Cell><Data ss:Type="String">Student ID</Data></Cell>';
echo '<Cell><Data ss:Type="String">Last Name</Data></Cell>';
echo '<Cell><Data ss:Type="String">First Name</Data></Cell>';
echo '<Cell><Data ss:Type="String">Middle Name</Data></Cell>';
echo '<Cell><Data ss:Type="String">Email</Data></Cell>';
echo '<Cell><Data ss:Type="String">Contact Number</Data></Cell>';
echo '<Cell><Data ss:Type="String">Course/Year</Data></Cell>';
echo '<Cell><Data ss:Type="String">Scholarship Type</Data></Cell>';
echo '<Cell><Data ss:Type="String">Status</Data></Cell>';
echo '</Row>';

// Output data rows
while ($row = mysqli_fetch_assoc($result)) {
    echo '<Row>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['student_id']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['last_name']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['first_name']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['middle_name']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['email']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['contact_number'] ?? '') . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['course_yr']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['scholarship_type']) . '</Data></Cell>';
    echo '<Cell><Data ss:Type="String">' . htmlspecialchars($row['status']) . '</Data></Cell>';
    echo '</Row>';
}

echo '</Table>';
echo '</Worksheet>';
echo '</Workbook>';

// Close the database connection
mysqli_close($conn);
?>