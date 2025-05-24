<?php
// Include session check at the top before any output
include 'components/session_check.php';

// Check if user is logged in and has admin role
redirect_if_not_authorized('admin');

// Include connection
include 'components/conn.php';

// Fetch all feedback messages
$feedback_query = "SELECT id, name, email, message, created_at FROM feedback ORDER BY created_at DESC";
$feedback_result = $conn->query($feedback_query);

// Count feedback messages
$feedback_count = 0;
$total_query = "SELECT COUNT(*) as total FROM feedback";
$total_result = $conn->query($total_query);
if ($total_result) {
    $row = $total_result->fetch_assoc();
    $feedback_count = $row['total'];
}

// Handle deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $delete_success = true;
        // Redirect to avoid resubmission on refresh
        header("Location: feedback.php?deleted=true");
        exit();
    } else {
        $delete_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management - Iskonnect</title>
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
        .feedback-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .sidebar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-300 min-h-screen">
    <!-- Animated particles -->
    <div id="particles-js" class="particles-container"></div>
    
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gradient-to-r from-green-600 to-green-800 text-white shadow-lg py-4">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="flex items-center animate__animated animate__fadeIn">
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_uwh9uhdt.json" background="transparent" speed="1" style="width: 50px; height: 50px;" autoplay loop></lottie-player>
                    <h1 class="text-3xl font-extrabold ml-2">Iskonnect</h1>
                </div>
                <div class="hidden md:flex items-center space-x-4 animate__animated animate__fadeIn animate__delay-1s">
                    <a href="dashboard.php" class="hover:text-green-100 transition cursor-pointer">Dashboard</a>
                    <a href="logout.php" class="hover:text-green-100 transition cursor-pointer">Log Out</a>
                </div>
            </div>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar -->
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
                            <a href="dashboard.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Dashboard</span>
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
                            <a href="feedback.php" class="flex items-center p-3 rounded-lg bg-green-50 hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                                <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Feedback</span>
                                <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full"><?php echo $feedback_count; ?></span>
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

            <!-- Main Content -->
            <div class="flex-1 overflow-y-auto p-6 animate__animated animate__fadeIn">
                <!-- Header Card -->
                <div class="feedback-card rounded-xl shadow-lg overflow-hidden mb-8 animate__animated animate__fadeIn">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-3/5 p-6">
                            <div class="uppercase tracking-wide text-sm text-green-500 font-semibold">Feedback Management</div>
                            <h1 class="mt-1 text-3xl font-bold text-gray-800 leading-tight">User Feedback</h1>
                            <p class="mt-2 text-gray-600">Review and manage feedback submitted by users of the Iskonnect platform.</p>
                        </div>
                        <div class="md:w-2/5 bg-green-100 p-4 flex items-center justify-center">
                            <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_dzkneb5j.json" background="transparent" speed="1" class="w-full max-w-xs" autoplay loop></lottie-player>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="feedback-card rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Feedback</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900"><?php echo $feedback_count; ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feedback-card rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Today's Date</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-lg font-semibold text-gray-900"><?php echo date("F j, Y"); ?></div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="feedback-card rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Actions Available</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-lg font-semibold text-gray-900">View and Delete</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Feedback List -->
                <div class="feedback-card rounded-xl shadow-lg p-6 overflow-hidden">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Feedback Messages</h2>
                    
                    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true'): ?>
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">Feedback message deleted successfully.</p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Feedback Table -->
                    <div class="overflow-x-auto">
                        <?php if ($feedback_result && $feedback_result->num_rows > 0): ?>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($row = $feedback_result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['name']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($row['email']); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate"><?php echo htmlspecialchars($row['message']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500"><?php echo date('M j, Y g:i A', strtotime($row['created_at'])); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-3">
                                            <button onclick="viewFeedback(<?php echo $row['id']; ?>, '<?php echo addslashes(htmlspecialchars($row['name'])); ?>', '<?php echo addslashes(htmlspecialchars($row['email'])); ?>', '<?php echo addslashes(htmlspecialchars($row['message'])); ?>', '<?php echo date('M j, Y g:i A', strtotime($row['created_at'])); ?>')" class="text-blue-600 hover:text-blue-900 focus:outline-none">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteFeedback(<?php echo $row['id']; ?>)" class="text-red-600 hover:text-red-900 focus:outline-none">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No feedback messages</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no feedback messages to display at this time.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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

        // GSAP animations for feedback cards
        gsap.from(".feedback-card", {
            duration: 0.8,
            y: 20,
            opacity: 0,
            stagger: 0.1,
            ease: "power3.out"
        });
    });
    
    // View Feedback Details Function
    function viewFeedback(id, name, email, message, date) {
        Swal.fire({
            title: 'Feedback Details',
            html: `
                <div class="text-left">
                    <div class="mb-3">
                        <p class="text-sm text-gray-500">From:</p>
                        <p class="font-medium">${name}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-sm text-gray-500">Email:</p>
                        <p class="font-medium">${email}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-sm text-gray-500">Date:</p>
                        <p class="font-medium">${date}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Message:</p>
                        <p class="font-medium whitespace-pre-line">${message}</p>
                    </div>
                </div>
            `,
            confirmButtonText: 'Close',
            confirmButtonColor: '#22c55e',
            customClass: {
                confirmButton: 'px-4 py-2 text-white rounded-md'
            }
        });
    }
    
    // Delete Feedback Function
    function deleteFeedback(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `feedback.php?delete=${id}`;
            }
        });
    }
    </script>
</body>
</html>