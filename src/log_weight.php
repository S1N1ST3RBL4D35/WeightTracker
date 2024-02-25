<?php
session_start();

include ('conn.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['user']['id'];
    $logDate = $_POST['logDate'];
    $weight = $_POST['weight'];
    $unit = $_POST['unit'];

    $stmt = $conn->prepare('INSERT INTO weight_logs (user_id, log_date, weight, unit) VALUES (?,?,?,?)');
    $stmt->bind_param('isds', $userID, $logDate, $weight, $unit);

    if($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Weight log added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding weight log']);
    }
    $stmt->close();
    exit;
}

$userID = $_SESSION['user']['id'];
$stmt = $conn->prepare('SELECT log_date, weight, unit FROM weight_logs WHERE user_id = ? ORDER BY log_date DESC');
$stmt->bind_param('i', $userID);
$stmt->execute();
$stmt->bind_result($logDate, $weight, $unit);

$logs = [];
while($stmt->fetch()) {
    $logs[] = ['log_date' => $logDate, 'weight' => $weight, 'unit' => $unit];
}

$stmt->close();

echo json_encode(['success' => true, 'weightLogs' => $logs]);
?>