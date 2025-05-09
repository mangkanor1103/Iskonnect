<?php
include 'components/conn.php';

// Fetch staff list
$staff_list = [];
$sql = "SELECT id, username, created_at FROM users WHERE role = 'staff'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $staff_list[] = $row;
    }
}

// Handle Add Staff form submission
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

            // Insert the new staff member into the database
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'staff')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $hashed_password);

            if ($stmt->execute()) {
                echo "Staff added successfully!";
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

<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="w-64 bg-green-500 text-white flex flex-col shadow-lg">
        <div class="p-4 text-center font-bold text-xl border-b border-green-400">Dashboard</div>
        <nav class="flex-1">
            <ul class="space-y-2 p-4">
                <li>
                    <a href="home.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="add_staff.php" class="flex items-center p-2 rounded bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.657-1.343-3-3-3s-3 1.343-3 3 1.343 3 3 3 3-1.343 3-3zm0 0c0 1.657 1.343 3 3 3s3-1.343 3-3-1.343-3-3-3-3 1.343-3 3zm0 0v8m0 0H6m6 0h6"></path>
                        </svg>
                        Add Staff
                    </a>
                </li>
                <li>
                    <a href="feedback.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m-7 4h8a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Feedback
                    </a>
                </li>
                <li>
                    <a href="index.php" class="flex items-center p-2 rounded hover:bg-green-400 transition duration-200">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                        </svg>
                        Log Out
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-bold">Staff List</h1>
            <button id="openModal" class="bg-green-500 text-white px-4 py-2 rounded">Add Staff</button>
        </div>

        <!-- Staff Table -->
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Username</th>
                    <th class="border border-gray-300 px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($staff_list as $staff): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $staff['id']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $staff['username']; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo $staff['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Staff Modal -->
<div id="staffModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded shadow-lg w-1/3">
        <h2 class="text-2xl font-bold mb-4">Add Staff</h2>
        <form id="addStaffForm" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-lg font-medium">Username:</label>
                <input type="text" id="username" name="username" class="border rounded w-full p-2" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lg font-medium">Password:</label>
                <input type="password" id="password" name="password" class="border rounded w-full p-2" required>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Add Staff</button>
            <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Cancel</button>
        </form>
    </div>
</div>

<script>
    // Modal functionality
    const modal = document.getElementById('staffModal');
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');

    openModal.addEventListener('click', () => modal.classList.remove('hidden'));
    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
</script>

<?php include 'components/footer.php'; ?>