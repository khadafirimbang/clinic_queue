<?php
// Database connection
include 'db_connection.php'; // Ensure you have a file for database connection

$result = $conn->query("SELECT queue_number, name FROM patient_ques WHERE status = 'To Announce'");

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

// Clear the announcement status after fetching
$conn->query("UPDATE patient_ques SET status = 'Consulting' WHERE status = 'To Announce'");

echo json_encode($patients);
$conn->close();
?>
