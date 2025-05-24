<?php 
include '../components/session_check.php';

// Check if user is logged in and has student role
redirect_if_not_authorized('student');

include '../components/conn.php';

$username = $_SESSION['username'];

// Get student information
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// You can add more queries here to fetch student-specific data
// For example, courses, grades, schedule, etc.
?>

<?php include '../components/header.php'; ?>

<!-- Add required libraries for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Improved Sidebar with subtle gradient -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
        <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
            <div class="flex items-center justify-center">
                <svg class="w-8 h-8 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zm9.3 2.108a1 1 0 00-1.842.746A11.091 11.091 0 0110 15.5c-2.28 0-4.402-.396-6-1.104v-4.3s.374.15 1.1.213c1.2.103 2.716-.204 4.446-.524 1.72-.316 3.437-.67 4.946-.689h.015c.67 0 1.323.065 1.894.213A8.935 8.935 0 0017 11.323a1 1 0 00-1-1h-.013l-1.38.268a.5.5 0 01-.638-.47v-.422a.5.5 0 01.314-.465l1.415-.598a1 1 0 00-.026-1.845l-3.246-1.262a.5.5 0 01-.28-.615c.09-.252.14-.4.159-.547A.5.5 0 0011.7 4.21l.33-.237a1 1 0 00.12-1.403l-.16-.219a1 1 0 00-1.413-.12l-1.489 1.085a.5.5 0 01-.635-.076l-.246-.313a.5.5 0 01-.092-.562L8.939.317a1 1 0 00-.363-1.118.942.942 0 00-.935-.018 1 1 0 00-.45.61l-.39 1.301a.5.5 0 01-.534.336l-.534-.074a.5.5 0 01-.432-.425l-.109-.664a1 1 0 00-1.237-.816l-.04.007a1 1 0 00-.776 1.105l.088.596a.5.5 0 01-.426.538l-.534.074a.5.5 0 01-.535-.337l-.39-1.3a1 1 0 00-1.748-.593l-.393.393a1 1 0 00-.12 1.235l.214.427a.5.5 0 01-.076.635l-.313.246a.5.5 0 01-.562.092l-.427-.214a1 1 0 00-1.235.12l-.393.393a1 1 0 00.474 1.676"></path>
                </svg>
                <h1 class="text-xl font-bold">Student Portal</h1>
            </div>
        </div>
        <nav class="flex-1">
            <ul class="space-y-1 p-3">
                <li class="group">
                    <a href="#" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Dashboard</span>
                    </a>
                </li>
                <li class="group">
                    <a href="scholarship_posts.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
    </div>        <!-- Main content -->
        <div class="main-content flex-1 overflow-y-auto">
            <!-- Dashboard content -->
            <div class="p-6">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome, <?= htmlspecialchars($username) ?>!</h2>
                    <p class="text-gray-600">Here's your scholarship overview.</p>
                </div>
                
                <!-- Scholarship Alert Section -->
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg shadow-md p-6">
                        <div class="flex items-start">
                            <div class="hidden sm:flex items-center justify-center h-12 w-12 rounded-full bg-white bg-opacity-20 mr-4">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">New Scholarship Opportunities!</h3>
                                <p class="mt-1 text-white text-opacity-90">Check out the latest scholarship posts from our staff.</p>
                                <a href="scholarship_posts.php" class="mt-3 inline-flex items-center px-4 py-2 bg-white text-green-700 rounded-md shadow-sm font-medium hover:bg-green-50 transition-colors">
                                    View Scholarships
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Available Scholarships Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-full p-3 mr-4">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Available Scholarships</p>
                                <?php
                                // Count total available scholarships
                                $availableQuery = $conn->query("SELECT COUNT(*) as total FROM scholarship_posts");
                                $availableCount = $availableQuery->fetch_assoc()['total'];
                                ?>
                                <h3 class="text-2xl font-bold text-gray-800"><?= $availableCount ?></h3>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Upcoming Deadlines Card -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="bg-yellow-100 rounded-full p-3 mr-4">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm">Upcoming Deadlines</p>
                                <?php
                                // Count scholarships with deadlines in the next 7 days
                                $currentDate = date('Y-m-d');
                                $nextWeek = date('Y-m-d', strtotime('+7 days'));
                                $upcomingQuery = $conn->prepare("SELECT COUNT(*) as total FROM scholarship_posts WHERE deadline BETWEEN ? AND ?");
                                $upcomingQuery->bind_param("ss", $currentDate, $nextWeek);
                                $upcomingQuery->execute();
                                $upcomingCount = $upcomingQuery->get_result()->fetch_assoc()['total'];
                                ?>
                                <h3 class="text-2xl font-bold text-gray-800"><?= $upcomingCount ?></h3>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
            
            <!-- Recent Scholarship Posts Section -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Recent Scholarship Posts</h3>
                    </div>
                    
                    <?php
                    // Fetch recent scholarship posts
                    $stmt = $conn->prepare("SELECT id, title, scholarship_type, deadline FROM scholarship_posts ORDER BY created_at DESC LIMIT 3");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<div class="space-y-4">';
                        while($row = $result->fetch_assoc()) {
                            // Calculate days remaining until deadline
                            $deadline = new DateTime($row['deadline']);
                            $today = new DateTime();
                            $days_remaining = $today->diff($deadline)->days;
                            
                            // Determine urgency class based on days remaining
                            $urgency_class = '';
                            if ($days_remaining <= 3) {
                                $urgency_class = 'bg-red-50 border-red-200 text-red-700';
                            } else if ($days_remaining <= 7) {
                                $urgency_class = 'bg-yellow-50 border-yellow-200 text-yellow-700';
                            } else {
                                $urgency_class = 'bg-green-50 border-green-200 text-green-700';
                            }
                            
                            echo '
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-gray-800">'.htmlspecialchars($row['title']).'</h4>
                                    <span class="px-2 py-1 rounded text-xs '.$urgency_class.'">
                                        '.$days_remaining.' days left
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Type: '.htmlspecialchars($row['scholarship_type']).'</p>
                            </div>
                            ';
                        }
                        echo '</div>';
                    } else {
                        echo '<p class="text-gray-500">No scholarship posts available at the moment.</p>';
                    }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    if (sidebar.classList.contains('-translate-x-full')) {
                        sidebar.classList.remove('-translate-x-full');
                    } else {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            }
              // Initialize scholarship distribution chart
            const ctx = document.getElementById('scholarshipChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Financial Assistantship', 'Student Assistantship', 'Merit-Based', 'External'],
                    datasets: [{
                        data: [5, 3, 2, 1],
                        backgroundColor: [
                            '#3B82F6', // Blue for Financial
                            '#10B981', // Green for Student Assistantship
                            '#8B5CF6', // Purple for Merit-Based
                            '#F59E0B'  // Yellow for External
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>