<?php
include 'components/header.php'; 
include 'components/conn.php';

// Add this debugging code to check if table exists
$check_table = "SHOW TABLES LIKE 'students'";
$table_result = mysqli_query($conn, $check_table);
if(mysqli_num_rows($table_result) == 0) {
    echo "<script>alert('Error: students table does not exist!');</script>";
}

// Check table structure
$describe_table = "DESCRIBE students";
$structure_result = mysqli_query($conn, $describe_table);
if(!$structure_result) {
    echo "<script>alert('Error checking table structure: " . mysqli_error($conn) . "');</script>";
}

// Detect if running locally or online
$is_localhost = in_array($_SERVER['SERVER_ADDR'], ['127.0.0.1', '::1', '192.168.101.78']) || 
                strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;

// Always allow access regardless of network when online
$server_ip = "192.168.101.78"; // Keep for backward compatibility
$client_ip = $_SERVER['REMOTE_ADDR'];

function isOnSameNetwork($client_ip, $server_ip) {
    // Extract IP parts and convert to subnet
    $client_parts = explode('.', $client_ip);
    $server_parts = explode('.', $server_ip);
    
    // Check if both are on same Class C subnet (first 3 octets match)
    return ($client_parts[0] == $server_parts[0] && 
            $client_parts[1] == $server_parts[1] && 
            $client_parts[2] == $server_parts[2]);
}

// Only check network restrictions if we're running locally
$same_network = false;
$allowed_access = true; // Default to allowed access for online deployment
$show_warning = false;

if ($is_localhost) {
    // Local environment - check network
    $same_network = isOnSameNetwork($client_ip, $server_ip);
    
    // If IP is localhost/127.0.0.1, it's a direct server access (development mode)
    // OR if they're on the same network subnet
    $allowed_access = ($client_ip == "127.0.0.1" || $client_ip == "::1" || $same_network);
    
    // If access is not allowed, show warning
    if (!$allowed_access) {
        $show_warning = true;
    }
} else {
    // When online, always allow access
    $allowed_access = true;
    $show_warning = false;
}

