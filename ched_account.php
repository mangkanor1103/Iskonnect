<?php
// Include session check at the top before any output
include 'components/session_check.php';

// Check if user is logged in and has admin role
redirect_if_not_authorized('admin');

include 'components/conn.php';

// Fetch CHED accounts list
$ched_list = [];
$sql = "SELECT id, username, created_at FROM users WHERE role = 'ched'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ched_list[] = $row;
    }
}

// Count CHED accounts
$ched_count = count($ched_list);

// Handle Add CHED Account form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Check if the username already exists
        $check_sql = "SELECT id FROM users WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('s', $username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            echo "Error: Username already exists. Please choose a different username.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new CHED user into the database
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'ched')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);

            if ($stmt->execute()) {
                echo "CHED account added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $check_stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}

$conn->close();
?>

<?php include 'components/header.php'; ?>

<!-- Add required libraries for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Improved Sidebar with subtle gradient -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
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
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Home</span>
                        <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-0.5 rounded-full group-hover:bg-green-200 transition-colors duration-300">Dashboard</span>
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
                    <a href="ched_account.php" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="ml-3 text-green-700 font-medium">CHED Accounts</span>
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
                    <a href="index.php" class="flex items-center p-3 rounded-lg hover:bg-red-50 transition-all duration-300">
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
                    <p class="text-xs text-gray-500">admin@iskonnect.com</p>
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
                <h2 class="text-xl font-semibold text-gray-800">CHED Account Management</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Admin</div>
            </div>
            <div class="flex items-center space-x-4">
                <div>
                    <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
                </div>
            </div>
        </div>
        
        <!-- CHED Content -->
        <div class="p-6 animate__animated animate__fadeIn">
            <!-- Stats Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">CHED Account Management</h3>
                            <p class="mt-1 text-sm text-gray-500">You currently have <span class="font-bold text-blue-600"><?php echo $ched_count; ?></span> CHED accounts registered in the system.</p>
                        </div>
                        <div class="ml-auto">
                            <button id="openModal" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New CHED Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- CHED Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">CHED Accounts List</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Complete list of all CHED accounts in the system.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($ched_list as $ched): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo $ched['id']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $ched['username']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $ched['created_at']; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add CHED Account Modal -->
<div id="chedModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md animate__animated animate__fadeInDown">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Add New CHED Account</h2>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="addChedForm" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex items-center justify-end space-x-3 pt-4">
                <button type="button" id="cancelBtn" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add CHED Account
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Initialize particles.js and modal functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize particles.js
    particlesJS("particles-js", {
        "particles": {
            "number": {"value": 80, "density": {"enable": true, "value_area": 800}},
            "color": {"value": "#4ade80"},
            "shape": {"type": "circle", "stroke": {"width": 0, "color": "#000000"}},
            "opacity": {"value": 0.3, "random": false},
            "size": {"value": 3, "random": true},
            "line_linked": {"enable": true, "distance": 150, "color": "#4ade80", "opacity": 0.2, "width": 1},
            "move": {"enable": true, "speed": 2, "direction": "none", "random": false, "straight": false, "out_mode": "out", "bounce": false}
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {"enable": true, "mode": "grab"},
                "onclick": {"enable": true, "mode": "push"},
                "resize": true
            },
            "modes": {
                "grab": {"distance": 140, "line_linked": {"opacity": 1}},
                "push": {"particles_nb": 4}
            }
        },
        "retina_detect": true
    });

    // Modal functionality
    const modal = document.getElementById('chedModal');
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');

    openModal.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
});
</script>

<?php include 'components/footer.php'; ?>