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
    </div>

        <!-- Main content -->
        <div class="main-content flex-1 overflow-y-auto">
            <!-- Dashboard content -->
            <div class="p-6">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome, <?= htmlspecialchars($username) ?>!</h2>
                    <p class="text-gray-600">Here's your academic overview for this semester.</p>
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
                
                <!-- Important Announcements -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Important Announcements</h3>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            <div class="p-5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-base font-medium text-gray-900">Midterm Examination Schedule Released</h4>
                                        <p class="mt-1 text-sm text-gray-500">The midterm examination schedule for Spring 2025 has been released. Please check your student portal for details.</p>
                                        <p class="mt-2 text-xs text-gray-400">May 22, 2025</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-base font-medium text-gray-900">University Foundation Day Activities</h4>
                                        <p class="mt-1 text-sm text-gray-500">Join us for the University Foundation Day celebrations on June 5, 2025. Various activities will be held across campus.</p>
                                        <p class="mt-2 text-xs text-gray-400">May 18, 2025</p>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-base font-medium text-gray-900">Course Registration for Summer 2025</h4>
                                        <p class="mt-1 text-sm text-gray-500">Course registration for Summer 2025 begins on June 1. Please ensure all outstanding balances are settled before registration.</p>
                                        <p class="mt-2 text-xs text-gray-400">May 15, 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3">
                            <a href="#" class="text-sm font-medium text-green-600 hover:text-green-700">View all announcements</a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="card bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Available Scholarships</h3>
                                <p class="text-2xl font-semibold">8</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Applied Scholarships</h3>
                                <p class="text-2xl font-semibold">2</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center">
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Upcoming Deadlines</h3>
                                <p class="text-2xl font-semibold">3</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Active Awards</h3>
                                <p class="text-2xl font-semibold">1</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Dashboard Widgets -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Upcoming Scholarship Deadlines -->
                    <div class="card bg-white rounded-lg shadow col-span-1">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Deadlines</h3>
                            <div class="divide-y">
                                <div class="py-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-gray-800">Financial Assistantship</p>
                                            <p class="text-sm text-gray-500">University Merit Scholarship</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-red-500 text-sm">Due Tomorrow</p>
                                            <p class="text-xs text-gray-400">11:59 PM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-gray-800">Student Assistantship Program</p>
                                            <p class="text-sm text-gray-500">Library Assistant Position</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-orange-500 text-sm">May 28, 2025</p>
                                            <p class="text-xs text-gray-400">5:00 PM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-gray-800">External Scholarship</p>
                                            <p class="text-sm text-gray-500">Community Foundation Grant</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-gray-500 text-sm">June 5, 2025</p>
                                            <p class="text-xs text-gray-400">11:59 PM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="scholarship_posts.php" class="block text-center text-sm text-green-600 hover:underline mt-4">View All Scholarships</a>
                        </div>
                    </div>
                    
                    <!-- Application Status -->
                    <div class="card bg-white rounded-lg shadow col-span-1">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">My Applications</h3>
                            <div class="space-y-4">
                                <div class="border border-gray-200 rounded-md p-3">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">Academic Excellence Grant</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Financial Assistantship</p>
                                    <p class="text-xs text-gray-500 mt-1">Applied: March 15, 2025</p>
                                </div>
                                <div class="border border-gray-200 rounded-md p-3">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">Research Assistant Position</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Student Assistantship Program</p>
                                    <p class="text-xs text-gray-500 mt-1">Applied: May 10, 2025</p>
                                </div>
                                <div class="border border-gray-200 rounded-md p-3">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">Needs-Based Financial Aid</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Not Started
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Financial Assistantship</p>
                                    <p class="text-xs text-gray-500 mt-1">Deadline: June 15, 2025</p>
                                </div>
                            </div>
                            <a href="#" class="block text-center text-sm text-green-600 hover:underline mt-4">Manage Applications</a>
                        </div>
                    </div>
                    
                    <!-- Scholarship Distribution Chart -->
                    <div class="card bg-white rounded-lg shadow col-span-1">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Scholarship Types</h3>
                            <div class="relative" style="height: 250px;">
                                <canvas id="scholarshipChart"></canvas>
                            </div>
                            <div class="text-center mt-4">
                                <p class="text-sm text-gray-500">Available scholarship distribution by type</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Weekly Schedule -->
                <div class="mt-8">
                    <div class="card bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">This Week's Schedule</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuesday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wednesday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thursday</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Friday</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8:00 - 9:30</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">Math 101</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">Math 101</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-blue-100 text-blue-800 py-1 px-2 rounded text-xs">Math 101</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10:00 - 11:30</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-green-100 text-green-800 py-1 px-2 rounded text-xs">CS 201</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-purple-100 text-purple-800 py-1 px-2 rounded text-xs">Psych 101</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-green-100 text-green-800 py-1 px-2 rounded text-xs">CS 201</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-purple-100 text-purple-800 py-1 px-2 rounded text-xs">Psych 101</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1:00 - 2:30</td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded text-xs">Eng Comp</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded text-xs">Eng Comp</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3:00 - 5:30</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-red-100 text-red-800 py-1 px-2 rounded text-xs">Chem Lab</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="bg-red-100 text-red-800 py-1 px-2 rounded text-xs">Chem Lab</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Scholarship Resources -->
                <div class="mt-8">
                    <div class="card bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Scholarship Resources</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="border border-gray-200 rounded-md p-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-blue-100 p-2 rounded-full">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">Application Guidelines</h4>
                                            <p class="mt-1 text-xs text-gray-500">Learn how to properly complete scholarship applications</p>
                                            <a href="#" class="mt-2 text-xs text-green-600 hover:text-green-700 inline-flex items-center">
                                                Download PDF
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-md p-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">Essay Writing Tips</h4>
                                            <p class="mt-1 text-xs text-gray-500">Get helpful tips for writing scholarship essays</p>
                                            <a href="#" class="mt-2 text-xs text-green-600 hover:text-green-700 inline-flex items-center">
                                                View Guide
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-md p-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-yellow-100 p-2 rounded-full">
                                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">Scholarship Calendar</h4>
                                            <p class="mt-1 text-xs text-gray-500">View upcoming scholarship deadlines</p>
                                            <a href="#" class="mt-2 text-xs text-green-600 hover:text-green-700 inline-flex items-center">
                                                Open Calendar
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-md p-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-red-100 p-2 rounded-full">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">Common Mistakes</h4>
                                            <p class="mt-1 text-xs text-gray-500">Learn what to avoid in your applications</p>
                                            <a href="#" class="mt-2 text-xs text-green-600 hover:text-green-700 inline-flex items-center">
                                                Read Article
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-md p-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-purple-100 p-2 rounded-full">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">FAQ</h4>
                                            <p class="mt-1 text-xs text-gray-500">Find answers to common scholarship questions</p>
                                            <a href="#" class="mt-2 text-xs text-green-600 hover:text-green-700 inline-flex items-center">
                                                View FAQ
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border border-gray-200 rounded-md p-4 hover:bg-green-50 transition-colors">
                                    <div class="flex items-start">
                                        <div class="bg-indigo-100 p-2 rounded-full">
                                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-gray-900">Contact Support</h4>
                                            <p class="mt-1 text-xs text-gray-500">Get help with scholarship applications</p>
                                            <a href="#" class="mt-2 text-xs text-green-600 hover:text-green-700 inline-flex items-center">
                                                Contact Us
                                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    labels: ['Financial Assistantship', 'Student Assistantship', 'Both', 'External'],
                    datasets: [{
                        data: [4, 2, 1, 1],
                        backgroundColor: [
                            '#3B82F6', // Blue for Financial
                            '#10B981', // Green for Student Assistantship
                            '#8B5CF6', // Purple for Both
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