<?php
// save_user.php - Save user registration data to a file

header('Content-Type: application/json');

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

$name = isset($data['name']) ? sanitize($data['name']) : '';
$role = isset($data['role']) ? sanitize($data['role']) : '';
$profession = isset($data['profession']) ? sanitize($data['profession']) : '';
$location = isset($data['location']) ? sanitize($data['location']) : '';

if ($name === '' || $role === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Create a filename and timestamp
$timestamp = date('Y-m-d H:i:s');
$filename = 'users_data.txt';

// Prepare the data line with optional fields
$parts = [];
$parts[] = "Name: $name";
$parts[] = "Role: $role";
if ($profession !== '') { $parts[] = "Profession: $profession"; }
if ($location !== '') { $parts[] = "Location: $location"; }
$parts[] = "Timestamp: $timestamp";
$dataLine = implode(' | ', $parts) . "\n";

// Append to file (create if doesn't exist)
if (file_put_contents($filename, $dataLine, FILE_APPEND | LOCK_EX) !== false) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'User data saved successfully']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save user data']);
}

// Sanitize input
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>