// Rest of your existing code
// Check if form is submitted and process the form data
if(isset($_POST['submit_application'])) {
    // Debug: Check if we're actually reaching this code
    error_log("Application submission started");
    
    // Process photo upload
    $photo_name = "";
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $upload_dir = "uploads/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $photo_name = uniqid() . '_' . basename($_FILES['photo']['name']);
        $target_path = $upload_dir . $photo_name;
        
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
            $photo_name = $target_path;
        }
    }
    
    // Get form data - Page 1
    // Personal data
    $scholarship_type = isset($_POST['scholarship_type']) ? $_POST['scholarship_type'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $middle_name = isset($_POST['middle_name']) ? $_POST['middle_name'] : '';
    $course_yr = isset($_POST['course_yr']) ? $_POST['course_yr'] : '';
    $civil_status = isset($_POST['civil_status']) ? $_POST['civil_status'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $date_of_birth = isset($_POST['dob']) ? $_POST['dob'] : '';
    $place_of_birth = isset($_POST['pob']) ? $_POST['pob'] : '';
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $residence_type = isset($_POST['residence']) ? $_POST['residence'] : '';
    $guardian_name = isset($_POST['guardian_name']) ? $_POST['guardian_name'] : '';
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
    $religion = isset($_POST['religion']) ? $_POST['religion'] : '';
    $existing_scholarship = isset($_POST['existing_scholarship']) ? $_POST['existing_scholarship'] : '';
    $mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $is_pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
    $disability_type = isset($_POST['disability_type']) ? $_POST['disability_type'] : '';
    
    // Family background
    $parent_status = isset($_POST['parent_status']) ? $_POST['parent_status'] : '';
    
    // Father details
    $father_name = isset($_POST['father_name']) ? $_POST['father_name'] : '';
    $father_age = isset($_POST['father_age']) ? $_POST['father_age'] : '';
    $father_address = isset($_POST['father_address']) ? $_POST['father_address'] : '';
    $father_tel = isset($_POST['father_tel']) ? $_POST['father_tel'] : '';
    $father_mobile = isset($_POST['father_mobile']) ? $_POST['father_mobile'] : '';
    $father_email = isset($_POST['father_email']) ? $_POST['father_email'] : '';
    $father_occupation = isset($_POST['father_occupation']) ? $_POST['father_occupation'] : '';
    $father_company = isset($_POST['father_company']) ? $_POST['father_company'] : '';
    $father_income = isset($_POST['father_income']) ? $_POST['father_income'] : '';
    $father_years_service = isset($_POST['father_years']) ? $_POST['father_years'] : '';
    $father_education = isset($_POST['father_education']) ? $_POST['father_education'] : '';
    $father_school = isset($_POST['father_school']) ? $_POST['father_school'] : '';
    $father_unemployment_reason = isset($_POST['father_unemployment']) ? $_POST['father_unemployment'] : '';
    
    // Mother details
    $mother_name = isset($_POST['mother_name']) ? $_POST['mother_name'] : '';
    $mother_age = isset($_POST['mother_age']) ? $_POST['mother_age'] : '';
    $mother_address = isset($_POST['mother_address']) ? $_POST['mother_address'] : '';
    $mother_tel = isset($_POST['mother_tel']) ? $_POST['mother_tel'] : '';
    $mother_mobile = isset($_POST['mother_mobile']) ? $_POST['mother_mobile'] : '';
    $mother_email = isset($_POST['mother_email']) ? $_POST['mother_email'] : '';
    $mother_occupation = isset($_POST['mother_occupation']) ? $_POST['mother_occupation'] : '';
    $mother_company = isset($_POST['mother_company']) ? $_POST['mother_company'] : '';
    $mother_income = isset($_POST['mother_income']) ? $_POST['mother_income'] : '';
    $mother_years_service = isset($_POST['mother_years']) ? $_POST['mother_years'] : '';
    $mother_education = isset($_POST['mother_education']) ? $_POST['mother_education'] : '';
    $mother_school = isset($_POST['mother_school']) ? $_POST['mother_school'] : '';
    $mother_unemployment_reason = isset($_POST['mother_unemployment']) ? $_POST['mother_unemployment'] : '';
    
    // Siblings
    $working_siblings = isset($_POST['working_siblings']) ? $_POST['working_siblings'] : '';
    $studying_siblings = isset($_POST['studying_siblings']) ? $_POST['studying_siblings'] : '';
    $total_siblings = isset($_POST['total_siblings']) ? $_POST['total_siblings'] : '';
    
    // Get form data - Page 2
    // Family expenses (monthly)
    $house_rental = isset($_POST['house_rental']) ? $_POST['house_rental'] : 0;
    $food_grocery = isset($_POST['food_grocery']) ? $_POST['food_grocery'] : 0;
    $car_loan = isset($_POST['car_loan']) ? $_POST['car_loan'] : 0;
    $other_loan = isset($_POST['other_loan']) ? $_POST['other_loan'] : 0;
    $school_bus = isset($_POST['school_bus']) ? $_POST['school_bus'] : 0;
    $transportation = isset($_POST['transportation']) ? $_POST['transportation'] : 0;
    $education_plan = isset($_POST['education_plan']) ? $_POST['education_plan'] : 0;
    $insurance_policy = isset($_POST['insurance_policy']) ? $_POST['insurance_policy'] : 0;
    $health_insurance = isset($_POST['health_insurance']) ? $_POST['health_insurance'] : 0;
    $govt_loans = isset($_POST['govt_loans']) ? $_POST['govt_loans'] : 0;
    $clothing = isset($_POST['clothing']) ? $_POST['clothing'] : 0;
    $utilities = isset($_POST['utilities']) ? $_POST['utilities'] : 0;
    $communication = isset($_POST['communication']) ? $_POST['communication'] : 0;
    $helper_count = isset($_POST['helper_count']) ? $_POST['helper_count'] : 0;
    $helper_expense = isset($_POST['helper_expense']) ? $_POST['helper_expense'] : 0;
    $driver_count = isset($_POST['driver_count']) ? $_POST['driver_count'] : 0;
    $driver_expense = isset($_POST['driver_expense']) ? $_POST['driver_expense'] : 0;
    $medicines = isset($_POST['medicines']) ? $_POST['medicines'] : 0;
    $doctors_fee = isset($_POST['doctors_fee']) ? $_POST['doctors_fee'] : 0;
    $hospitalization = isset($_POST['hospitalization']) ? $_POST['hospitalization'] : 0;
    $recreation = isset($_POST['recreation']) ? $_POST['recreation'] : 0;
    $other_monthly_expenses = isset($_POST['other_monthly_expenses']) ? $_POST['other_monthly_expenses'] : 0;
    $total_monthly_expenses = isset($_POST['total_monthly_expenses']) ? $_POST['total_monthly_expenses'] : 0;
    $annual_monthly_expenses = isset($_POST['annual_monthly_expenses']) ? $_POST['annual_monthly_expenses'] : 0;
    
    // Family expenses (annually)
    $tuition = isset($_POST['tuition']) ? $_POST['tuition'] : 0;
    $withholding_tax = isset($_POST['withholding_tax']) ? $_POST['withholding_tax'] : 0;
    $govt_contributions = isset($_POST['govt_contributions']) ? $_POST['govt_contributions'] : 0;
    $other_annual_expenses = isset($_POST['other_annual_expenses']) ? $_POST['other_annual_expenses'] : 0;
    $annual_expenses_subtotal = isset($_POST['annual_expenses_subtotal']) ? $_POST['annual_expenses_subtotal'] : 0;
    $total_annual_expenses = isset($_POST['total_annual_expenses']) ? $_POST['total_annual_expenses'] : 0;
    
    // Family income
    $parents_annual_pay = isset($_POST['parents_annual_pay']) ? $_POST['parents_annual_pay'] : 0;
    $siblings_annual_pay = isset($_POST['siblings_annual_pay']) ? $_POST['siblings_annual_pay'] : 0;
    $business_income = isset($_POST['business_income']) ? $_POST['business_income'] : 0;
    $land_rental_income = isset($_POST['land_rental_income']) ? $_POST['land_rental_income'] : 0;
    $property_rental_income = isset($_POST['property_rental_income']) ? $_POST['property_rental_income'] : 0;
    $pension_income = isset($_POST['pension_income']) ? $_POST['pension_income'] : 0;
    $commission_income = isset($_POST['commission_income']) ? $_POST['commission_income'] : 0;
    $relative_support = isset($_POST['relative_support']) ? $_POST['relative_support'] : 0;
    $bank_deposits = isset($_POST['bank_deposits']) ? $_POST['bank_deposits'] : 0;
    $other_income = isset($_POST['other_income']) ? $_POST['other_income'] : 0;
    $total_annual_income = isset($_POST['total_annual_income']) ? $_POST['total_annual_income'] : 0;
    
    // Secondary education data
    $secondary_school = isset($_POST['secondary_school']) ? $_POST['secondary_school'] : '';
    $school_location = isset($_POST['school_location']) ? $_POST['school_location'] : '';
    $year_graduated = isset($_POST['year_graduated']) ? $_POST['year_graduated'] : '';
    $general_average = isset($_POST['general_average']) ? $_POST['general_average'] : '';
    $honors_awards = isset($_POST['honors_awards']) ? $_POST['honors_awards'] : '';
    
    // Reference data
    $reference1_name = isset($_POST['reference1_name']) ? $_POST['reference1_name'] : '';
    $reference1_relationship = isset($_POST['reference1_relationship']) ? $_POST['reference1_relationship'] : '';
    $reference1_contact = isset($_POST['reference1_contact']) ? $_POST['reference1_contact'] : '';
    $reference2_name = isset($_POST['reference2_name']) ? $_POST['reference2_name'] : '';
    $reference2_relationship = isset($_POST['reference2_relationship']) ? $_POST['reference2_relationship'] : '';
    $reference2_contact = isset($_POST['reference2_contact']) ? $_POST['reference2_contact'] : '';
    
    // Requirements checkboxes
    $req_photo = isset($_POST['req_photo']) ? 1 : 0;
    $req_itr = isset($_POST['req_itr']) ? 1 : 0;
    $req_ofw = isset($_POST['req_ofw']) ? 1 : 0;
    $req_grades = isset($_POST['req_grades']) ? 1 : 0;
    $req_moral = isset($_POST['req_moral']) ? 1 : 0;
    $req_letter = isset($_POST['req_letter']) ? 1 : 0;
    $req_schedule = isset($_POST['req_schedule']) ? 1 : 0;
    
    // Office use data
    $office_received = isset($_POST['office_received']) ? $_POST['office_received'] : '';
    $office_screened = isset($_POST['office_screened']) ? $_POST['office_screened'] : '';
    $office_remarks = isset($_POST['office_remarks']) ? $_POST['office_remarks'] : '';
    
    // Create SQL query to insert all data
    
    // Create associative array with all form data
    $formData = [
        'scholarship_type' => $scholarship_type,
        'last_name' => $last_name,
        'first_name' => $first_name,
        'middle_name' => $middle_name,
        'course_yr' => $course_yr,
        'civil_status' => $civil_status,
        'photo' => $photo_name,
        'gender' => $gender,
        'date_of_birth' => $date_of_birth,
        'place_of_birth' => $place_of_birth,
        'student_id' => $student_id,
        'address' => $address,
        'residence_type' => $residence_type,
        'guardian_name' => $guardian_name,
        'telephone' => $telephone,
        'religion' => $religion,
        'existing_scholarship' => $existing_scholarship,
        'mobile' => $mobile,
        'email' => $email,
        'is_pwd' => $is_pwd,
        'disability_type' => $disability_type,
        'parent_status' => $parent_status,
        'father_name' => $father_name,
        'father_age' => $father_age,
        'father_address' => $father_address,
        'father_tel' => $father_tel,
        'father_mobile' => $father_mobile,
        'father_email' => $father_email,
        'father_occupation' => $father_occupation,
        'father_company' => $father_company,
        'father_income' => $father_income,
        'father_years_service' => $father_years_service,
        'father_education' => $father_education,
        'father_school' => $father_school,
        'father_unemployment_reason' => $father_unemployment_reason,
        'mother_name' => $mother_name,
        'mother_age' => $mother_age,
        'mother_address' => $mother_address,
        'mother_tel' => $mother_tel,
        'mother_mobile' => $mother_mobile,
        'mother_email' => $mother_email,
        'mother_occupation' => $mother_occupation,
        'mother_company' => $mother_company,
        'mother_income' => $mother_income,
        'mother_years_service' => $mother_years_service,
        'mother_education' => $mother_education,
        'mother_school' => $mother_school,
        'mother_unemployment_reason' => $mother_unemployment_reason,
        'working_siblings' => $working_siblings,
        'studying_siblings' => $studying_siblings,
        'total_siblings' => $total_siblings,
        'house_rental' => $house_rental,
        'food_grocery' => $food_grocery,
        'car_loan' => $car_loan,
        'other_loan' => $other_loan,
        'school_bus' => $school_bus,
        'transportation' => $transportation,
        'education_plan' => $education_plan,
        'insurance_policy' => $insurance_policy,
        'health_insurance' => $health_insurance,
        'govt_loans' => $govt_loans,
        'clothing' => $clothing,
        'utilities' => $utilities,
        'communication' => $communication,
        'helper_count' => $helper_count,
        'helper_expense' => $helper_expense,
        'driver_count' => $driver_count,
        'driver_expense' => $driver_expense,
        'medicines' => $medicines,
        'doctors_fee' => $doctors_fee,
        'hospitalization' => $hospitalization,
        'recreation' => $recreation,
        'other_monthly_expenses' => $other_monthly_expenses,
        'total_monthly_expenses' => $total_monthly_expenses,
        'annual_monthly_expenses' => $annual_monthly_expenses,
        'tuition' => $tuition,
        'withholding_tax' => $withholding_tax,
        'govt_contributions' => $govt_contributions,
        'other_annual_expenses' => $other_annual_expenses,
        'annual_expenses_subtotal' => $annual_expenses_subtotal,
        'total_annual_expenses' => $total_annual_expenses,
        'parents_annual_pay' => $parents_annual_pay,
        'siblings_annual_pay' => $siblings_annual_pay,
        'business_income' => $business_income,
        'land_rental_income' => $land_rental_income,
        'property_rental_income' => $property_rental_income,
        'pension_income' => $pension_income,
        'commission_income' => $commission_income,
        'relative_support' => $relative_support,
        'bank_deposits' => $bank_deposits,
        'other_income' => $other_income,
        'total_annual_income' => $total_annual_income,
        'secondary_school' => $secondary_school,
        'school_location' => $school_location,
        'year_graduated' => $year_graduated,
        'general_average' => $general_average,
        'honors_awards' => $honors_awards,
        'reference1_name' => $reference1_name,
        'reference1_relationship' => $reference1_relationship,
        'reference1_contact' => $reference1_contact,
        'reference2_name' => $reference2_name,
        'reference2_relationship' => $reference2_relationship,
        'reference2_contact' => $reference2_contact,
        'req_photo' => $req_photo,
        'req_itr' => $req_itr,
        'req_ofw' => $req_ofw,
        'req_grades' => $req_grades,
        'req_moral' => $req_moral,
        'req_letter' => $req_letter,
        'req_schedule' => $req_schedule,
        'office_received' => $office_received,
        'office_screened' => $office_screened,
        'office_remarks' => $office_remarks,
        'status' => 'Pending'
    ];
    
    // Debug: Log the form data
    error_log("Form data collected: " . print_r($formData, true));
    
    // Build column names and placeholders
    $columns = implode(", ", array_keys($formData));
    $placeholders = implode(", ", array_fill(0, count($formData), "?"));
    
    // Create SQL statement
    $sql = "INSERT INTO students ($columns) VALUES ($placeholders)";
    
    // Debug: Log the SQL
    error_log("SQL Query: " . $sql);
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo "<script>alert('Database prepare error: " . $conn->error . "');</script>";
        exit();
    }
    
    // Get values array
    $values = array_values($formData);
    
    // Create types string - simplified approach
    $types = str_repeat('s', count($values)); // Use 's' for all values
    
    // Debug: Log values and types
    error_log("Values: " . print_r($values, true));
    error_log("Types: " . $types);
    
    // Bind parameters
    $stmt->bind_param($types, ...$values);
    
    // Execute
    if($stmt->execute()) {
        error_log("Application submitted successfully. Insert ID: " . $conn->insert_id);
        
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Application submitted successfully! ID: " . $conn->insert_id . "',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = 'stufeed.php';
                });
            });
        </script>";
        exit();
    } else {
        error_log("Execute failed: " . $stmt->error);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error submitting application: " . addslashes($stmt->error) . "',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#dc2626'
                });
            });
        </script>";
    }
    
    $stmt->close();
}
?>

