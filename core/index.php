<?php

// Define allowed methods
$allowed_methods = array("GET", "POST", "PUT", "DELETE");

// Get request method
$method = $_SERVER["REQUEST_METHOD"];
// Get uri method
$uri = $_SERVER["REQUEST_URI"];
$end_uri = explode("/", $uri);
$endpoint = $end_uri[2];
// print_r($end_uri[2]);

// Validate method
if(!in_array($method, $allowed_methods)){
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

// User data
// Read the contents of the JSON file
$json_file = file_get_contents("../user_data.json");

// Decode the JSON data into a PHP array
$users = json_decode($json_file, true);


// Initialize empty data array
$data = [];

// Handle each data
try{
switch($method){
    case "GET":
        // Process get request
        $data = $users;
}

http_response_code(200);
header("Content-Type: application/json");
echo json_encode($data);

// Define function to handle each method's logic
function handle_get_request(){
    global $endpoint;
    
    switch($endpoint){
        case "users":
            // Handle get users logic
            break;
        case "user":
            // Handle get user logic
            break;
        default:
            // Handle unknown endpoint
            http_response_code(404);
            $data = ["error" => "Endpoint not found"];
            break;

    }
    return $data;
}

}catch(Exception $e){
    http_response_code(500);
    echo json_encode(["error" => "Internal server error"]);
    exit;

};