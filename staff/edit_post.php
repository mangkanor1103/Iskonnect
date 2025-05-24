<?php
include '../components/session_check.php';

// Check if user is logged in and has staff role
redirect_if_not_authorized('staff');

include '../components/conn.php';

$username = $_SESSION['username'];
// Get user_id directly from session and ensure it's an integer
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$success_message = "";
$error_message = "";

// For debugging - you can remove this in production
// echo "Debug: User ID from session: " . $user_id . "<br>";

// Validate user session first
if ($user_id <= 0) {
    echo "<script>alert('Invalid user session. Please log out and log in again.'); window.location.href='../logout.php';</script>";
    exit();
}

// Check if post ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('No post selected for editing.'); window.location.href='create_post.php';</script>";
    exit();
}

$post_id = (int)$_GET['id']; // Ensure integer type

// Check if the post belongs to the current user
$check_query = "SELECT * FROM scholarship_posts WHERE id = ? AND posted_by = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("ii", $post_id, $user_id);
$check_stmt->execute();
$post_result = $check_stmt->get_result();

// For debugging - you can remove this in production
// echo "Debug: Post ID: " . $post_id . ", User ID: " . $user_id . ", Rows found: " . $post_result->num_rows . "<br>";

if (!$post_result || $post_result->num_rows == 0) {
    echo "<script>alert('You do not have permission to edit this post. This post may belong to another staff member.'); window.location.href='create_post.php';</script>";
    exit();
}

$post = $post_result->fetch_assoc();

// Handle form submission for updating post
if(isset($_POST['update_post'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $scholarship_type = mysqli_real_escape_string($conn, $_POST['scholarship_type']);
    $deadline = !empty($_POST['deadline']) ? mysqli_real_escape_string($conn, $_POST['deadline']) : NULL;
    
    // Process attachment upload if a new file is uploaded
    $attachment_name = $post['attachment']; // Keep the old attachment by default
    if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
        $upload_dir = "../uploads/attachments/";
        // Create directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $attachment_name = uniqid() . '_' . basename($_FILES['attachment']['name']);
        $target_path = $upload_dir . $attachment_name;
        
        // Move uploaded file
        if(move_uploaded_file($_FILES['attachment']['tmp_name'], $target_path)) {
            // If a new file is uploaded successfully, delete the old one if it exists
            if(!empty($post['attachment'])) {
                $old_file = $upload_dir . $post['attachment'];
                if(file_exists($old_file)) {
                    unlink($old_file);
                }
            }
        }
    }
    
    // Update post in database - ensure post can only be updated by its owner
    $update_query = "UPDATE scholarship_posts SET title = ?, content = ?, scholarship_type = ?, attachment = ?, deadline = ? WHERE id = ? AND posted_by = ?";
    
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssii", $title, $content, $scholarship_type, $attachment_name, $deadline, $post_id, $user_id);
        
    if($update_stmt->execute()) {
        if ($update_stmt->affected_rows > 0) {
            $success_message = "Post updated successfully!";
            // Refresh post data
            $check_stmt->execute();
            $post_result = $check_stmt->get_result();
            $post = $post_result->fetch_assoc();
        } else {
            $error_message = "No changes made or you don't have permission to edit this post.";
        }
    } else {
        $error_message = "Error updating post: " . $conn->error;
    }
    
    $update_stmt->close();
}
?>

<?php include '../components/header.php'; ?>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Sidebar -->
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
                    <a href="dashboard.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                <li class="group">
                    <a href="create_post.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Create Scholarship Post</span>
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
                    <p class="text-sm font-medium text-gray-700"><?php echo htmlspecialchars($username); ?></p>
                    <p class="text-xs text-gray-500">Staff</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50 relative">
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Edit Scholarship Post</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Staff</div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
            </div>
        </div>
        
        <!-- Edit Post Form -->
        <div class="p-6">
            <?php if(!empty($success_message)): ?>
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($error_message)): ?>
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <form method="post" enctype="multipart/form-data" class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Scholarship Post</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Post Title *</label>
                            <input type="text" name="title" id="title" required value="<?php echo htmlspecialchars($post['title']); ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        
                        <div>
                            <label for="scholarship_type" class="block text-sm font-medium text-gray-700 mb-1">Scholarship Type</label>
                            <select name="scholarship_type" id="scholarship_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                <option value="">-- Select Type --</option>
                                <option value="Financial Assistantship" <?php echo ($post['scholarship_type'] == 'Financial Assistantship') ? 'selected' : ''; ?>>Financial Assistantship</option>
                                <option value="Student Assistantship Program" <?php echo ($post['scholarship_type'] == 'Student Assistantship Program') ? 'selected' : ''; ?>>Student Assistantship Program</option>
                                <option value="Both" <?php echo ($post['scholarship_type'] == 'Both') ? 'selected' : ''; ?>>Both Types</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Application Deadline</label>
                        <input type="date" name="deadline" id="deadline" value="<?php echo !empty($post['deadline']) ? htmlspecialchars(date('Y-m-d', strtotime($post['deadline']))) : ''; ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500">Set the last date students can apply for this scholarship</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Post Content *</label>
                        <textarea name="content" id="content" rows="8" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"><?php echo htmlspecialchars($post['content']); ?></textarea>
                        <p class="mt-1 text-xs text-gray-500">Provide detailed information about the scholarship opportunity.</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">Attachment (Optional)</label>
                        <?php if(!empty($post['attachment'])): ?>
                            <div class="mb-2 flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                </svg>
                                <span class="text-sm"><?php echo htmlspecialchars(substr($post['attachment'], strpos($post['attachment'], '_') + 1)); ?></span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">Upload a new file to replace the current attachment or leave empty to keep the existing one.</p>
                        <?php endif; ?>
                        <input type="file" name="attachment" id="attachment" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        <p class="mt-1 text-xs text-gray-500">Upload related documents (PDF, Word, etc.)</p>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="create_post.php" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" name="update_post" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>