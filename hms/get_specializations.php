<?php
session_start();
include('include/config.php');

$query = "SELECT specilization FROM doctorspecilization WHERE avail_slots > 0";
$result = mysqli_query($con, $query);

$options = '<option value="">Select Specialization</option>';
while ($row = mysqli_fetch_assoc($result)) {
    $options .= '<option value="' . htmlentities($row['specilization']) . '">' . htmlentities($row['specilization']) . '</option>';
}

echo $options;
?>
