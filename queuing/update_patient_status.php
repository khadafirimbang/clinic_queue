<?php
// Database connection
include 'config.php'; // Ensure you have a file for database connection

$data = json_decode(file_get_contents("php://input"), true);
$queueNumber = $data['queueNumber'];
$name = $data['name'];
$action = $data['action'];

// Example SQL to mark patient for announcement
if ($action === 'announce') {
    $stmt = $conn->prepare("UPDATE patient_ques SET status = 'To Announce' WHERE queue_number = ?");
    $stmt->bind_param("s", $queueNumber);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Patient marked for announcement.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update patient status.']);
    }
    $stmt->close();
}
$conn->close();
?>
