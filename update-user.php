<?php
include './includes/db.inc.php';

$data = json_decode(file_get_contents('php://input'), true);

$stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, username=?, role=? WHERE id=?");
$stmt->bind_param("sssssi", 
    $data['firstName'],
    $data['lastName'],
    $data['email'],
    $data['username'],
    $data['role'],
    $data['id']
);

$response = ['success' => false];

if($stmt->execute()) {
    $response['success'] = true;
}

echo json_encode($response);
$stmt->close();
$conn->close();
