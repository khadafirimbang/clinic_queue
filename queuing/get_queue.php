<?php 
include_once('../hms/include/config.php'); 

$response = [];

// Set the timezone to Philippine time
date_default_timezone_set('Asia/Manila');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    // Get today's date in the format YYYY-MM-DD
    $today = date('Y-m-d');

    // Fetch queue data with priority
    $stmt = $con->prepare("SELECT id, lastname, middlename, firstname, queue_number, status, service, room, priority FROM patient_ques WHERE queue_date = ? AND status IN ('Waiting', 'Consulting') ORDER BY priority DESC, queue_number");
    $stmt->bind_param('s', $today);
    $stmt->execute();
    $result = $stmt->get_result();

    $queueList = [];
    $nextInLine = null;
    while ($row = $result->fetch_assoc()) {
        // Check if priority is 1 and label accordingly
        $row['priority_label'] = $row['priority'] == 1 ? 'Priority' : 'Regular';
        $queueList[] = $row;

        if ($nextInLine === null && $row['status'] === 'Waiting') {
            $nextInLine = $row;
        }
    }

    $stmt->close();

    // Fetch completed data with priority
    $stmt = $con->prepare("SELECT id, lastname, middlename, firstname, queue_number, status, service, room, priority FROM patient_ques WHERE queue_date = ? AND status IN ('Completed', 'Cancelled') ORDER BY queue_number");
    $stmt->bind_param('s', $today);
    $stmt->execute();
    $result = $stmt->get_result();

    $completedList = [];
    while ($row = $result->fetch_assoc()) {
        // Check if priority is 1 and label accordingly
        $row['priority_label'] = $row['priority'] == 1 ? 'Priority' : 'Regular';
        $completedList[] = $row;
    }

    $stmt->close();

    $response = [
        'queueList' => $queueList,    
        'nextInLine' => $nextInLine,  
        'completedList' => $completedList
    ];

    header('Content-Type: application/json');
    echo json_encode($response);  
    exit;
}
?>
