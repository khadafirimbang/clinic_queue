<?php
include('include/config.php');

if (!empty($_POST["specilizationid"])) {
    $specilizationid = mysqli_real_escape_string($con, $_POST['specilizationid']);
    $sql = mysqli_query($con, "SELECT doctorName, id FROM doctors WHERE specilization='$specilizationid'");

    // Check if any doctors were found
    if (mysqli_num_rows($sql) > 0) {
        echo '<option selected="selected">Select Doctor</option>';
        while ($row = mysqli_fetch_array($sql)) {
            echo '<option value="' . htmlentities($row['id']) . '">' . htmlentities($row['doctorName']) . '</option>';
        }
    } else {
        echo '<option value="">No doctors available</option>';
    }
}

if (!empty($_POST["doctor"])) {
    $doctorId = mysqli_real_escape_string($con, $_POST['doctor']);
    $sql = mysqli_query($con, "SELECT docFees FROM doctors WHERE id='$doctorId'");

    if ($row = mysqli_fetch_array($sql)) {
        echo htmlentities($row['docFees']);
    } else {
        echo '0'; // Return 0 if no fees found
    }
}
?>
