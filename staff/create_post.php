<?php 
include '../components/session_check.php';

// Check if user is logged in and has staff role
redirect_if_not_authorized('staff');

include '../components/conn.php';

// Ensure we have the correct session data
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    // Redirect to login page if session is invalid
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$success_message = "";
$error_message = "";

// Handle form submission
if(isset($_POST['submit_post'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Normalize line endings to ensure consistent behavior across platforms
    $how_to_apply = str_replace('\n', "\n", $_POST['how_to_apply']); // Replace literal \n with actual newlines
    $how_to_apply = str_replace("\r\n", "\n", $how_to_apply); // Normalize Windows line endings
    $how_to_apply = mysqli_real_escape_string($conn, $how_to_apply);
    
    // Handle scholarship type (regular or custom)
    if($_POST['scholarship_type'] == 'custom' && !empty($_POST['custom_scholarship_type'])) {
        $scholarship_type = mysqli_real_escape_string($conn, $_POST['custom_scholarship_type']);
    } else {
        $scholarship_type = mysqli_real_escape_string($conn, $_POST['scholarship_type']);
    }
    
    $validity_date = mysqli_real_escape_string($conn, $_POST['validity_date']); // Add this line
    
    // Process attachment upload
    $attachment_name = "";
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
            $attachment_name = $attachment_name;
        }
    }
    
    // Double-check user_id is valid and cast to integer for security
    $user_id = (int)$_SESSION['user_id'];
    if ($user_id <= 0) {
        $error_message = "Invalid user session. Please log out and log in again.";
    } else {
        // Insert post into database - ensure posted_by is correctly typed as integer
        $query = "INSERT INTO scholarship_posts (title, content, scholarship_type, posted_by, attachment, deadline, how_to_apply) 
                VALUES (?, ?, ?, ?, ?, ?, ?)"; // Added how_to_apply field
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssisss", $title, $content, $scholarship_type, $user_id, $attachment_name, $validity_date, $how_to_apply);
        
        if($stmt->execute()) {
            $success_message = "Post created successfully!";
        } else {
            $error_message = "Error creating post: " . $conn->error;
        }
        
        $stmt->close();
    }
}

// Get all existing posts for this staff member only
$user_id = (int)$_SESSION['user_id']; // Cast to integer for type safety
$posts_query = "SELECT * FROM scholarship_posts WHERE posted_by = ? ORDER BY created_at DESC";
$posts_stmt = $conn->prepare($posts_query);
$posts_stmt->bind_param("i", $user_id);
$posts_stmt->execute();
$posts_result = $posts_stmt->get_result();
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
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Applicants</span>
                    </a>
                </li>
                <li class="group">
                    <a href="create_post.php" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Create Scholarship Post</span>
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
                <h2 class="text-xl font-semibold text-gray-800">Create Scholarship Post</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Staff</div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
            </div>
        </div>
        
        <!-- Create Post Form -->
        <div class="p-6 max-w-5xl mx-auto">
            <?php if(!empty($success_message)): ?>
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <div class="flex">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p><?php echo $success_message; ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(!empty($error_message)): ?>
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <div class="flex">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p><?php echo $error_message; ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Create New Scholarship Post</h3>
                    <p class="text-sm text-gray-500 mt-1">Fill in the details below to create a new scholarship opportunity</p>
                </div>
                
                <form method="post" enctype="multipart/form-data" class="p-8 space-y-6">
                    <!-- Title and Type Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-medium text-gray-700">Post Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required 
                                class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="scholarship_type" class="block text-sm font-medium text-gray-700">Scholarship Type</label>
                            <select name="scholarship_type" id="scholarship_type" 
                                class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                onchange="checkCustomType()">
                                <option value="">-- Select Type --</option>
                                <option value="Financial Assistantship">Financial Assistantship</option>
                                <option value="Student Assistantship Program">Student Assistantship Program</option>
                                <option value="Both">Both Types</option>
                                <option value="custom">Other (specify)</option>
                            </select>
                            
                            <div id="custom_type_container" class="mt-3 hidden">
                                <input type="text" name="custom_scholarship_type" id="custom_scholarship_type" 
                                    placeholder="Enter custom scholarship type" 
                                    class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="space-y-2">
                        <label for="content" class="block text-sm font-medium text-gray-700">Post Content <span class="text-red-500">*</span></label>
                        <textarea name="content" id="content" rows="8" required 
                            class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                        <p class="text-xs text-gray-500 italic">Provide detailed information about the scholarship opportunity including eligibility requirements and benefits.</p>
                    </div>
                    
                    <!-- How to Apply Section -->
                    <div class="space-y-2">
                        <label for="how_to_apply" class="block text-sm font-medium text-gray-700">How to Apply</label>
                        <textarea name="how_to_apply" id="how_to_apply" rows="4" 
                            class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                        <p class="text-xs text-gray-500 italic">Provide step-by-step instructions for students on how to apply for this scholarship.</p>
                    </div>
                    
                    <!-- File and Date Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment</label>
                            <div class="flex items-center">
                                <label class="w-full flex items-center justify-center px-4 py-2.5 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50">
                                    <svg class="mr-2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">Choose file</span>
                                    <input type="file" name="attachment" id="attachment" class="hidden">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 italic">Upload related documents (PDF, Word, etc.)</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="validity_date" class="block text-sm font-medium text-gray-700">Application Deadline <span class="text-red-500">*</span></label>
                            <input type="date" name="validity_date" id="validity_date" required 
                                class="w-full border border-gray-300 rounded-lg shadow-sm px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <p class="text-xs text-gray-500 italic">Select the final date for application submissions.</p>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" name="submit_post" 
                            class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Publish Scholarship
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Existing Posts -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Published Posts</h3>
                    
                    <?php if($posts_result->num_rows > 0): ?>
                        <div class="space-y-4">
                            <?php while($post = $posts_result->fetch_assoc()): ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                    <h4 class="text-md font-medium text-gray-900"><?php echo htmlspecialchars($post['title']); ?></h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Posted on: <?php echo date('F j, Y', strtotime($post['created_at'])); ?> 
                                        <?php if(!empty($post['scholarship_type'])): ?>
                                            | Type: <?php echo htmlspecialchars($post['scholarship_type']); ?>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-gray-700 mt-2"><?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 150))); ?><?php if(strlen($post['content']) > 150) echo '...'; ?></p>
                                    <?php if(!empty($post['how_to_apply'])): ?>
                                        <p class="text-sm text-blue-600 mt-2">
                                            <span class="font-medium">How to Apply:</span> 
                                            <span class="whitespace-pre-line"><?php 
                                                // Replace literal "\n" with actual newlines before displaying
                                                $how_to_apply = str_replace('\n', "\n", $post['how_to_apply']);
                                                echo htmlspecialchars(substr($how_to_apply, 0, 100)); 
                                                if(strlen($how_to_apply) > 100) echo '...'; 
                                            ?></span>
                                        </p>
                                    <?php endif; ?>
                                    <?php if(!empty($post['attachment'])): ?>
                                        <p class="text-sm text-green-600 mt-2">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                Attachment: <?php echo htmlspecialchars(substr($post['attachment'], strpos($post['attachment'], '_') + 1)); ?>
                                            </span>
                                        </p>
                                    <?php endif; ?>
                                    <!-- Add this edit button below the attachment display -->
                                    <div class="mt-3 flex justify-end">
                                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 rounded-md hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Post
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">You haven't published any posts yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>
