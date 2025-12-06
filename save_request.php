<?php
// save_request.php - Save service request data to a file

header('Content-Type: application/json');

// Read JSON body
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

// Helper sanitize
function sanitize($s) {
    return htmlspecialchars(trim((string)$s), ENT_QUOTES, 'UTF-8');
}

$name = isset($data['name']) ? sanitize($data['name']) : '';
$jobTitle = isset($data['jobTitle']) ? sanitize($data['jobTitle']) : '';
$jobType = isset($data['jobType']) ? sanitize($data['jobType']) : '';
$description = isset($data['description']) ? sanitize($data['description']) : '';
$preferredDate = isset($data['preferredDate']) ? sanitize($data['preferredDate']) : '';
$preferredTime = isset($data['preferredTime']) ? sanitize($data['preferredTime']) : '';
$location = isset($data['location']) ? sanitize($data['location']) : '';
$cost = isset($data['cost']) ? sanitize($data['cost']) : '';

// Minimal validation
if ($jobTitle === '' || $jobType === '' || $description === '' || $preferredDate === '' || $preferredTime === '' || $location === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

$timestamp = date('Y-m-d H:i:s');
$filename = 'requests.txt';

$parts = [];
if ($name !== '') $parts[] = "Name: $name";
$parts[] = "Job Title: $jobTitle";
$parts[] = "Job Type: $jobType";
$parts[] = "Description: $description";
$parts[] = "Preferred Date: $preferredDate";
$parts[] = "Preferred Time: $preferredTime";
$parts[] = "Location: $location";
if ($cost !== '') $parts[] = "Cost: $cost";
$parts[] = "Timestamp: $timestamp";

$line = implode(' | ', $parts) . "\n";

if (file_put_contents($filename, $line, FILE_APPEND | LOCK_EX) !== false) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save request']);
}

?>