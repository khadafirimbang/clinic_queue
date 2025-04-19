<?php
include('include/config.php');

if (!empty($_POST["specilizationid"])) {
    $specilizationid = mysqli_real_escape_string($con, $_POST['specilizationid']);
    $currentDoctor = isset($_POST['currentDoctor']) ? $_POST['currentDoctor'] : null;
    
    $query = "SELECT id, doctorName FROM doctors WHERE specilization='$specilizationid'";
    $result = mysqli_query($con, $query);

    $options = '<option value="">Select Doctor</option>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($currentDoctor && $row['id'] == $currentDoctor) ? 'selected' : '';
        $options .= '<option value="'.htmlentities($row['id']).'" '.$selected.'>'
                   .htmlentities($row['doctorName']).'</option>';
    }
    
    echo $options;
    exit;
}

if (!empty($_POST["doctor"])) {
    $doctorId = mysqli_real_escape_string($con, $_POST['doctor']);
    $sql = mysqli_query($con, "SELECT docFees FROM doctors WHERE id='$doctorId'");
    if ($row = mysqli_fetch_array($sql)) {
        echo htmlentities($row['docFees']);
    } else {
        echo '0';
    }
    exit;
}
?>