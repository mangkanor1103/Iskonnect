<?php
// filepath: c:\xampp\htdocs\Iskonnect\ched\print_batch.php

include '../components/session_check.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('staff');

include '../components/conn.php';

$username = $_SESSION['username'];

// Get batch number from URL
$batch_number = isset($_GET['batch']) ? $_GET['batch'] : '';

if (empty($batch_number)) {
    header('Location: batch.php');
    exit;
}

// Get batch information
$batch_query = "SELECT * FROM students WHERE batch_number = '" . mysqli_real_escape_string($conn, $batch_number) . "' ORDER BY last_name, first_name";
$batch_result = mysqli_query($conn, $batch_query);

// Check if batch exists
if (mysqli_num_rows($batch_result) == 0) {
    header('Location: batch.php?error=batch_not_found');
    exit;
}

// Get batch summary
$summary_query = "SELECT 
                   batch_date, 
                   processed_by,
                   COUNT(*) as student_count,
                   SUM(CASE WHEN scholarship_type = 'Financial Assistantship' THEN 1 ELSE 0 END) as financial_count,
                   SUM(CASE WHEN scholarship_type = 'Student Assistantship Program' THEN 1 ELSE 0 END) as sap_count
                  FROM students 
                  WHERE batch_number = '" . mysqli_real_escape_string($conn, $batch_number) . "'
                  GROUP BY batch_number, batch_date, processed_by";
$summary_result = mysqli_query($conn, $summary_query);
$summary = mysqli_fetch_assoc($summary_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Batch #<?php echo htmlspecialchars($batch_number); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .print-hidden {
                display: none !important;
            }
            body {
                font-size: 12pt;
            }
            @page {
                size: portrait;
                margin: 0.5in;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-8 shadow-md">
        <!-- Print Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">COMMISSION ON HIGHER EDUCATION</h1>
            <h2 class="text-xl text-gray-800">Approved Scholarship Batch #<?php echo htmlspecialchars($batch_number); ?></h2>
            <div class="text-sm text-gray-600 mt-2">
                <div>Date Processed: <?php echo date('F j, Y', strtotime($summary['batch_date'])); ?></div>
                <div>Processed By: <?php echo htmlspecialchars($summary['processed_by']); ?></div>
            </div>
        </div>
        
        <!-- Batch Summary -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Batch Summary</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <span class="text-sm text-gray-600">Total Students:</span>
                    <span class="text-lg font-medium text-gray-900 block"><?php echo $summary['student_count']; ?></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Financial Assistantship:</span>
                    <span class="text-lg font-medium text-gray-900 block"><?php echo $summary['financial_count']; ?></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Student Assistantship:</span>
                    <span class="text-lg font-medium text-gray-900 block"><?php echo $summary['sap_count']; ?></span>
                </div>
            </div>
        </div>
        
        <!-- Students List -->
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700">#</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700">Student Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700">Student ID</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700">Course</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left text-sm font-medium text-gray-700">Scholarship Type</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                mysqli_data_seek($batch_result, 0);
                $counter = 1;
                while ($student = mysqli_fetch_assoc($batch_result)): 
                ?>
                    <tr class="<?php echo $counter % 2 === 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                        <td class="py-2 px-4 border-b border-gray-300 text-sm"><?php echo $counter++; ?></td>
                        <td class="py-2 px-4 border-b border-gray-300 text-sm"><?php echo htmlspecialchars($student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name']); ?></td>
                        <td class="py-2 px-4 border-b border-gray-300 text-sm"><?php echo htmlspecialchars($student['student_id']); ?></td>
                        <td class="py-2 px-4 border-b border-gray-300 text-sm"><?php echo htmlspecialchars($student['course_yr']); ?></td>
                        <td class="py-2 px-4 border-b border-gray-300 text-sm">
                            <?php echo htmlspecialchars($student['scholarship_type']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <!-- Signature Section -->
        <div class="mt-12 grid grid-cols-2 gap-8">
            <div class="text-center">
                <div class="mb-8 border-b border-gray-400 pb-1"></div>
                <p class="font-medium">Prepared By</p>
            </div>
            <div class="text-center">
                <div class="mb-8 border-b border-gray-400 pb-1"></div>
                <p class="font-medium">Approved By</p>
            </div>
        </div>
        
        <!-- Print Controls - only visible on screen, not when printing -->
        <div class="mt-8 print-hidden flex justify-center space-x-4">
            <button onclick="window.print();" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Print Now
            </button>
            <a href="batch.php" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                Back to Batch Management
            </a>
        </div>
    </div>

    <script>
    // Auto-print when page loads
    window.onload = function() {
        // Small delay to ensure page is fully loaded
        setTimeout(function() {
            window.print();
        }, 1000);
    };
    </script>
</body>
</html>