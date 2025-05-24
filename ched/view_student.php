<?php 
include '../components/session_check.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('ched');

include '../components/conn.php';

$username = $_SESSION['username'];

// Check if student ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('No student selected.'); window.location.href='students.php';</script>";
    exit();
}

$student_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch student data
$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Student not found.'); window.location.href='students.php';</script>";
    exit();
}

$student = mysqli_fetch_assoc($result);

// Handle status update if form is submitted
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $remarks = mysqli_real_escape_string($conn, $_POST['office_remarks']);
    
    $update_query = "UPDATE students SET 
                    status = '$new_status',
                    office_remarks = '$remarks',
                    office_screened = '$username',
                    updated_at = NOW()
                    WHERE id = '$student_id'";
                    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Student status updated successfully.');</script>";
        // Refresh student data
        $result = mysqli_query($conn, $query);
        $student = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Error updating status: " . mysqli_error($conn) . "');</script>";
    }
}

// Format functions
function format_money($amount) {
    if ($amount == 0 || $amount == "") return "—";
    return "₱ " . number_format($amount, 2);
}

function format_date($date) {
    if (empty($date) || $date == "0000-00-00") return "—";
    return date("F j, Y", strtotime($date));
}

function format_value($value) {
    if (empty($value)) return "—";
    return $value;
}

function get_status_badge($status) {
    switch ($status) {
        case 'Approved':
            return '<span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>';
        case 'Rejected':
            return '<span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>';
        case 'Pending':
        default:
            return '<span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>';
    }
}

function get_scholarship_badge($type) {
    if ($type == 'Financial Assistantship') {
        return '<span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Financial Assistantship</span>';
    } else {
        return '<span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Student Assistantship Program</span>';
    }
}

?>

