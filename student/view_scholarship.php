<?php 
include '../components/session_check.php';

// Check if user is logged in and has student role
redirect_if_not_authorized('student');

include '../components/conn.php';

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('No scholarship post selected.'); window.location.href='scholarship_posts.php';</script>";
    exit();
}

$post_id = mysqli_real_escape_string($conn, $_GET['id']);

// Get scholarship post details
$query = "SELECT p.*, u.username as poster_name 
          FROM scholarship_posts p 
          INNER JOIN users u ON p.posted_by = u.id 
          WHERE p.id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result || $result->num_rows == 0) {
    echo "<script>alert('Scholarship post not found.'); window.location.href='scholarship_posts.php';</script>";
    exit();
}

$post = $result->fetch_assoc();
?>

<?php include '../components/header.php'; ?>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
        <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
            <div class="flex items-center justify-center">
                <svg class="w-8 h-8 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zm9.3 2.108a1 1 0 00-1.842.746A11.091 11.091 0 0110 15.5c-2.28 0-4.402-.396-6-1.104v-4.3s.374.15 1.1.213c1.2.103 2.716-.204 4.446-.524 1.72-.316 3.437-.67 4.946-.689h.015c.67 0 1.323.065 1.894.213A8.935 8.935 0 0117 11.323a1 1 0 00-1-1h-.013l-1.38.268a.5.5 0 01-.638-.47v-.422a.5.5 0 01.314-.465l1.415-.598a1 1 0 00-.026-1.845l-3.246-1.262a.5.5 0 01-.28-.615c.09-.252.14-.4.159-.547A.5.5 0 0011.7 4.21l.33-.237a1 1 0 00.12-1.403l-.16-.219a1 1 0 00-1.413-.12l-1.489 1.085a.5.5 0 01-.635-.076l-.246-.313a.5.5 0 01-.092-.562L8.939.317a1 1 0 00-.363-1.118.942.942 0 00-.935-.018 1 1 0 00-.45.61l-.39 1.301a.5.5 0 01-.534.336l-.534-.074a.5.5 0 01-.432-.425l-.109-.664a1 1 0 00-1.237-.816l-.04.007a1 1 0 00-.776 1.105l.088.596a.5.5 0 01-.426.538l-.534.074a.5.5 0 01-.535-.337l-.39-1.3a1 1 0 00-1.748-.593l-.393.393a1 1 0 00-.12 1.235l.214.427a.5.5 0 01-.076.635l-.313.246a.5.5 0 01-.562.092l-.427-.214a1 1 0 00-1.235.12l-.393.393a1 1 0 00.474 1.676"></path>
                </svg>
                <h1 class="text-xl font-bold">Student Portal</h1>
            </div>
        </div>
        <nav class="flex-1">
            <ul class="space-y-1 p-3">
                <li class="group">
                    <a href="dashboard.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Dashboard</span>
                    </a>
                </li>
                <li class="group">
                    <a href="scholarship_posts.php" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Scholarship Posts</span>
                    </a>
                </li>
                <!-- More menu items will be added later -->
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
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700"><?php echo htmlspecialchars($username); ?></p>
                    <p class="text-xs text-gray-500">Student</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50">
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Scholarship Details</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Student</div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="scholarship_posts.php" class="text-gray-600 hover:text-green-700 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Scholarships
                </a>
                <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
            </div>
        </div>

        <!-- Scholarship Post Detail Content -->
        <div class="p-6">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 animate__animated animate__fadeIn">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-1"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <p class="text-sm text-gray-500">
                                Posted by: <?php echo htmlspecialchars($post['poster_name']); ?> • 
                                <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                            </p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <?php if (!empty($post['scholarship_type'])): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    <?php 
                                    switch ($post['scholarship_type']) {
                                        case 'Financial Assistantship':
                                            echo 'bg-blue-100 text-blue-800';
                                            break;
                                        case 'Student Assistantship Program':
                                            echo 'bg-purple-100 text-purple-800';
                                            break;
                                        case 'Both':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars($post['scholarship_type']); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (!empty($post['deadline'])): ?>
                                <?php 
                                    $deadline = strtotime($post['deadline']);
                                    $current_time = time();
                                    $is_expired = $current_time > $deadline;
                                ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    <?php echo $is_expired ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php if ($is_expired): ?>
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Expired on <?php echo date('F j, Y', $deadline); ?>
                                    <?php else: ?>
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Deadline: <?php echo date('F j, Y', $deadline); ?>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($post['deadline']) && $is_expired): ?>
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-bold">This scholarship opportunity has expired</p>
                                <p>The application deadline was <?php echo date('F j, Y', $deadline); ?>. Please check other available scholarships.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="prose max-w-none text-gray-700">
                        <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                    </div>
                    
                    <?php if (!empty($post['attachment'])): ?>
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center">
                                <svg class="w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <div class="ml-4 flex-1">
                                    <h4 class="text-lg font-medium text-gray-900">Scholarship Attachment</h4>
                                    <p class="text-sm text-gray-500 mb-2"><?php echo htmlspecialchars(substr($post['attachment'], strpos($post['attachment'], '_') + 1)); ?></p>
                                    <a href="../uploads/attachments/<?php echo htmlspecialchars($post['attachment']); ?>" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md shadow-sm font-medium hover:bg-green-700 transition-colors" target="_blank" download>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Application Information -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">How to Apply</h3>
                    <div class="prose max-w-none text-gray-700">
                        <p>To apply for this scholarship opportunity, please follow these steps:</p>
                        <ol class="list-decimal pl-5 mt-2">
                            <li class="mb-2">Ensure you meet all the eligibility requirements mentioned above.</li>
                            <li class="mb-2">Complete the application form available at the Scholarship Office.</li>
                            <li class="mb-2">Prepare all required documents as specified in the scholarship details.</li>
                            <li class="mb-2">Submit your complete application before the deadline.</li>
                            <li>Follow up with the Scholarship Office for any updates on your application.</li>
                        </ol>
                        <p class="mt-4">For more information, please visit the <strong>Office of Student Affairs</strong> or contact them at <strong>osa@mindorosu.edu.ph</strong>.</p>
                    </div>
                </div>
            </div>
            
            <!-- Related Links -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Additional Resources</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center text-green-600 hover:text-green-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Scholarship FAQ
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-green-600 hover:text-green-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Application Guidelines
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-green-600 hover:text-green-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Scholarship Calendar
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-green-600 hover:text-green-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contact Scholarship Office
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="bg-white p-6 border-t">
            <div class="text-center text-sm text-gray-500">
                <p>&copy; 2025 Iskonnect. All rights reserved.</p>
            </div>
        </footer>
    </div>
</div>

<?php include '../components/footer.php'; ?>
