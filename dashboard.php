<?php 
// Include session check at the top before any output
include 'components/session_check.php';

// Check if user is logged in and has admin role
redirect_if_not_authorized('admin');

// Do not include the header.php component since we'll create our own header
// include 'components/header.php'; 
include 'components/conn.php';

// Count staff accounts
$staff_count = 0;
$staff_query = "SELECT COUNT(*) as staff_count FROM users WHERE role = 'staff'";
$staff_result = $conn->query($staff_query);
if ($staff_result) {
    $row = $staff_result->fetch_assoc();
    $staff_count = $row['staff_count'];
}

// Count CHED accounts
$ched_count = 0;
$ched_query = "SELECT COUNT(*) as ched_count FROM users WHERE role = 'ched'";
$ched_result = $conn->query($ched_query);
if ($ched_result) {
    $row = $ched_result->fetch_assoc();
    $ched_count = $row['ched_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iskonnect - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Add SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add Lottie Player for animations -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <!-- Add particles.js for background effects -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .particles-container {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .dashboard-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .modal {
            transition: opacity 0.25s ease;
        }
        .modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-300 min-h-screen">
    <!-- Animated particles -->
    <div id="particles-js" class="particles-container"></div>
    
    <div class="min-h-screen flex flex-col">
        <!-- Header - Matching index.php style -->
        <header class="bg-gradient-to-r from-green-600 to-green-800 text-white shadow-lg py-4">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="flex items-center animate__animated animate__fadeIn">
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_uwh9uhdt.json" background="transparent" speed="1" style="width: 50px; height: 50px;" autoplay loop></lottie-player>
                    <h1 class="text-3xl font-extrabold ml-2">Iskonnect</h1>
                </div>
                <div class="space-x-4 hidden md:block animate__animated animate__fadeIn animate__delay-1s">
                    <button id="aboutBtn" class="hover:text-green-100 transition cursor-pointer">About</button>
                    <button id="contactBtn" class="hover:text-green-100 transition cursor-pointer">Contact</button>
                    <button id="helpBtn" class="hover:text-green-100 transition cursor-pointer">Help</button>
                </div>
            </div>
        </header>

        <!-- Main Content Area with Sidebar -->
        <div class="flex flex-1">
            <!-- Sidebar with subtle gradient - now styled to match index.php aesthetics -->
            <div class="sidebar w-64 border-r border-green-100 flex flex-col shadow-lg z-10 relative">
                <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
                    <div class="flex items-center justify-center">
                        <svg class="w-8 h-8 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"></path>
                        </svg>
                        <h1 class="text-xl font-bold">Admin Panel</h1>
                    </div>
                </div>
                <nav class="flex-1">
                    <ul class="space-y-1 p-3">
                        <li class="group">
                            <a href="dashboard.php" class="flex items-center p-3 rounded-lg bg-green-50 hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Dashboard</span>
                                <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-0.5 rounded-full group-hover:bg-green-200 transition-colors duration-300">Home</span>
                            </a>
                        </li>
                        <li class="group">
                            <a href="add_staff.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Add Staff</span>
                            </a>
                        </li>
                        <li class="group">
                            <a href="ched_account.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">CHED Accounts</span>
                            </a>
                        </li>
                        <li class="group">
                            <a href="feedback.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Feedback</span>
                                <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse">New</span>
                            </a>
                        </li>
                        <li class="border-t border-gray-100 my-2 pt-2"></li>
                        <li class="group">
                            <a href="logout.php" class="flex items-center p-3 rounded-lg hover:bg-red-50 transition-all duration-300">
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
                        <div class="w-8 h-8 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold">A</div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-700">Admin User</p>
                            <p class="text-xs text-gray-500"><?php echo $_SESSION['username']; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Content - Styled to match index.php aesthetics -->
            <div class="flex-1 overflow-y-auto p-6 animate__animated animate__fadeIn">
                <!-- Top Stats Summary Card - Similar to login welcome panel -->
                <div class="dashboard-card rounded-xl shadow-lg overflow-hidden mb-8 animate__animated animate__fadeIn">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/2 p-8">
                            <div class="uppercase tracking-wide text-sm text-green-500 font-semibold">Admin Dashboard</div>
                            <h1 class="mt-2 text-4xl font-bold text-gray-800 leading-tight">Welcome Back!</h1>
                            <p class="mt-4 text-gray-600">You have successfully logged in to your dashboard. Here's your system overview for today.</p>
                            
                            <div class="mt-6 inline-flex rounded-md shadow">
                                <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                                    View Reports
                                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="md:w-1/2 bg-green-100 p-8 flex items-center justify-center">
                            <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_iorpbol0.json" background="transparent" speed="1" class="w-full max-w-sm" autoplay loop></lottie-player>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats - With floating animation similar to index.php -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Quick Stat 1 - Staff Count -->
                    <div class="dashboard-card rounded-xl shadow-md p-6 animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Staff</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $staff_count; ?></div>
                                        <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                            <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Increased by</span>
                                            12%
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stat 2 - CHED Accounts -->
                    <div class="dashboard-card rounded-xl shadow-md p-6 animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">CHED Accounts</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $ched_count; ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Stat 3 - Notifications -->
                    <div class="dashboard-card rounded-xl shadow-md p-6 animate__animated animate__fadeInUp animate__delay-3s">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">New Notifications</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">3</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Stat 4 - System Status -->
                    <div class="dashboard-card rounded-xl shadow-md p-6 animate__animated animate__fadeInUp animate__delay-4s">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">System Status</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-lg font-semibold text-gray-900">All Systems Operational</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="dashboard-card rounded-xl shadow-md p-6">
                        <div class="space-y-4">
                            <div class="flex items-start p-3 bg-green-50 rounded-lg">
                                <div class="bg-green-100 rounded-full p-2 mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">New staff account created</p>
                                    <p class="text-xs text-gray-500 mt-1">Today, 10:30 AM</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start p-3 bg-blue-50 rounded-lg">
                                <div class="bg-blue-100 rounded-full p-2 mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">New report submitted by CHED</p>
                                    <p class="text-xs text-gray-500 mt-1">Yesterday, 3:45 PM</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start p-3 bg-yellow-50 rounded-lg">
                                <div class="bg-yellow-100 rounded-full p-2 mr-3">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">System maintenance scheduled</p>
                                    <p class="text-xs text-gray-500 mt-1">May 12, 2025 at 11:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- About Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden modal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate__animated animate__fadeInDown">
            <div class="flex justify-between items-center border-b p-4 md:p-6">
                <h3 class="text-xl font-semibold text-gray-800">About Iskonnect</h3>
                <button class="closeModal text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-6">
                <!-- Modal content -->
                <div class="mb-4 text-center">
                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-2">Iskonnect Platform</h4>
                    <p class="text-gray-600">Version 1.0.0</p>
                </div>
                <div class="space-y-3 text-gray-600">
                    <p>Iskonnect is a comprehensive management platform designed for educational institutions to streamline communication between staff and CHED officials.</p>
                    <p>Our mission is to simplify administrative tasks and improve coordination between different stakeholders in the education sector.</p>
                    <p>Developed by the IT Department of Iskonnect, this platform offers robust features for user management, reporting, and data analytics.</p>
                </div>
                <div class="border-t mt-6 pt-4">
                    <p class="text-sm text-gray-500">&copy; 2025 Iskonnect. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden modal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate__animated animate__fadeInDown">
            <div class="flex justify-between items-center border-b p-4 md:p-6">
                <h3 class="text-xl font-semibold text-gray-800">Contact Us</h3>
                <button class="closeModal text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-6">
                <!-- Contact modal content -->
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">support@iskonnect.com</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium">+63 (2) 8123-4567</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">123 CHED Building, Quezon Avenue, Quezon City, Philippines</p>
                        </div>
                    </div>
                </div>
                <form id="contactForm" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="3" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                    <div id="formMessage" class="hidden p-3 rounded-md">
                    </div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="helpModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden modal">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 animate__animated animate__fadeInDown">
            <!-- Help modal content -->
            <!-- Similar to the aboutModal and contactModal structure -->
        </div>
    </div>

    <!-- Initialize particles.js effect -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize particles.js
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
                    "random": false,
                    "anim": {
                        "enable": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false
                    }
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
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
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

        // GSAP animations for dashboard cards
        gsap.from(".dashboard-card", {
            duration: 0.8,
            y: 20,
            opacity: 0,
            stagger: 0.1,
            ease: "power3.out"
        });

        // Modal handling
        const aboutBtn = document.getElementById('aboutBtn');
        const contactBtn = document.getElementById('contactBtn');
        const helpBtn = document.getElementById('helpBtn');
        
        const aboutModal = document.getElementById('aboutModal');
        const contactModal = document.getElementById('contactModal');
        const helpModal = document.getElementById('helpModal');
        
        const closeButtons = document.querySelectorAll('.closeModal');
        
        // Open modal functions
        if (aboutBtn) {
            aboutBtn.addEventListener('click', function() {
                aboutModal.classList.remove('hidden');
                document.body.classList.add('modal-active');
            });
        }
        
        if (contactBtn) {
            contactBtn.addEventListener('click', function() {
                contactModal.classList.remove('hidden');
                document.body.classList.add('modal-active');
            });
        }
        
        if (helpBtn) {
            helpBtn.addEventListener('click', function() {
                helpModal.classList.remove('hidden');
                document.body.classList.add('modal-active');
            });
        }
        
        // Close modal function
        function closeModal() {
            if (aboutModal) aboutModal.classList.add('hidden');
            if (contactModal) contactModal.classList.add('hidden');
            if (helpModal) helpModal.classList.add('hidden');
            document.body.classList.remove('modal-active');
        }
        
        // Add click event to all close buttons
        closeButtons.forEach(function(button) {
            button.addEventListener('click', closeModal);
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === aboutModal || event.target === contactModal || event.target === helpModal) {
                closeModal();
            }
        });
        
        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    });
    </script>
</body>
</html>