<?php include '../components/header.php'; ?>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">        <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
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
                    <p class="text-xs text-gray-500">Staff Member</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50 relative">
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Student Application Details</h2>
                <div class="ml-4 flex space-x-2">
                    <?php echo get_status_badge($student['status']); ?>
                    <?php echo get_scholarship_badge($student['scholarship_type']); ?>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="students.php" class="text-gray-600 hover:text-green-700 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Students
                </a>
                <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
            </div>
        </div>
        
        <!-- Application Form -->
        <div class="p-6 max-w-7xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <!-- Form Header -->
                <div class="bg-green-700 text-white p-4 text-center">
                    <h2 class="text-xl font-bold">Mindoro State University</h2>
                    <p>Victoria, Oriental Mindoro 5205 Philippines</p>
                    <h3 class="mt-2 font-bold">OFFICE STUDENT AFFAIRS SERVICES</h3>
                    <h1 class="mt-4 text-2xl font-bold">APPLICATION FORM (Scholarship/ Assistantship)</h1>
                    <p class="mt-1 text-sm">MSU-ADM-FR-01.01</p>
                </div>

                <!-- Data Privacy Notice -->
                <div class="p-4 bg-gray-100 border-b">
                    <p class="text-sm italic text-gray-700"><strong>DATA PRIVACY CLAUSE:</strong> By completing this form, I hereby agree that Mindoro State University, may collect, use, disclose, and process my personal data for the purposes of application for education, scholarships or enrollment. Requests for inspection, amendment, or restriction of records must be in writing and addressed to the Office of Student Affairs and Services and must specify the reasons for the request. Mindoro State University reserves the right to respond appropriately according to law.</p>
                </div>

                <!-- Application Content -->
                <div class="p-6">
                    <!-- Action buttons -->
                    <div class="flex justify-end mb-4 space-x-2">
                        <button onclick="printApplication()" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Application
                        </button>
                        <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Application
                        </a>
                    </div>

                    <!-- PERSONAL INFORMATION -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">PERSONAL INFORMATION</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="col-span-3">
                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600">Full Name:</p>
                                        <p class="font-medium"><?php echo format_value($student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Student ID:</p>
                                        <p class="font-medium"><?php echo format_value($student['student_id']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Course/Year:</p>
                                        <p class="font-medium"><?php echo format_value($student['course_yr']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Civil Status:</p>
                                        <p class="font-medium"><?php echo format_value($student['civil_status']); ?></p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Gender:</p>
                                        <p class="font-medium"><?php echo format_value(ucfirst($student['gender'])); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Date of Birth:</p>
                                        <p class="font-medium"><?php echo format_date($student['date_of_birth']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Place of Birth:</p>
                                        <p class="font-medium"><?php echo format_value($student['place_of_birth']); ?></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-sm text-gray-600">Address:</p>
                                    <p class="font-medium"><?php echo format_value($student['address']); ?></p>
                                </div>

                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Residence Type:</p>
                                        <p class="font-medium"><?php echo format_value($student['residence_type']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Guardian Name:</p>
                                        <p class="font-medium"><?php echo format_value($student['guardian_name']); ?></p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Telephone:</p>
                                        <p class="font-medium"><?php echo format_value($student['telephone']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Mobile:</p>
                                        <p class="font-medium"><?php echo format_value($student['mobile']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email:</p>
                                        <p class="font-medium"><?php echo format_value($student['email']); ?></p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Religion:</p>
                                        <p class="font-medium"><?php echo format_value($student['religion']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Existing Scholarship:</p>
                                        <p class="font-medium"><?php echo format_value($student['existing_scholarship']); ?></p>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-600">PWD Status:</p>
                                        <p class="font-medium"><?php echo format_value($student['is_pwd']); ?></p>
                                    </div>
                                    <?php if ($student['is_pwd'] == 'Yes'): ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Disability Type:</p>
                                        <p class="font-medium"><?php echo format_value($student['disability_type']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-span-1 flex justify-center">
                                <?php if (!empty($student['photo'])): ?>
                                <div class="border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                                    <img src="<?php echo '../' . $student['photo']; ?>" alt="Student Photo" class="h-48 w-full object-cover">
                                </div>
                                <?php else: ?>
                                <div class="bg-gray-200 border border-gray-300 rounded-lg flex items-center justify-center h-48 w-36">
                                    <span class="text-gray-500">No photo available</span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- FAMILY BACKGROUND -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">FAMILY BACKGROUND</h2>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Status of Parents:</p>
                            <p class="font-medium"><?php echo format_value($student['parent_status']); ?></p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Father Information -->
                            <div>
                                <h3 class="font-semibold text-green-700 mb-3">Father's Information</h3>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Name:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_name']); ?></p>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Age:</p>
                                            <p class="font-medium"><?php echo format_value($student['father_age']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Occupation:</p>
                                            <p class="font-medium"><?php echo format_value($student['father_occupation']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Address:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_address']); ?></p>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Telephone:</p>
                                            <p class="font-medium"><?php echo format_value($student['father_tel']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Mobile:</p>
                                            <p class="font-medium"><?php echo format_value($student['father_mobile']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_email']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Company:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_company']); ?></p>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Monthly Income:</p>
                                            <p class="font-medium"><?php echo format_money($student['father_income']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Years in Service:</p>
                                            <p class="font-medium"><?php echo format_value($student['father_years_service']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Educational Attainment:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_education']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">School:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_school']); ?></p>
                                    </div>
                                    <?php if (!empty($student['father_unemployment_reason'])): ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Reason for Unemployment:</p>
                                        <p class="font-medium"><?php echo format_value($student['father_unemployment_reason']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Mother Information -->
                            <div>
                                <h3 class="font-semibold text-green-700 mb-3">Mother's Information</h3>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Name:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_name']); ?></p>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Age:</p>
                                            <p class="font-medium"><?php echo format_value($student['mother_age']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Occupation:</p>
                                            <p class="font-medium"><?php echo format_value($student['mother_occupation']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Address:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_address']); ?></p>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Telephone:</p>
                                            <p class="font-medium"><?php echo format_value($student['mother_tel']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Mobile:</p>
                                            <p class="font-medium"><?php echo format_value($student['mother_mobile']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Email:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_email']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Company:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_company']); ?></p>
                                    </div>
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Monthly Income:</p>
                                            <p class="font-medium"><?php echo format_money($student['mother_income']); ?></p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Years in Service:</p>
                                            <p class="font-medium"><?php echo format_value($student['mother_years_service']); ?></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Educational Attainment:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_education']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">School:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_school']); ?></p>
                                    </div>
                                    <?php if (!empty($student['mother_unemployment_reason'])): ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Reason for Unemployment:</p>
                                        <p class="font-medium"><?php echo format_value($student['mother_unemployment_reason']); ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Siblings Information -->
                        <div class="mb-4">
                            <h3 class="font-semibold text-green-700 mb-3">Siblings Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Working Siblings:</p>
                                    <p class="font-medium"><?php echo format_value($student['working_siblings']); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Studying Siblings:</p>
                                    <p class="font-medium"><?php echo format_value($student['studying_siblings']); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Siblings:</p>
                                    <p class="font-medium"><?php echo format_value($student['total_siblings']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAMILY FINANCES -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">FAMILY FINANCES</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Family Expenses -->
                            <div>
                                <h3 class="font-semibold text-green-700 mb-3">Monthly Expenses</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <tbody class="divide-y divide-gray-200">
                                            <tr>
                                                <td class="py-1 text-gray-600">House Rental</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['house_rental']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Food & Grocery</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['food_grocery']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Car Loan</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['car_loan']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Other Loans</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['other_loan']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">School Bus</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['school_bus']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Transportation</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['transportation']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Education Plan</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['education_plan']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Insurance Policy</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['insurance_policy']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Health Insurance</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['health_insurance']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Utilities</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['utilities']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Communication</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['communication']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Helper Expenses (<?php echo format_value($student['helper_count']); ?>)</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['helper_expense']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Driver Expenses (<?php echo format_value($student['driver_count']); ?>)</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['driver_expense']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Medical Expenses</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['medicines'] + $student['doctors_fee'] + $student['hospitalization']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Recreation</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['recreation']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Other Monthly Expenses</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['other_monthly_expenses']); ?></td>
                                            </tr>
                                            <tr class="bg-gray-50">
                                                <td class="py-2 font-bold">Total Monthly Expenses</td>
                                                <td class="py-2 font-bold text-right"><?php echo format_money($student['total_monthly_expenses']); ?></td>
                                            </tr>
                                            <tr class="bg-gray-50">
                                                <td class="py-2 font-bold">Annual Monthly Expenses (x12)</td>
                                                <td class="py-2 font-bold text-right"><?php echo format_money($student['annual_monthly_expenses']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h3 class="font-semibold text-green-700 mb-3 mt-6">Annual Expenses</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <tbody class="divide-y divide-gray-200">
                                            <tr>
                                                <td class="py-1 text-gray-600">Tuition</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['tuition']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Withholding Tax</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['withholding_tax']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Government Contributions</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['govt_contributions']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Other Annual Expenses</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['other_annual_expenses']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 font-bold">Annual Expenses Subtotal</td>
                                                <td class="py-2 font-bold text-right"><?php echo format_money($student['annual_expenses_subtotal']); ?></td>
                                            </tr>
                                            <tr class="bg-gray-50">
                                                <td class="py-2 font-bold">Total Annual Expenses</td>
                                                <td class="py-2 font-bold text-right"><?php echo format_money($student['total_annual_expenses']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Family Income -->
                            <div>
                                <h3 class="font-semibold text-green-700 mb-3">Annual Income</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <tbody class="divide-y divide-gray-200">
                                            <tr>
                                                <td class="py-1 text-gray-600">Parents' Combined Annual Pay</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['parents_annual_pay']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Siblings' Combined Annual Pay</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['siblings_annual_pay']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Business Income</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['business_income']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Land Rental Income</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['land_rental_income']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Property Rental Income</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['property_rental_income']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Pension Income</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['pension_income']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Commission Income</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['commission_income']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Relative Support</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['relative_support']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Bank Deposits</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['bank_deposits']); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="py-1 text-gray-600">Other Income</td>
                                                <td class="py-1 font-medium text-right"><?php echo format_money($student['other_income']); ?></td>
                                            </tr>
                                            <tr class="bg-gray-50">
                                                <td class="py-2 font-bold">Total Annual Income</td>
                                                <td class="py-2 font-bold text-right"><?php echo format_money($student['total_annual_income']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Financial Summary -->
                                <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-200">
                                    <h3 class="font-semibold text-green-700 mb-3">Financial Summary</h3>
                                    
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span>Total Annual Income:</span>
                                            <span class="font-medium"><?php echo format_money($student['total_annual_income']); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Total Annual Expenses:</span>
                                            <span class="font-medium"><?php echo format_money($student['total_annual_expenses']); ?></span>
                                        </div>
                                        <?php 
                                        $net_income = $student['total_annual_income'] - $student['total_annual_expenses'];
                                        $class = $net_income >= 0 ? 'text-green-600' : 'text-red-600';
                                        ?>
                                        <div class="border-t border-gray-300 pt-2 flex justify-between">
                                            <span class="font-bold">Net Income (Income - Expenses):</span>
                                            <span class="font-bold <?php echo $class; ?>"><?php echo format_money($net_income); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EDUCATION BACKGROUND -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">EDUCATIONAL BACKGROUND</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div>
                                <p class="text-sm text-gray-600">Secondary School:</p>
                                <p class="font-medium"><?php echo format_value($student['secondary_school']); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">School Location:</p>
                                <p class="font-medium"><?php echo format_value($student['school_location']); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Year Graduated:</p>
                                <p class="font-medium"><?php echo format_value($student['year_graduated']); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">General Average:</p>
                                <p class="font-medium"><?php echo format_value($student['general_average']); ?></p>
                            </div>
                        </div>

                        <?php if (!empty($student['honors_awards'])): ?>
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Honors/Awards:</p>
                            <p class="font-medium"><?php echo format_value($student['honors_awards']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- REFERENCES -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">REFERENCES</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-green-700 mb-3">Reference 1</h3>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Name:</p>
                                        <p class="font-medium"><?php echo format_value($student['reference1_name']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Relationship:</p>
                                        <p class="font-medium"><?php echo format_value($student['reference1_relationship']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Contact Number:</p>
                                        <p class="font-medium"><?php echo format_value($student['reference1_contact']); ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="font-semibold text-green-700 mb-3">Reference 2</h3>
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-sm text-gray-600">Name:</p>
                                        <p class="font-medium"><?php echo format_value($student['reference2_name']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Relationship:</p>
                                        <p class="font-medium"><?php echo format_value($student['reference2_relationship']); ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Contact Number:</p>
                                        <p class="font-medium"><?php echo format_value($student['reference2_contact']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REQUIREMENTS -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">REQUIRED DOCUMENTS</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_photo'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_photo'] ? 'font-medium' : 'text-gray-500'; ?>">2x2 ID Picture</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_itr'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_itr'] ? 'font-medium' : 'text-gray-500'; ?>">Income Tax Return</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_ofw'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_ofw'] ? 'font-medium' : 'text-gray-500'; ?>">OFW Contract/Proof of Income</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_grades'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_grades'] ? 'font-medium' : 'text-gray-500'; ?>">SHS Report Card</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_moral'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_moral'] ? 'font-medium' : 'text-gray-500'; ?>">Certificate of Good Moral Character</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_letter'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_letter'] ? 'font-medium' : 'text-gray-500'; ?>">Letter of Intent</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-6 h-6 mr-2 <?php echo $student['req_schedule'] ? 'text-green-500' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="<?php echo $student['req_schedule'] ? 'font-medium' : 'text-gray-500'; ?>">Proposed Schedule of Duty (Student Assistantship)</span>
                            </div>
                        </div>
                    </div>

                    <!-- OFFICE USE SECTION -->
                    <div class="mb-8">
                        <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">FOR OFFICE USE ONLY</h2>
                        
                        <form method="post" action="" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Application Status</label>
                                    <div class="flex space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="Pending" <?php echo ($student['status'] == 'Pending') ? 'checked' : ''; ?> class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">Pending</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="Approved" <?php echo ($student['status'] == 'Approved') ? 'checked' : ''; ?> class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">Approved</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status" value="Rejected" <?php echo ($student['status'] == 'Rejected') ? 'checked' : ''; ?> class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                            <span class="ml-2 text-sm text-gray-700">Rejected</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Application Date</label>
                                    <p class="font-medium"><?php echo format_date($student['created_at']); ?></p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Received By</label>
                                    <input type="text" name="office_received" value="<?php echo htmlspecialchars($student['office_received']); ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Screened By</label>
                                    <input type="text" name="office_screened" value="<?php echo htmlspecialchars($student['office_screened'] ? $student['office_screened'] : $username); ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks/Comments</label>
                                <textarea name="office_remarks" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"><?php echo htmlspecialchars($student['office_remarks']); ?></textarea>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" name="update_status" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printApplication() {
    // Create a print-friendly version
    const printContents = document.querySelector('.max-w-7xl').innerHTML;
    const originalContents = document.body.innerHTML;
    
    // Add print-specific styles
    const printStyles = `
        <style>
            @media print {
                body { font-size: 12pt; }
                button, .sidebar, nav { display: none !important; }
                input, select, textarea { border: 1px solid #ccc !important; }
                .shadow-lg, .shadow-md { box-shadow: none !important; }
                .bg-green-700 { background-color: #15803d !important; color: white !important; }
                .bg-green-100 { background-color: #dcfce7 !important; }
                @page { margin: 0.5cm; }
            }
        </style>
    `;
    
    document.body.innerHTML = printStyles + printContents;
    window.print();
    document.body.innerHTML = originalContents;
    
    // Reload the page to restore functionality after printing
    window.addEventListener('afterprint', function() {
        location.reload();
    });
}
</script>

<?php include '../components/footer.php'; ?>