<div class="container mx-auto py-6 px-4 max-w-5xl">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
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
            <p class="text-sm italic text-gray-700"><strong>DATA PRIVACY CLAUSE:</strong> By completing this form, I hereby agree that Mindoro State University, may collect, use, disclose, and process my personal data for the purposes of application for education, scholarships or enrollment. Requests for inspection, amendment, or restriction of records must be in writing and addressed to the Office of Student Affairs and Services and must specify the reasons for the request. Mindoro State University reserves the right to respond appropriately according to law.</p>        </div>

        <?php if ($show_warning): ?>
        <div class="m-6 p-4 bg-red-100 border-l-4 border-red-500 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-lg font-medium text-red-800">Network Access Restriction</p>
                    <p class="text-red-700 mt-1">You must be connected to the same network as the server (<?php echo $server_ip; ?>) to access this form.</p>
                    <p class="text-red-600 mt-2">Your IP address: <?php echo $client_ip; ?></p>
                    <p class="text-red-700 mt-2">Please connect to the designated network and try again.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <form class="p-6" method="post" enctype="multipart/form-data" <?php echo $show_warning ? 'onsubmit="return false;"' : ''; ?>>
            <!-- Tab Navigation -->
            
            <?php if ($show_warning): ?>
            <input type="hidden" id="network-warning-exists" value="1">
            <?php endif; ?>
            <div class="mb-6">
                <div class="flex border-b border-gray-200">
                    <button type="button" class="py-2 px-4 text-center border-b-2 border-green-500 font-medium text-sm text-green-600 bg-white tab-btn active" onclick="showTab('personal-tab')">
                        Personal & Family
                    </button>
                    <button type="button" class="py-2 px-4 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 tab-btn" onclick="showTab('financial-tab')">
                        Financial Assistantship
                    </button>
                    <button type="button" class="py-2 px-4 text-center border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 tab-btn" onclick="showTab('education-tab')">
                        Student Assistantship Program
                    </button>
                </div>
            </div>

            <!-- Tab Content 1: Personal and Family Information -->
            <div id="personal-tab" class="tab-content">
                <!-- Scholarship Type Selection -->
                <div class="mb-6 flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <input type="radio" id="financial" name="scholarship_type" value="Financial Assistantship Program" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <label for="financial" class="ml-2 block text-sm font-medium text-gray-700">Financial Assistantship</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="student_assist" name="scholarship_type" value="Student Assistantship Program" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <label for="student_assist" class="ml-2 block text-sm font-medium text-gray-700">Student Assistantship Program</label>
                    </div>
                </div>

                <div class="border-b-2 border-gray-300 mb-6"></div>
                
                <!-- General Instructions -->
                <div class="mb-6">
                    <p class="font-medium text-gray-800">General Instructions: Please print in black or blue ink or type all information requested</p>
                </div>

                <!-- PERSONAL DATA -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">PERSONAL DATA</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="col-span-3">
                            <!-- Name Section -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Name: (Please use legal name based on Birth or Marriage Certificate)</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="text" name="last_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <span class="text-xs text-gray-500">LAST</span>
                                    </div>
                                    <div>
                                        <input type="text" name="first_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <span class="text-xs text-gray-500">FIRST</span>
                                    </div>
                                    <div>
                                        <input type="text" name="middle_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        <span class="text-xs text-gray-500">MIDDLE</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Course and Civil Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="course_yr" class="block text-gray-700 mb-1">Course Yr:</label>
                                    <input type="text" id="course_yr" name="course_yr" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                                <div>
                                    <label for="civil_status" class="block text-gray-700 mb-1">Civil Status:</label>
                                    <input type="text" id="civil_status" name="civil_status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Photo Upload Section -->
                        <div class="md:col-span-1 flex flex-col items-center">
                            <div class="w-full border border-gray-300 rounded-lg overflow-hidden bg-gray-50 mb-2">
                                <div class="aspect-w-3 aspect-h-4 w-full">
                                    <img id="photo-preview" src="https://via.placeholder.com/150?text=2x2+Photo" alt="Student Photo" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <label for="photo-upload" class="w-full cursor-pointer bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md transition">
                                Upload 2x2 Photo
                                <input type="file" id="photo-upload" name="photo" class="hidden" accept="image/*" onchange="previewPhoto(this)">
                            </label>
                            <p class="text-xs text-gray-500 mt-1 text-center">2x2 recent colored photo with white background</p>
                        </div>
                    </div>

                    <!-- Sex, DOB, POB, Student ID -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Sex:</label>
                            <div class="flex space-x-4">
                                <div class="flex items-center">
                                    <input type="radio" id="male" name="gender" value="male" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <label for="male" class="ml-2 block text-sm font-medium text-gray-700">Male</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="female" name="gender" value="female" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                    <label for="female" class="ml-2 block text-sm font-medium text-gray-700">Female</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="dob" class="block text-gray-700 mb-1">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="MM/DD/YYYY">
                        </div>
                        <div>
                            <label for="pob" class="block text-gray-700 mb-1">Place of Birth:</label>
                            <input type="text" id="pob" name="pob" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="student_id" class="block text-gray-700 mb-1">Student ID Number:</label>
                            <input type="text" id="student_id" name="student_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 mb-1">Address: (No./St/Subd./Brgy/City/Country)</label>
                        <input type="text" id="address" name="address" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                    </div>

                    <!-- Residence Type -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Residing at:</label>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <input type="radio" id="boarding" name="residence" value="boarding" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="boarding" class="ml-2 block text-sm font-medium text-gray-700">Boarding House</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="parents" name="residence" value="parents" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="parents" class="ml-2 block text-sm font-medium text-gray-700">Parent's House</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="guardian" name="residence" value="guardian" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="guardian" class="ml-2 block text-sm font-medium text-gray-700">With Guardian:</label>
                                <input type="text" name="guardian_name" class="ml-2 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 w-40">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="telephone" class="block text-gray-700 mb-1">Telephone No.:</label>
                            <input type="text" id="telephone" name="telephone" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="religion" class="block text-gray-700 mb-1">Religion:</label>
                            <input type="text" id="religion" name="religion" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="existing_scholarship" class="block text-gray-700 mb-1">Existing Scholarship/s (If any):</label>
                            <input type="text" id="existing_scholarship" name="existing_scholarship" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- More Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="mobile" class="block text-gray-700 mb-1">Mobile No.:</label>
                            <input type="text" id="mobile" name="mobile" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 mb-1">E-mail Address: (please write legibly)</label>
                            <input type="email" id="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- PWD Status -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Person with Disability (PWD):</label>
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <input type="radio" id="pwd_yes" name="pwd" value="yes" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="pwd_yes" class="ml-2 block text-sm font-medium text-gray-700">Yes</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="pwd_no" name="pwd" value="no" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="pwd_no" class="ml-2 block text-sm font-medium text-gray-700">No</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <label for="disability_type" class="block text-gray-700 mb-1">If Yes, type of disability:</label>
                            <input type="text" id="disability_type" name="disability_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>

                <!-- FAMILY BACKGROUND -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">FAMILY BACKGROUND</h2>
                    
                    <!-- Parents status -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Status of Parents:</label>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <input type="radio" id="living_together" name="parent_status" value="living_together" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="living_together" class="ml-2 block text-sm font-medium text-gray-700">Living Together</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="separated" name="parent_status" value="separated" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="separated" class="ml-2 block text-sm font-medium text-gray-700">Separated</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="single_parent" name="parent_status" value="single_parent" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="single_parent" class="ml-2 block text-sm font-medium text-gray-700">Single Parent</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="father_deceased" name="parent_status" value="father_deceased" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="father_deceased" class="ml-2 block text-sm font-medium text-gray-700">Father Deceased</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="mother_deceased" name="parent_status" value="mother_deceased" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                <label for="mother_deceased" class="ml-2 block text-sm font-medium text-gray-700">Mother Deceased</label>
                            </div>
                        </div>
                    </div>

                    <!-- Parent Information Table -->
                    <div class="mb-6 overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100">RELATION</th>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100">FATHER</th>
                                    <th class="border border-gray-300 px-4 py-2 bg-gray-100">MOTHER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Name</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_name" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_name" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Age</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_age" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_age" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Permanent Home Address</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_address" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_address" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Tel. No.</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_tel" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_tel" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Mobile No.</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_mobile" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_mobile" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Email Address</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_email" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_email" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Occupation/Position</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_occupation" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_occupation" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Company</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_company" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_company" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Average Monthly Income</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_income" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_income" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Number of years in service</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_years" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_years" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Educational Attainment</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_education" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_education" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">School or College</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_school" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_school" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">Reason/s for being unemployed</td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="father_unemployment" class="w-full border-0 focus:ring-0"></td>
                                    <td class="border border-gray-300 px-2 py-2"><input type="text" name="mother_unemployment" class="w-full border-0 focus:ring-0"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Siblings Information -->
                    <div class="mb-4">
                        <h3 class="text-md font-bold text-gray-800 mb-2">BROTHERS AND SISTERS (Please attach additional sheet if necessary)</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Working Sibling/s</label>
                                <input type="number" name="working_siblings" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Number of Studying Sibling/s</label>
                                <input type="number" name="studying_siblings" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total Number of Sibling/s</label>
                                <input type="number" name="total_siblings" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Button -->
                <div class="flex justify-center">
                    <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg" onclick="showTab('financial-tab')">
                        Next Section
                        <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tab Content 2: Financial Information -->
            <div id="financial-tab" class="tab-content hidden">
                <!-- FAMILY EXPENSES AND INCOME -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">FAMILY EXPENSES AND INCOME</h2>
                    
                    <!-- Two-column layout for income and expenses -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left column: Family Expenses -->
                        <div>
                            <h3 class="font-bold text-gray-800 mb-3">FAMILY EXPENSES (Monthly)</h3>
                            
                            <!-- Monthly expenses table -->
                            <table class="w-full mb-6">
                                <tbody>
                                    <tr>
                                        <td class="py-2 pr-4">House Rental</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="house_rental" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Food & Grocery</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="food_grocery" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Car Loan Amortization (specify)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="car_loan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Other Loan Amortization (specify)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="other_loan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">School Bus Payment</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="school_bus" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Transportation/Gasoline & School Bus</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="transportation" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Education Plan Premiums</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="education_plan" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Insurance Policy Premiums</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="insurance_policy" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Health Insurance Premium</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="health_insurance" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">SSS/GSIS/PAG-IBIG Loans</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="govt_loans" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">School/Office uniform/Clothing</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="clothing" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Electricity, Water, Cable, Cooking Gas</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="utilities" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Telephone/Cellphone</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="communication" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Helper/Yaya (how many?)</td>
                                        <td class="py-2">
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="number" name="helper_count" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Count">
                                                <div class="flex items-center">
                                                    <span class="mr-2">PhP</span>
                                                    <input type="text" name="helper_expense" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Driver (how many?)</td>
                                        <td class="py-2">
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="number" name="driver_count" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" placeholder="Count">
                                                <div class="flex items-center">
                                                    <span class="mr-2">PhP</span>
                                                    <input type="text" name="driver_expense" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Medicines</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="medicines" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Doctor's fee/Consultation</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="doctors_fee" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Hospitalization</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="hospitalization" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Recreation</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="recreation" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Others (specify)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="other_monthly_expenses" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="font-bold">
                                        <td class="py-2 pr-4">Total</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="total_monthly_expenses" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="font-bold">
                                        <td class="py-2 pr-4">Sub-total x 12 months</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="annual_monthly_expenses" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <h3 class="font-bold text-gray-800 mb-3 mt-6">FAMILY EXPENSES (Annually)</h3>
                            
                            <!-- Annual expenses table -->
                            <table class="w-full mb-6">
                                <tbody>
                                    <tr>
                                        <td class="py-2 pr-4">School and Tuition</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="tuition" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Withholding Tax</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="withholding_tax" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">SSS/GSIS/Pag-ibig Contribution</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="govt_contributions" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Others (specify)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="other_annual_expenses" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="font-bold">
                                        <td class="py-2 pr-4">Sub-total</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="annual_expenses_subtotal" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="font-bold bg-gray-100">
                                        <td class="py-2 pr-4">TOTAL ANNUAL EXPENSES</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="total_annual_expenses" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Right column: Family Income -->
                        <div>
                            <h3 class="font-bold text-gray-800 mb-3">FAMILY INCOME (Gross)</h3>
                            
                            <!-- Income table -->
                            <table class="w-full mb-6">
                                <tbody>
                                    <tr>
                                        <td class="py-2 pr-4">Combined Annual Pay (father, mother)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="parents_annual_pay" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Combined Annual Pay (brother, sister)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="siblings_annual_pay" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Income from Business</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="business_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Income from Land Rentals</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="land_rental_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Income from Res/Bldg Rentals/Lease</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="property_rental_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Retirement Benefits/Pension</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="pension_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Commissions</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="commission_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Support from Relative/s</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="relative_support" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Bank Deposits</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="bank_deposits" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-2 pr-4">Others (Specify)</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="other_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="font-bold bg-gray-100">
                                        <td class="py-2 pr-4">Total Annual Income</td>
                                        <td class="py-2">
                                            <div class="flex items-center">
                                                <span class="mr-2">PhP</span>
                                                <input type="text" name="total_annual_income" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Financial Support from Relatives -->
                            <div class="mb-6">
                                <p class="mb-2">Do you have other relative/s who help out in your finances?</p>
                                <div class="flex items-center space-x-4 mb-3">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="relative_assistance" value="yes" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="relative_assistance" value="no" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                                <div id="relative_assistance_details" class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Name/s:</label>
                                        <input type="text" name="relative_names" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Relation:</label>
                                        <input type="text" name="relative_relation" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount:</label>
                                        <div class="flex items-center">
                                            <span class="mr-2">PhP</span>
                                            <input type="text" name="relative_support_amount" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg" onclick="showTab('personal-tab')">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous Section
                    </button>
                    <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg" onclick="showTab('education-tab')">
                        Next Section
                        <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Tab Content 3: Education & References -->
            <div id="education-tab" class="tab-content hidden">
                <!-- EDUCATION-SECONDARY -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">EDUCATION-SECONDARY</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label for="secondary_school" class="block text-sm font-medium text-gray-700 mb-1">School</label>
                            <input type="text" id="secondary_school" name="secondary_school" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="school_location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" id="school_location" name="school_location" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="year_graduated" class="block text-sm font-medium text-gray-700 mb-1">Year Graduated</label>
                            <input type="text" id="year_graduated" name="year_graduated" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="general_average" class="block text-sm font-medium text-gray-700 mb-1">General Average</label>
                            <input type="text" id="general_average" name="general_average" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="honors_awards" class="block text-sm font-medium text-gray-700 mb-1">Honors/Awards Received</label>
                        <textarea id="honors_awards" name="honors_awards" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"></textarea>
                    </div>
                </div>

                <!-- References -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">REFERENCES</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="reference1_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Relationship to the Applicant</label>
                            <input type="text" name="reference1_relationship" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input type="text" name="reference1_contact" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="reference2_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Relationship to the Applicant</label>
                            <input type="text" name="reference2_relationship" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                            <input type="text" name="reference2_contact" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>

                <!-- Certification -->
                <div class="mb-8">
                    <div class="p-4 bg-gray-50 border rounded-lg">
                        <p class="mb-4">I hereby certify that the above information is true and correct. Any misrepresentation of facts will render this form invalid, and will immediately disqualify my application to this scholarship.</p>
                        <div class="flex flex-col items-center space-y-2 mt-4">
                            <div class="w-48 border-b border-black mb-2"></div>
                            <p>Signature over Printed name</p>
                        </div>
                    </div>
                </div>

                <!-- Other Requirements -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold text-green-800 mb-4 bg-green-100 p-2">OTHER REQUIREMENTS</h2>
                    
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_photo" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">One 2x2 ID Picture</label>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_itr" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">Latest Income Tax Return of Both Parents or Affidavit of Non-Filing Income Tax Return</label>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_ofw" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">If OFW, copy of contract or any proof of income</label>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_grades" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">First Year Applicant: Certified True Copy of latest SHS Report Card</label>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_moral" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">Certificate of Good Moral Character</label>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_letter" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">Letter of Intent</label>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" name="req_schedule" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label class="font-medium text-gray-700">For Student Assistantship: Proposed Schedule of Duty</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- For Office Use Only -->
                <div class="mb-8">
                    <div class="p-4 bg-gray-50 border rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-3">FOR OFFICE USE ONLY</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Received</label>
                                <input type="text" name="office_received" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Screened</label>
                                <input type="text" name="office_screened" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Action/Remarks</label>
                            <textarea name="office_remarks" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg" onclick="showTab('financial-tab')">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous Section
                    </button>
                    <button type="submit" name="submit_application" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg">
                        Submit Application
                        <svg class="w-5 h-5 inline ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Tab Navigation and Photo Preview -->
