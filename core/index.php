<?php

// Define allowed methods
$allowed_methods = array("GET", "POST", "PUT", "DELETE");

// Get request method
$method = $_SERVER["REQUEST_METHOD"];
// Get uri method
$uri = $_SERVER["REQUEST_URI"];
$end_uri = explode("/", $uri);
$endpoint = $end_uri[2];
$param = $end_uri[3];
// print_r($end_uri[2]);

// Validate method
if (!in_array($method, $allowed_methods)) {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}


// Read the contents of the JSON file
$json_file = file_get_contents("../user_data.json");

// Decode the JSON data into a PHP array
$users = json_decode($json_file, true);

// Initialize empty data array
$data = [];

// Handle each data
try {


    function handle_get_request()
    {
        global $endpoint;
        global $users;
        global $param;

        switch ($endpoint) {
            case "users":
                if (!$param)
                    $data = $users;
                else
                    foreach ($users as $user) {
                        if ($user["id"] == $param) {
                            $data = $user;
                            break;
                        }
                    }
                break;

            default:
                // Handle unknown endpoint
                http_response_code(404);
                $data = ["error" => "Endpoint not found"];
                break;
        }
        return $data;
    }

    switch ($method) {
        case "GET":
            // Process get request
            $data = handle_get_request();
            break;
    }

    http_response_code(200);
    header("Content-Type: application/json");
    echo json_encode($data);

    // Define function to handle each method's logic

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal server error"]);
    exit;
};
