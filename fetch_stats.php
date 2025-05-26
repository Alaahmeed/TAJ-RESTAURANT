<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'غير مصرح']);
    exit();
}

header('Content-Type: application/json');

include 'config.php';



$data = [
    'total_users' => 0,
    'total_orders' => 0,
    'total_reservations' => 0,
    

];


if ($result = $conn->query("SELECT COUNT(*) AS total_users FROM users")) {
    $row = $result->fetch_assoc();
    $data['total_users'] = (int)$row['total_users'];
}

if ($result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders")) {
    $row = $result->fetch_assoc();
    $data['total_orders'] = (int)$row['total_orders'];
}

if ($result = $conn->query("SELECT COUNT(*) AS total_reservations FROM reservations")) {
    $row = $result->fetch_assoc();
    $data['total_reservations'] = (int)$row['total_reservations'];
}




$conn->close();
echo json_encode($data);