<script>
    // Function to show tab content
    function showTab(tabId) {
        // Hide all tab content
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(tab => tab.classList.add('hidden'));
        
        // Remove active class from all tab buttons
        const tabButtons = document.querySelectorAll('.tab-btn');
        tabButtons.forEach(button => {
            button.classList.remove('border-green-500', 'text-green-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show the selected tab content
        document.getElementById(tabId).classList.remove('hidden');
        
        // Add active class to selected tab button
        const activeButton = document.querySelector(`[onclick="showTab('${tabId}')"]`);
        activeButton.classList.remove('border-transparent', 'text-gray-500');
        activeButton.classList.add('border-green-500', 'text-green-600');
    }
    
    // Preview image when selected
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photo-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Calculate financial totals
    document.addEventListener('DOMContentLoaded', function() {
        // Set up relative_assistance toggle
        const relativeAssistance = document.querySelectorAll('input[name="relative_assistance"]');
        const relativeAssistanceDetails = document.getElementById('relative_assistance_details');
        
        if (relativeAssistance && relativeAssistanceDetails) {
            relativeAssistance.forEach(radio => {
                radio.addEventListener('change', function() {
                    relativeAssistanceDetails.style.display = this.value === 'yes' ? 'block' : 'none';
                });
            });
        }
        
        // Initialize state of relative assistance section
        if (relativeAssistanceDetails) {
            const selectedRadio = document.querySelector('input[name="relative_assistance"]:checked');
            if (selectedRadio && selectedRadio.value === 'no') {
                relativeAssistanceDetails.style.display = 'none';
            }
        }
    });
</script>

<?php include 'components/footer.php'; ?>