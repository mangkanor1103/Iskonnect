<?php 
include '../components/session_check.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('ched');

include '../components/conn.php';

$username = $_SESSION['username'];

// IP address for local network access
$server_ip = "192.168.101.78";
$form_url = "http://$server_ip/iskonnect/students.php";

// Add network check JavaScript function
$network_check_js = "
    function checkNetwork() {
        // Create a unique endpoint with timestamp to avoid caching
        const testEndpoint = 'http://$server_ip/iskonnect/components/network_check.php?t=' + new Date().getTime();
        
        return fetch(testEndpoint, { 
            mode: 'no-cors',
            cache: 'no-cache',
            timeout: 2000
        })
        .then(() => {
            const statusEl = document.getElementById('network-status');
            if(statusEl) {
                statusEl.innerHTML = '<span class=\"bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full\">Connected to network</span>';
            }
            const messageEl = document.getElementById('network-message');
            if(messageEl) {
                messageEl.classList.add('hidden');
            }
            return true;
        })
        .catch(() => {
            const statusEl = document.getElementById('network-status');
            if(statusEl) {
                statusEl.innerHTML = '<span class=\"bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full\">Not on the same network</span>';
            }
            const messageEl = document.getElementById('network-message');
            if(messageEl) {
                messageEl.classList.remove('hidden');
            }
            return false;
        });
    }
    
    // Check network status when page loads
    document.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('network-status')) {
            checkNetwork();
            // Re-check every 10 seconds
            setInterval(checkNetwork, 10000);
        }
    });
";
?>

<?php include '../components/header.php'; ?>

<!-- Add required libraries for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script src="../components/qr_script.js"></script>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Improved Sidebar with subtle gradient -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
        <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
            <div class="flex items-center justify-center">
                <svg class="w-8 h-8 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
                <h1 class="text-xl font-bold">Scholarship Admin Portal</h1>
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
                </li>                <li class="group">
                    <a href="reject.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-red-500 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-red-700 font-medium">Rejected Students</span>
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
                    <p class="text-xs text-gray-500">Scholarship admin</p>
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
                <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Scholarship admin</div>
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
                        <div class="uppercase tracking-wide text-sm text-green-500 font-semibold">Dashboard</div>
                        <h1 class="mt-2 text-4xl font-bold text-gray-800 leading-tight">Welcome, <?php echo $username; ?>!</h1>
                        <p class="mt-4 text-gray-600">You have successfully logged in to your scholarship admin portal.</p>
                        
                        <div class="mt-6 inline-flex rounded-md shadow">
                            <a href="students.php" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition">
                                View Pending Applications
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Pending Students Count -->
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
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Applications</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            <?php
                                            $pending_query = "SELECT COUNT(*) as count FROM students WHERE status = 'Pending'";
                                            $pending_result = mysqli_query($conn, $pending_query);
                                            $pending_count = mysqli_fetch_assoc($pending_result)['count'];
                                            echo $pending_count;
                                            ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Approved Students Count -->
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
                                        <div class="text-2xl font-semibold text-gray-900">
                                            <?php
                                            $approved_query = "SELECT COUNT(*) as count FROM students WHERE status = 'Approved'";
                                            $approved_result = mysqli_query($conn, $approved_query);
                                            $approved_count = mysqli_fetch_assoc($approved_result)['count'];
                                            echo $approved_count;
                                            ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rejected Students Count -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Rejected Students</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            <?php
                                            $rejected_query = "SELECT COUNT(*) as count FROM students WHERE status = 'Rejected'";
                                            $rejected_result = mysqli_query($conn, $rejected_query);
                                            $rejected_count = mysqli_fetch_assoc($rejected_result)['count'];
                                            echo $rejected_count;
                                            ?>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Students Count -->
                <div class="bg-white overflow-hidden shadow rounded-lg transition-transform duration-300 hover:-translate-y-1">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Applications</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            <?php
                                            $total_query = "SELECT COUNT(*) as count FROM students";
                                            $total_result = mysqli_query($conn, $total_query);
                                            $total_count = mysqli_fetch_assoc($total_result)['count'];
                                            echo $total_count;
                                            ?>
                                        </div>
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
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Application Activities</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <?php
                        // Get recent updated applications
                        $recent_query = "SELECT s.*, DATE_FORMAT(s.updated_at, '%M %d, %Y, %h:%i %p') as formatted_date 
                                        FROM students s 
                                        WHERE s.updated_at IS NOT NULL 
                                        ORDER BY s.updated_at DESC LIMIT 5";
                        $recent_result = mysqli_query($conn, $recent_query);
                        
                        if (mysqli_num_rows($recent_result) > 0) {
                            while ($row = mysqli_fetch_assoc($recent_result)) {
                                $status_color = "";
                                $status_text = "";
                                
                                switch ($row['status']) {
                                    case 'Approved':
                                        $status_color = "text-green-600";
                                        $status_text = "Application Approved";
                                        break;
                                    case 'Rejected':
                                        $status_color = "text-red-600";
                                        $status_text = "Application Rejected";
                                        break;
                                    case 'Pending':
                                        $status_color = "text-yellow-600";
                                        $status_text = "Application Pending";
                                        break;
                                }
                                ?>
                                <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium <?php echo $status_color; ?> truncate"><?php echo $status_text; ?></p>
                                            <p class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?> - 
                                                <?php echo htmlspecialchars($row['student_id']); ?>
                                            </p>
                                            <?php if (!empty($row['office_remarks'])): ?>
                                                <p class="text-xs text-gray-400 mt-1"><?php echo htmlspecialchars($row['office_remarks']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <p class="text-sm text-gray-500"><?php echo $row['formatted_date']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="px-4 py-5 text-center text-gray-500">No recent activities found</div>';
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

<!-- Network check script -->
<script>
<?php echo $network_check_js; ?>
</script>

<?php include '../components/footer.php'; ?>