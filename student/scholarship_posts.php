<?php 
include '../components/session_check.php';

// Check if user is logged in and has student role
redirect_if_not_authorized('student');

include '../components/conn.php';

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];

// Get student information
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get scholarship posts - default to all posts
$scholarship_filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$query = "SELECT p.*, u.username as poster_name 
          FROM scholarship_posts p 
          INNER JOIN users u ON p.posted_by = u.id 
          WHERE 1=1";

// If filter is not "all", add condition for scholarship type
if ($scholarship_filter !== 'all') {
    if ($scholarship_filter === 'Financial Assistantship' || $scholarship_filter === 'Student Assistantship Program') {
        $query .= " AND (p.scholarship_type = ? OR p.scholarship_type = 'Both')";
    } else {
        $query .= " AND p.scholarship_type = ?";
    }
}

$query .= " ORDER BY p.created_at DESC";

$stmt = $conn->prepare($query);
if ($scholarship_filter !== 'all') {
    $stmt->bind_param("s", $scholarship_filter);
}
$stmt->execute();
$posts = $stmt->get_result();
?>

<?php include '../components/header.php'; ?>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Sidebar -->
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
                    <a href="dashboard.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Dashboard</span>
                    </a>
                </li>
                <li class="group">
                    <a href="scholarship_posts.php" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50">
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Scholarship Opportunities</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Student</div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
            </div>
        </div>

        <!-- Scholarship Posts Content -->
        <div class="p-6">            <!-- Filter options -->
            <div class="mb-6 flex flex-wrap gap-2">
                <a href="?filter=all" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $scholarship_filter === 'all' ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'; ?>">
                    All Scholarships
                </a>
                <a href="?filter=Financial Assistantship" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $scholarship_filter === 'Financial Assistantship' ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'; ?>">
                    Financial Assistantship
                </a>
                <a href="?filter=Student Assistantship Program" class="px-4 py-2 rounded-full text-sm font-medium <?php echo $scholarship_filter === 'Student Assistantship Program' ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'; ?>">
                    Student Assistantship Program
                </a>
                
                <?php
                // Get unique scholarship types excluding standard ones
                $unique_types_query = "SELECT DISTINCT scholarship_type FROM scholarship_posts 
                                       WHERE scholarship_type NOT IN ('Financial Assistantship', 'Student Assistantship Program', 'Both', '')";
                $unique_types_result = $conn->query($unique_types_query);
                
                if ($unique_types_result && $unique_types_result->num_rows > 0) {
                    while ($type = $unique_types_result->fetch_assoc()) {
                        if (!empty($type['scholarship_type'])) {
                            echo '<a href="?filter=' . urlencode($type['scholarship_type']) . '" 
                                     class="px-4 py-2 rounded-full text-sm font-medium ' . 
                                     ($scholarship_filter === $type['scholarship_type'] ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50') . 
                                     '">' . htmlspecialchars($type['scholarship_type']) . '</a>';
                        }
                    }
                }
                ?>
            </div>
            
            <?php if ($posts->num_rows > 0): ?>
                <div class="space-y-6">
                    <?php while ($post = $posts->fetch_assoc()): ?>
                        <?php 
                            $is_expired = false;
                            if (!empty($post['deadline'])) {
                                $deadline = strtotime($post['deadline']);
                                $current_time = time();
                                $is_expired = $current_time > $deadline;
                            }
                        ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden animate__animated animate__fadeIn <?php echo $is_expired ? 'border border-red-200' : ''; ?>">
                            <?php if ($is_expired): ?>
                                <div class="bg-red-50 px-4 py-2 text-red-700 border-b border-red-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">This scholarship has expired</span>
                                </div>
                            <?php endif; ?>
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <a href="view_scholarship.php?id=<?php echo $post['id']; ?>" class="hover:text-green-700">
                                            <h3 class="text-lg font-semibold text-gray-900 hover:text-green-700 mb-1"><?php echo htmlspecialchars($post['title']); ?></h3>
                                        </a>
                                        <p class="text-sm text-gray-500">
                                            Posted by: <?php echo htmlspecialchars($post['poster_name']); ?> • 
                                            <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                                            <?php if (!empty($post['deadline'])): ?>
                                                • <span class="<?php echo $is_expired ? 'text-red-600 font-medium' : ''; ?>">
                                                    <?php echo $is_expired ? 'Expired: ' : 'Deadline: '; ?>
                                                    <?php echo date('F j, Y', strtotime($post['deadline'])); ?>
                                                </span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-2 items-end">
                                        <?php if (!empty($post['scholarship_type'])): ?>                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                <?php 
                                                switch ($post['scholarship_type']) {
                                                    case 'Financial Assistantship':
                                                        echo 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'Student Assistantship Program':
                                                        echo 'bg-purple-100 text-purple-800';
                                                        break;
                                                    case 'Both':
                                                        echo 'bg-green-100 text-green-800';
                                                        break;
                                                    default:
                                                        // Generate a consistent color for custom scholarship types
                                                        $hash = crc32($post['scholarship_type']);
                                                        $background_colors = ['bg-indigo-100', 'bg-pink-100', 'bg-amber-100', 'bg-cyan-100', 'bg-lime-100', 'bg-rose-100'];
                                                        $text_colors = ['text-indigo-800', 'text-pink-800', 'text-amber-800', 'text-cyan-800', 'text-lime-800', 'text-rose-800'];
                                                        $color_index = abs($hash) % count($background_colors);
                                                        echo $background_colors[$color_index] . ' ' . $text_colors[$color_index];
                                                }
                                                ?>">
                                                <?php echo htmlspecialchars($post['scholarship_type']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                  <div class="mt-4 prose max-w-none text-gray-700">
                                    <?php echo nl2br(htmlspecialchars(substr($post['content'], 0, 300))); ?>
                                    <?php if(strlen($post['content']) > 300): ?>
                                        <span class="text-gray-500">...</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mt-4 flex justify-between items-center">
                                    <div>
                                        <?php if (!empty($post['attachment'])): ?>
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                <a href="../uploads/attachments/<?php echo htmlspecialchars($post['attachment']); ?>" class="text-green-600 hover:text-green-700 font-medium" target="_blank" download>
                                                    Download attachment: <?php echo htmlspecialchars(substr($post['attachment'], strpos($post['attachment'], '_') + 1)); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Add bottom View Details button -->
                                    <a href="view_scholarship.php?id=<?php echo $post['id']; ?>" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No scholarship posts found</h3>
                    <p class="text-gray-500">There are currently no scholarship posts available in this category.</p>
                    <?php if ($scholarship_filter !== 'all'): ?>
                        <a href="?filter=all" class="mt-4 inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md shadow-sm font-medium hover:bg-green-600 transition-colors">
                            View All Scholarships
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>
