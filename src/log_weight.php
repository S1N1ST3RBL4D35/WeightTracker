<?php
session_start();

include 'conn.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Assume you have user authentication and userID in the session
    $userId = $_SESSION['user']['id'];

    //Sanitize and validate input
    $logDate = filter_input(INPUT_POST, 'logDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_FLOAT);
    $unit = filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //Validate input data
    if(!$userId || !$logDate || !$weight || !$unit) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        exit;
    }

    //Insert weight log into database
    $stmt = $conn->prepare('INSERT INTO weight_logs (user_id, log_date, weight, unit) VALUES (?,?,?,?)');
    $stmt->bind_param('isds', $userId, $logDate, $weight, $unit);

    if($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Weight log added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding weight log']);
    }
    $stmt->close();
    exit;
}

//Fetch weight logs for the user from the database
$userId = $_SESSION['user']['id'];
$stmt = $conn->prepare('SELECT log_date, weight, unit FROM weight_logs WHERE user_id = ? ORDER BY log_date DESC');
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result($logDate, $weight, $unit);

$weightLogs = [];
while ($stmt->fetch()) {
    $weightLogs[] = ['log_date' => $logDate, 'weight' => $weight, 'unit' => $unit];
}

$stmt->close();

echo json_encode(['success' => true, 'weightLogs' => $weightLogs]);
?>