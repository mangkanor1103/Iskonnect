<?php
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['role']);
}

// Function to check if user has specific role
function has_role($required_role) {
    if (!is_logged_in()) {
        return false;
    }
    
    if (is_array($required_role)) {
        return in_array($_SESSION['role'], $required_role);
    } else {
        return $_SESSION['role'] === $required_role;
    }
}

// Redirect to login page if not logged in
function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        // Store the current URL for redirection after login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        
        // Redirect to login page
        header("Location: " . get_base_url() . "index.php");
        exit();
    }
}

// Redirect if user doesn't have the required role
function redirect_if_not_authorized($required_role) {
    // First check if logged in
    if (!is_logged_in()) {
        redirect_if_not_logged_in();
    }
    
    // Then check role
    if (!has_role($required_role)) {
        // Redirect to appropriate dashboard based on current role
        $role = $_SESSION['role'];
        $redirect_path = get_dashboard_by_role($role);
        header("Location: " . get_base_url() . $redirect_path);
        exit();
    }
}

// Get dashboard path by role
function get_dashboard_by_role($role) {
    switch ($role) {
        case 'admin':
            return 'dashboard.php';
        case 'staff':
            return 'staff/dashboard.php';
        case 'ched':
            return 'ched/dashboard.php';
        default:
            return 'index.php';
    }
}

// Function to get the base URL
function get_base_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $folder = dirname($_SERVER['PHP_SELF']);
    $folder = $folder === '/' ? '' : $folder;
    $folder = $folder . '/';
    
    // Replace '/Iskonnect/' with '/' if it's the folder structure
    $folder = str_replace('/Iskonnect/', '/', $folder);
    
    return $protocol . $host . $folder;
}
?>