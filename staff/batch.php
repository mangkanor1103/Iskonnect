<?php
include '../components/session_check.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('staff');

include '../components/conn.php';

$username = $_SESSION['username'];

// Process Batch Action
$message = '';
$messageType = '';

if (isset($_POST['process_batch'])) {
    $selected_ids = isset($_POST['selected_students']) ? $_POST['selected_students'] : [];
    $batch_number = isset($_POST['batch_number']) ? $_POST['batch_number'] : '';
    
    if (empty($selected_ids)) {
        $message = "Please select at least one student to process";
        $messageType = "error";
    } elseif (empty($batch_number)) {
        $message = "Please enter a batch number";
        $messageType = "error";
    } else {
        // Update the selected students with batch number
        $batch_date = date('Y-m-d');
        
        $success = true;
        foreach ($selected_ids as $student_id) {
            $student_id = mysqli_real_escape_string($conn, $student_id);
            $query = "UPDATE students SET batch_number = '$batch_number', batch_date = '$batch_date', 
                     processed_by = '$username' WHERE id = '$student_id'";
            
            if (!mysqli_query($conn, $query)) {
                $success = false;
                $message = "Error processing batch: " . mysqli_error($conn);
                $messageType = "error";
                break;
            }
        }
        
        if ($success) {
            $message = "Successfully processed " . count($selected_ids) . " students in batch #" . $batch_number;
            $messageType = "success";
            
            // Redirect to print page on success
            header("Location: print_batch.php?batch=" . urlencode($batch_number));
            exit;
        }
    }
}

// Get all approved students that are NOT already in a batch
$query = "SELECT * FROM students WHERE status = 'Approved' AND (batch_number IS NULL OR batch_number = '') ORDER BY last_name ASC";
$result = mysqli_query($conn, $query);

// Generate a suggested batch number (current date + sequential number)
$today = date('Ymd');

// Default suggested batch in case of error
$suggested_batch = $today . "01";

try {
    // Check if the batch_number column exists
    $check_column = mysqli_query($conn, "SHOW COLUMNS FROM students LIKE 'batch_number'");
    
    if (mysqli_num_rows($check_column) > 0) {
        $batch_query = "SELECT MAX(batch_number) as max_batch FROM students WHERE batch_number LIKE '$today%'";
        $batch_result = mysqli_query($conn, $batch_query);
        
        if ($batch_result) {
            $batch_row = mysqli_fetch_assoc($batch_result);
            
            $next_sequence = 1;
            if (!empty($batch_row['max_batch'])) {
                // Extract the sequence number from the last batch
                $last_sequence = substr($batch_row['max_batch'], -2);
                if (is_numeric($last_sequence)) {
                    $next_sequence = intval($last_sequence) + 1;
                }
            }
            
            $suggested_batch = $today . sprintf("%02d", $next_sequence);
        }
    } else {
        // Add the required columns if they don't exist
        $add_columns_query = "ALTER TABLE students 
                             ADD COLUMN batch_number VARCHAR(50) DEFAULT NULL,
                             ADD COLUMN batch_date DATE DEFAULT NULL,
                             ADD COLUMN processed_by VARCHAR(100) DEFAULT NULL";
        mysqli_query($conn, $add_columns_query);
        
        $message = "Required database columns were added. Please refresh the page.";
        $messageType = "success";
    }
} catch (Exception $e) {
    $message = "Error checking batch number: " . $e->getMessage();
    $messageType = "error";
}
?>

