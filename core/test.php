<?php

// Define allowed methods
$allowed_methods = ['GET', 'POST', 'PUT', 'DELETE'];

// Get request method
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$endpoint = $parts[2];

// $port = 8080;
// $host = 'localhocst';

// Validate method
if (!in_array($method, $allowed_methods)) {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Initialize empty data array
$data = [];

// Handle each method
switch ($method) {
    case 'GET':
        // Process GET request
        $data = handle_get_request();
        break;
}

// Send response
http_response_code(200);
header('Content-Type: application/json');
echo json_encode($data);

// Define functions to handle each method's logic
function handle_get_request() {
    global $endpoint;
    // Get request parameters
    // $endpoint = $_GET['endpoint'] ?? null;

    // Implement logic based on endpoint and return data
    switch ($endpoint) {
        case 'user':
            // Get user data
            $data = ['username' => 'johndoe', 'email' => 'john@example.com'];
            break;
        default:
            // Handle unknown endpoint
            http_response_code(404);
            $data = ['error' => 'Endpoint not found'];
    }

    return $data;
}