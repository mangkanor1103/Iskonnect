<?php include 'components/header.php'; ?>
<?php include 'components/conn.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Check the role and redirect accordingly
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");
            } elseif ($user['role'] === 'staff') {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            // Password does not match
            echo "<p class='text-red-500 text-center'>Invalid password.</p>";
        }
    } else {
        // User not found
        echo "<p class='text-red-500 text-center'>User not found.</p>";
    }
}
?>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <form action="" method="POST" class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800">Welcome Back</h2>
        <p class="text-sm text-gray-600 mb-6 text-center">Please enter your credentials to log in.</p>
        <div class="mb-5">
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input type="text" name="username" id="username" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your username" required>
        </div>
        <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-300">Login</button>
        <p class="text-sm text-gray-600 mt-4 text-center">Forgot your password? <a href="#" class="text-blue-500 hover:underline">Reset it here</a>.</p>
    </form>
</div>

<?php include 'components/footer.php'; ?>