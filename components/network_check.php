<?php
// Simple file that returns HTTP 200 OK for network connectivity checks
// Used to verify that clients are on the same network as the server

// Set headers to prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Return a simple success response
header("HTTP/1.1 200 OK");
echo json_encode(["status" => "ok", "message" => "Network connection successful", "timestamp" => time()]);
exit;
?>
