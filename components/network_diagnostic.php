<?php
// network_diagnostic.php - Help diagnose network connectivity issues

header("Content-Type: application/json");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Get server information
$server_info = array(
    "server_software" => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    "server_name" => $_SERVER['SERVER_NAME'] ?? 'Unknown',
    "server_addr" => $_SERVER['SERVER_ADDR'] ?? 'Unknown',
    "server_port" => $_SERVER['SERVER_PORT'] ?? 'Unknown',
    "document_root" => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
    "http_host" => $_SERVER['HTTP_HOST'] ?? 'Unknown',
    "remote_addr" => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    "script_filename" => $_SERVER['SCRIPT_FILENAME'] ?? 'Unknown',
    "request_uri" => $_SERVER['REQUEST_URI'] ?? 'Unknown',
    "php_version" => PHP_VERSION,
    "timestamp" => time()
);

// Only use the specific IP address (192.168.101.78)
$server_ips = array("192.168.92.10");

// Check folder case sensitivity
$folder_exists = array(
    "iskonnect" => file_exists($_SERVER['DOCUMENT_ROOT'] . '/iskonnect'),
    "Iskonnect" => file_exists($_SERVER['DOCUMENT_ROOT'] . '/Iskonnect'),
    "ISKONNECT" => file_exists($_SERVER['DOCUMENT_ROOT'] . '/ISKONNECT')
);

// Get suggested URLs
$current_path = dirname($_SERVER['SCRIPT_NAME']);
$parent_path = dirname($current_path);
$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

$suggested_urls = array();
foreach ($server_ips as $ip) {
    $suggested_urls[] = "$scheme://$ip" . $parent_path . "/students.php";
}

if (isset($_SERVER['HTTP_HOST'])) {
    $suggested_urls[] = "$scheme://" . $_SERVER['HTTP_HOST'] . $parent_path . "/students.php";
}

// Response
$response = array(
    "status" => "ok",
    "message" => "Network diagnostic information",
    "server_info" => $server_info,
    "server_ips" => $server_ips,
    "folder_case_check" => $folder_exists,
    "suggested_urls" => $suggested_urls
);

echo json_encode($response, JSON_PRETTY_PRINT);
exit;
?>
