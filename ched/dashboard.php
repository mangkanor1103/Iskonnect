<?php 
include '../components/session_check.php';

// Check if user is logged in and has staff role
redirect_if_not_authorized('ched');

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
                <h1 class="text-xl font-bold">CHED Portal</h1>
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
                    <p class="text-xs text-gray-500">CHED Officer</p>
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
                <h2 class="text-xl font-semibold text-gray-800">CHED Dashboard</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">CHED</div>
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
                    <div class="md:w-1/2 p-8">
                        <div class="uppercase tracking-wide text-sm text-green-500 font-semibold">CHED Dashboard</div>
                        <h1 class="mt-2 text-4xl font-bold text-gray-800 leading-tight">Welcome, <?php echo $username; ?>!</h1>
                        <p class="mt-4 text-gray-600">You have successfully logged in to your CHED portal. From here, you can manage your daily tasks, view your schedule, and submit reports.</p>
                        
                        <div class="mt-6 inline-flex rounded-md shadow">
                            <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                                View Today's Tasks
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/2 bg-green-100 p-8 flex items-center justify-center">
                        <div class="w-full max-w-sm">
                            <img src="https://cdn.pixabay.com/photo/2017/01/31/15/33/calendar-2025112_1280.png" alt="Staff Work Illustration" class="w-full h-auto animate__animated animate__pulse animate__infinite animate__slower">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Quick Stat 1 -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Today's Tasks</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">8</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stat 2 -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Tasks</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">5</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stat 3 -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Reports</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">3</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stat 4 -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Upcoming Events</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">2</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
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
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-green-600 truncate">Task submission completed</p>
                                    <p class="text-sm text-gray-500">Weekly report was submitted successfully</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <p class="text-sm text-gray-500">Today, 10:30 AM</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-green-600 truncate">New task assigned</p>
                                    <p class="text-sm text-gray-500">Department meeting preparation</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <p class="text-sm text-gray-500">Today, 9:15 AM</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium text-green-600 truncate">Reminder</p>
                                    <p class="text-sm text-gray-500">Document submission deadline tomorrow</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <p class="text-sm text-gray-500">Yesterday, 4:45 PM</p>
                                </div>
                            </div>
                        </div>
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