<?php include '../components/header.php'; ?>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Sidebar - Reuse the same sidebar from approved.php -->    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
        <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
            <div class="flex items-center justify-center">
                <svg class="w-8 h-8 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
                <h1 class="text-xl font-bold">Staff Portal</h1>
            </div>
        </div>
        <nav class="flex-1">
            <ul class="space-y-1 p-3">
                <li class="group">
                    <a href="dashboard.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Home</span>
                    </a>
                </li>
                <li class="group">
                    <a href="students.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Pending Students</span>
                    </a>
                </li>
                <li class="group">
                    <a href="approved.php" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Approved Students</span>
                    </a>
                </li>                <li class="group">
                    <a href="reject.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-red-500 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-red-700 font-medium">Rejected Students</span>
                    </a>
                </li>
                <li class="group">
                    <a href="create_post.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Create Scholarship Post</span>
                    </a>
                </li>
                <li class="border-t border-gray-100 my-2 pt-2"></li>
                <li class="group">
                    <a href="../logout.php" class="flex items-center p-3 rounded-lg hover:bg-red-50 transition-all duration-300">
                        <svg class="w-5 h-5 text-red-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-red-700 font-medium">Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold">
                    <?php echo strtoupper(substr($username, 0, 1)); ?>
                </div>                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700"><?php echo $username; ?></p>
                    <p class="text-xs text-gray-500">Staff</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50 relative">
        <div id="particles-js" class="absolute inset-0 opacity-30"></div>
        
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Batch Processing</h2>
                <div class="ml-4 bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Print</div>
            </div>
            <div class="flex items-center space-x-4">
                <div>
                    <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Batch Processing Section -->
        <div class="p-6 animate__animated animate__fadeIn">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Batch Processing for Approved Students</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Create a batch for approved students and generate batch prints
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="approved.php" class="px-4 py-2 border border-gray-300 bg-white text-sm font-medium rounded-md text-gray-700 hover:bg-gray-50 transition">
                                Back to Approved List
                            </a>
                        </div>
                    </div>

                    <?php if (!empty($message)): ?>
                    <div class="mb-6 p-4 rounded-md <?php echo $messageType == 'success' ? 'bg-green-50 text-green-800 border-green-300' : 'bg-red-50 text-red-800 border-red-300'; ?> border">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <?php if ($messageType == 'success'): ?>
                                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php else: ?>
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php endif; ?>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm"><?php echo $message; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <form action="" method="post" id="batchForm">
                        <div class="mb-6">
                            <label for="batch_number" class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                            <div class="flex rounded-md shadow-sm">
                                <input type="text" name="batch_number" id="batch_number" 
                                       value="<?php echo $suggested_batch; ?>"
                                       class="flex-1 block w-full rounded-md sm:text-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Enter batch number">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">A suggested batch number based on today's date is provided. You can modify if needed.</p>
                        </div>

                        <!-- Select All Option -->
                        <div class="mb-4 flex items-center">
                            <input type="checkbox" id="select_all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-offset-0 focus:ring-blue-200 focus:ring-opacity-50">
                            <label for="select_all" class="ml-2 text-sm font-medium text-gray-700">Select All Students</label>
                        </div>
                        
                        <!-- Students List -->
                        <?php if (mysqli_num_rows($result) == 0): ?>
                            <div class="text-center py-10">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No approved students found</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    There are no approved students to process at this time.
                                </p>
                            </div>
                        <?php else: ?>
                            <div class="overflow-x-auto border border-gray-200 rounded-md">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course / Year</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scholarship Type</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="checkbox" name="selected_students[]" value="<?php echo $row['id']; ?>" 
                                                           class="student-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-offset-0 focus:ring-blue-200 focus:ring-opacity-50">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <?php if (!empty($row['photo'])): ?>
                                                                <img class="h-10 w-10 rounded-full object-cover" src="<?php echo htmlspecialchars('../uploads/' . $row['photo']); ?>" alt="">
                                                            <?php else: ?>
                                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                                    <span class="text-green-800 font-medium text-sm">
                                                                        <?php echo strtoupper(substr($row['first_name'], 0, 1) . substr($row['last_name'], 0, 1)); ?>
                                                                    </span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                <?php echo htmlspecialchars($row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name']); ?>
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                <?php echo htmlspecialchars($row['email']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($row['student_id']); ?></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($row['course_yr']); ?></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <?php if ($row['scholarship_type'] == 'Financial Assistantship'): ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Financial
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                            Student Assistantship
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center justify-end space-x-4">
                                <button type="submit" name="process_batch" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Process and Print Batch
                                </button>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Processed Batches Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recently Processed Batches</h3>
                    
                    <?php
                    $recent_batches_query = "SELECT 
                                              batch_number, 
                                              batch_date, 
                                              processed_by,
                                              COUNT(*) as student_count
                                             FROM students 
                                             WHERE batch_number IS NOT NULL 
                                             GROUP BY batch_number 
                                             ORDER BY batch_date DESC
                                             LIMIT 5";
                    $recent_batches = mysqli_query($conn, $recent_batches_query);
                    
                    if (mysqli_num_rows($recent_batches) == 0): ?>
                        <p class="text-sm text-gray-500">No batches have been processed yet.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Number</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Processed By</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Count</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php while ($batch = mysqli_fetch_assoc($recent_batches)): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($batch['batch_number']); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo date('F j, Y', strtotime($batch['batch_date'])); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($batch['processed_by']); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900"><?php echo $batch['student_count']; ?> students</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="print_batch.php?batch=<?php echo $batch['batch_number']; ?>" 
                                                   class="text-blue-600 hover:text-blue-900 mr-4">
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                        </svg>
                                                        Print Again
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for handling select all functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select_all');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    
    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }
    
    // Update select all status based on individual checkboxes
    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(studentCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = !allChecked && someChecked;
            }
        });
    });
    
    // Form validation before submit
    const batchForm = document.getElementById('batchForm');
    if (batchForm) {
        batchForm.addEventListener('submit', function(e) {
            const selectedStudents = document.querySelectorAll('.student-checkbox:checked');
            const batchNumber = document.getElementById('batch_number').value.trim();
            
            if (selectedStudents.length === 0) {
                e.preventDefault();
                alert('Please select at least one student to process.');
                return false;
            }
            
            if (!batchNumber) {
                e.preventDefault();
                alert('Please enter a batch number.');
                return false;
            }
            
            return true;
        });
    }
});
</script>

<!-- Initialize particles.js effect -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof particlesJS !== 'undefined') {
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#4ade80"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                },
                "opacity": {
                    "value": 0.3,
                    "random": false
                },
                "size": {
                    "value": 3,
                    "random": true
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#4ade80",
                    "opacity": 0.2,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
    }
});
</script>

<?php include '../components/footer.php'; ?>