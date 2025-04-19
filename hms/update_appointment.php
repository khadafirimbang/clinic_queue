<?php
session_start();
include('include/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointmentId'];
    $newSpecialization = $_POST['doctorSpecialization'];
    $newDoctorId = $_POST['doctorId'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];

    // Begin transaction
    mysqli_begin_transaction($con);

    try {
        // 1. Get the old appointment details
        $getOldQuery = "SELECT doctorSpecialization, doctorId FROM appointment WHERE id = ?";
        $stmt = mysqli_prepare($con, $getOldQuery);
        mysqli_stmt_bind_param($stmt, "i", $appointmentId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $oldAppointment = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        $oldSpecialization = $oldAppointment['doctorSpecialization'];
        $oldDoctorId = $oldAppointment['doctorId'];

        // 2. Update the appointment
        $updateQuery = "UPDATE appointment SET 
                       doctorSpecialization = ?, 
                       doctorId = ?, 
                       appointmentDate = ?, 
                       appointmentTime = ? 
                       WHERE id = ?";
        
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ssssi", $newSpecialization, $newDoctorId, $appointmentDate, $appointmentTime, $appointmentId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // 3. Update avail_slots for OLD specialization (increment)
        if ($oldSpecialization != $newSpecialization) {
            $updateOldSpecQuery = "UPDATE doctorspecilization 
                                 SET avail_slots = avail_slots + 1 
                                 WHERE specilization = ?";
            $stmt = mysqli_prepare($con, $updateOldSpecQuery);
            mysqli_stmt_bind_param($stmt, "s", $oldSpecialization);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // 4. Update avail_slots for NEW specialization (decrement)
        $updateNewSpecQuery = "UPDATE doctorspecilization 
                             SET avail_slots = avail_slots - 1 
                             WHERE specilization = ? AND avail_slots > 0";
        $stmt = mysqli_prepare($con, $updateNewSpecQuery);
        mysqli_stmt_bind_param($stmt, "s", $newSpecialization);
        mysqli_stmt_execute($stmt);
        
        if (mysqli_stmt_affected_rows($stmt) == 0) {
            throw new Exception("No available slots for this specialization");
        }
        mysqli_stmt_close($stmt);

        // Commit transaction
        mysqli_commit($con);
        echo "Appointment updated successfully.";

    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($con);
} else {
    echo "Invalid request method.";
}
?>