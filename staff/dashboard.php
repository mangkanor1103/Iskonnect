<?php 
include '../components/session_check.php';

// Check if user is logged in and has staff role
redirect_if_not_authorized('staff');

include '../components/conn.php';

$username = $_SESSION['username'];
?>

<?php include '../components/header.php'; ?>

<!-- Add required libraries for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Improved Sidebar with subtle gradient -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
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
                    <a href="#" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                    <a href="approved.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Approved Students</span>
                    </a>
                </li>
                <li class="group">
                    <a href="reject.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-red-500 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-red-700 font-medium">Rejected Students</span>
                    </a>
                </li>                <li class="group">
                    <a href="create_post.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Create Scholarship Post</span>
                    </a>
                </li>
                <li class="group">
                    <a href="qr_code.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-2 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">QR Code</span>
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
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700"><?php echo $username; ?></p>
                    <p class="text-xs text-gray-500">Staff Member</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Main Content -->
    <div class="flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50 relative">
        <div id="particles-js" class="absolute inset-0 opacity-30"></div>
        
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Staff Dashboard</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Staff</div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 focus:outline-none transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>
                <div>
                    <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Welcome Section -->
        <div class="p-6 animate__animated animate__fadeIn">            
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-2/3 p-8">
                        <div class="uppercase tracking-wide text-sm text-green-500 font-semibold">Staff Dashboard</div>
                        <h1 class="mt-2 text-4xl font-bold text-gray-800 leading-tight">Welcome, <?php echo $username; ?>!</h1>
                        <p class="mt-4 text-gray-600 leading-relaxed">
                            You have successfully logged in to your staff portal.
                        </p>
                    </div>
                    <div class="md:w-1/3 p-8 bg-blue-50 border-l border-blue-100">
                        <div class="uppercase tracking-wide text-sm text-blue-500 font-semibold">Quick Access</div>
                        <h2 class="mt-2 text-2xl font-bold text-gray-800 leading-tight">Contact CHED</h2>
                        <p class="mt-4 text-gray-600 leading-relaxed">
                            Need assistance with scholarship inquiries? Contact CHED directly.
                        </p>
                        <div class="mt-6">
                            <a href="mailto:info@ched.gov.ph?subject=Inquiry%20from%20Iskonnect%20Staff&body=Hello%20CHED,%0A%0AI%20am%20reaching%20out%20regarding%20a%20scholarship%20inquiry.%0A%0ARegards,%0A<?php echo urlencode($username); ?>" 
                               class="inline-flex items-center px-4 py-2 border border-green-300 rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contact CHED
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <?php
                // Get counts for the current staff user
                $staffId = $_SESSION['user_id'];
                
                // Initialize counts
                $pendingCount = 0;
                $approvedCount = 0;
                $rejectedCount = 0;
                $postsCount = 0;
                
                // Check if the tables exist before attempting queries
                $tables = [];
                $tablesQuery = $conn->query("SHOW TABLES");
                while($table = $tablesQuery->fetch_array()) {
                    $tables[] = $table[0];
                }
                
                // Count pending students if table exists
                if (in_array('students', $tables)) {
                    try {
                        $pendingQuery = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE status = 'pending'");
                        $pendingQuery->execute();
                        $pendingResult = $pendingQuery->get_result();
                        $pendingCount = $pendingResult->fetch_assoc()['count'];
                    } catch (Exception $e) {
                        // Silently handle the error
                    }
                    
                    // Count approved students
                    try {
                        $approvedQuery = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE status = 'approved'");
                        $approvedQuery->execute();
                        $approvedResult = $approvedQuery->get_result();
                        $approvedCount = $approvedResult->fetch_assoc()['count'];
                    } catch (Exception $e) {
                        // Silently handle the error
                    }
                    
                    // Count rejected students
                    try {
                        $rejectedQuery = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE status = 'rejected'");
                        $rejectedQuery->execute();
                        $rejectedResult = $rejectedQuery->get_result();
                        $rejectedCount = $rejectedResult->fetch_assoc()['count'];
                    } catch (Exception $e) {
                        // Silently handle the error
                    }
                }
                
                // Count all scholarship posts if table exists
                if (in_array('scholarship_posts', $tables)) {
                    try {
                        $postsQuery = $conn->prepare("SELECT COUNT(*) as count FROM scholarship_posts");
                        $postsQuery->execute();
                        $postsResult = $postsQuery->get_result();
                        $postsCount = $postsResult->fetch_assoc()['count'];
                    } catch (Exception $e) {
                        // Silently handle the error
                    }
                }
                ?>
                
                <!-- Pending Students -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Students</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $pendingCount; ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 px-4 py-2">
                        <a href="students.php" class="text-sm text-yellow-600 hover:text-yellow-900 font-medium">View all</a>
                    </div>
                </div>
                
                <!-- Approved Students -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Approved Students</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $approvedCount; ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-50 px-4 py-2">
                        <a href="approved.php" class="text-sm text-green-600 hover:text-green-900 font-medium">View all</a>
                    </div>
                </div>
                
                <!-- Rejected Students -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Rejected Students</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $rejectedCount; ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-red-50 px-4 py-2">
                        <a href="reject.php" class="text-sm text-red-600 hover:text-red-900 font-medium">View all</a>
                    </div>
                </div>
                
                <!-- Scholarship Posts -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Scholarship Posts</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $postsCount; ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-4 py-2">
                        <a href="create_post.php" class="text-sm text-blue-600 hover:text-blue-900 font-medium">Create new</a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities Section -->
            <div class="mt-6">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activities</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php
                        // Get recent student application activities
                        $recentActivities = array();
                        
                        // Check if students table exists
                        if (in_array('students', $tables)) {
                            try {
                                // Get 3 most recently updated student applications
                                $activityQuery = $conn->prepare("SELECT id, fullname, status, updated_at FROM students ORDER BY updated_at DESC LIMIT 3");
                                $activityQuery->execute();
                                $activityResult = $activityQuery->get_result();
                                
                                while ($activity = $activityResult->fetch_assoc()) {
                                    $status = ucfirst($activity['status']);
                                    $activityType = "Student Application";
                                    $description = "Student: " . htmlspecialchars($activity['fullname']);
                                    $recentActivities[] = array(
                                        'type' => $activityType,
                                        'status' => $status,
                                        'description' => $description,
                                        'time' => $activity['updated_at']
                                    );
                                }
                            } catch (Exception $e) {
                                // Silently handle the error
                            }
                        }
                        
                        // Check if scholarship_posts table exists
                        if (in_array('scholarship_posts', $tables)) {
                            try {
                                // Get 2 most recently created scholarship posts
                                $postsQuery = $conn->prepare("SELECT id, title, created_at FROM scholarship_posts ORDER BY created_at DESC LIMIT 2");
                                $postsQuery->execute();
                                $postsResult = $postsQuery->get_result();
                                
                                while ($post = $postsResult->fetch_assoc()) {
                                    $recentActivities[] = array(
                                        'type' => "Scholarship Post",
                                        'status' => "Created",
                                        'description' => "Title: " . htmlspecialchars($post['title']),
                                        'time' => $post['created_at']
                                    );
                                }
                            } catch (Exception $e) {
                                // Silently handle the error
                            }
                        }
                        
                        // Sort activities by time (most recent first)
                        usort($recentActivities, function($a, $b) {
                            return strtotime($b['time']) - strtotime($a['time']);
                        });
                        
                        // Display activities or a message if none found
                        if (count($recentActivities) > 0) {
                            foreach (array_slice($recentActivities, 0, 3) as $activity) {
                                $statusClass = "text-blue-600";
                                $bgClass = "bg-blue-100";
                                
                                if ($activity['status'] == 'Approved') {
                                    $statusClass = "text-green-600";
                                    $bgClass = "bg-green-100";
                                } else if ($activity['status'] == 'Rejected') {
                                    $statusClass = "text-red-600";
                                    $bgClass = "bg-red-100";
                                } else if ($activity['status'] == 'Pending') {
                                    $statusClass = "text-yellow-600";
                                    $bgClass = "bg-yellow-100";
                                }
                                
                                $formattedTime = date("M j, g:i A", strtotime($activity['time']));
                                ?>
                                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium <?php echo $statusClass; ?> truncate">
                                                <?php echo $activity['type']; ?> - <span class="<?php echo $bgClass; ?> px-2 py-0.5 rounded-full text-xs"><?php echo $activity['status']; ?></span>
                                            </p>
                                            <p class="text-sm text-gray-500"><?php echo $activity['description']; ?></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <p class="text-sm text-gray-500"><?php echo $formattedTime; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="px-4 py-4 sm:px-6 text-center text-gray-500">
                                No recent activities found.
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Initialize particles.js effect -->
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<?php include '../components/footer.php'; ?>