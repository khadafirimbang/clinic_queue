<?php
session_start();
include('include/config.php');

$submissionSuccess = false; // Flag to indicate successful submission

// Fetching existing record if ID is set
if (isset($_GET['id'])) {
    $labId = $_GET['id'];
    $result = mysqli_query($con, "SELECT * FROM dental_lab_form WHERE id='$labId'");
    $row = mysqli_fetch_array($result);
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $labName = $_POST['labName'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $patientId = $_POST['patientId'];
    $fullName = $_POST['fullName'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $patientAddress = $_POST['patientAddress'];
    $dentistName = $_POST['dentistName'];
    $dentistContact = $_POST['dentistContact'];

    // Dental history
    $previousProcedures = $_POST['previousProcedures'] ?? '';
    $existingProsthetics = $_POST['existingProsthetics'] ?? '';
    if ($existingProsthetics === 'Others') {
        $existingProsthetics = $_POST['othersProsthetics'] ?? '';
    }
    $knownAllergies = $_POST['knownAllergies'];
    $medicalConditions = $_POST['medicalConditions'];

    // Dental lab tests/services requested
    $prostheticWork = $_POST['prostheticWork'] ?? '';
    if ($prostheticWork === 'Others') {
        $prostheticWork = $_POST['othersProsthetic'] ?? '';
    }
    $materials = $_POST['materials'] ?? '';
    if ($materials === 'Others') {
        $materials = $_POST['othersMaterials'] ?? '';
    }
    $teethImpression = $_POST['teethImpression'] ?? '';
    $shadeGuide = $_POST['shadeGuide'] ?? '';
    $customShade = $_POST['customShade'] ?? '';
    $shadeInstructions = $_POST['shadeInstructions'] ?? '';
    $otherServices = $_POST['otherServices'] ?? '';
    if ($otherServices === 'Others') {
        $otherServices = $_POST['othersServices'] ?? '';
    }
    $urgency = $_POST['urgency'];
    $dentistNotes = $_POST['dentistNotes'];

    // Update the record in the database
    $sql = "UPDATE dental_lab_form SET labName='$labName', address='$address', phone='$phone', date='$date', patientId='$patientId', fullName='$fullName', dob='$dob', age='$age', gender='$gender', contactNumber='$contactNumber', email='$email', patientAddress='$patientAddress', dentistName='$dentistName', dentistContact='$dentistContact', previousProcedures='$previousProcedures', existingProsthetics='$existingProsthetics', knownAllergies='$knownAllergies', medicalConditions='$medicalConditions', prostheticWork='$prostheticWork', materials='$materials', teethImpression='$teethImpression', shadeGuide='$shadeGuide', customShade='$customShade', shadeInstructions='$shadeInstructions', otherServices='$otherServices', urgency='$urgency', dentistNotes='$dentistNotes' WHERE id='$labId'";

    if (mysqli_query($con, $sql)) {
        $submissionSuccess = true; // Set success flag
        mysqli_close($con);
        header("Location: manage-dental.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <title>Edit Dental Laboratory Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .others-input {
            display: none;
            margin-top: 10px;
        }

        .container h1 {
            text-align: center;
        }

        .success-message {
            display: none;
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
        }
    </style>
    <script>
        function toggleOthersInput(selectElement, othersInputId) {
            const othersInput = document.getElementById(othersInputId);
            othersInput.style.display = selectElement.value === 'Others' ? 'block' : 'none';
        }

        // Show success message if the URL contains the success parameter
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                document.getElementById('successMessage').style.display = 'block';
            }

            // Initialize "Others" fields visibility
            toggleOthersInput(document.getElementById('existingProsthetics'), 'othersProstheticsInput');
            toggleOthersInput(document.getElementById('prostheticWork'), 'othersProstheticInput');
            toggleOthersInput(document.getElementById('materials'), 'othersMaterialsInput');
            toggleOthersInput(document.getElementById('otherServices'), 'othersServicesInput');
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Edit Dental Laboratory Form</h1>

        <!-- Success Message -->
        <div id="successMessage" class="success-message">
            Your submission was successful! Thank you for your submission.
        </div>

        <form id="dentalForm" action="" method="POST">
            <h2>Laboratory Information</h2>
            <label for="labName">Laboratory Name:</label>
            <input type="text" id="labName" name="labName" value="<?php echo htmlentities($row['labName']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlentities($row['address']); ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlentities($row['phone']); ?>" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlentities($row['date']); ?>" required>

            <label for="patientId">Patient ID:</label>
            <input type="text" id="patientId" name="patientId" value="<?php echo htmlentities($row['patientId']); ?>" required>

            <h2>Patient Information</h2>
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo htmlentities($row['fullName']); ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlentities($row['dob']); ?>" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlentities($row['age']); ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" value="<?php echo htmlentities($row['contactNumber']); ?>" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlentities($row['email']); ?>" required>

            <label for="patientAddress">Address:</label>
            <input type="text" id="patientAddress" name="patientAddress" value="<?php echo htmlentities($row['patientAddress']); ?>" required>

            <label for="dentistName">Dentist Name:</label>
            <input type="text" id="dentistName" name="dentistName" value="<?php echo htmlentities($row['dentistName']); ?>" required>

            <label for="dentistContact">Dentist Contact Information:</label>
            <input type="text" id="dentistContact" name="dentistContact" value="<?php echo htmlentities($row['dentistContact']); ?>" required>

            <h2>Dental History</h2>
            <label for="previousProcedures">Previous Dental Procedures:</label>
            <textarea id="previousProcedures" name="previousProcedures" rows="3"><?php echo htmlentities($row['previousProcedures']); ?></textarea>

            <label for="existingProsthetics">Existing Dental Prosthetics (if any):</label>
            <select id="existingProsthetics" name="existingProsthetics" onchange="toggleOthersInput(this, 'othersProstheticsInput')">
                <option value="">Select</option>
                <option value="Crowns" <?php echo ($row['existingProsthetics'] == 'Crowns') ? 'selected' : ''; ?>>Crowns</option>
                <option value="Bridges" <?php echo ($row['existingProsthetics'] == 'Bridges') ? 'selected' : ''; ?>>Bridges</option>
                <option value="Dentures" <?php echo ($row['existingProsthetics'] == 'Dentures') ? 'selected' : ''; ?>>Dentures</option>
                <option value="Veneers" <?php echo ($row['existingProsthetics'] == 'Veneers') ? 'selected' : ''; ?>>Veneers</option>
                <option value="Implants" <?php echo ($row['existingProsthetics'] == 'Implants') ? 'selected' : ''; ?>>Implants</option>
                <option value="Others" <?php echo ($row['existingProsthetics'] == 'Others') ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersProstheticsInput" name="othersProsthetics" class="others-input" placeholder="Please specify" value="<?php echo ($row['existingProsthetics'] == 'Others') ? htmlentities($row['othersProsthetics']) : ''; ?>" onfocus="this.value=''" style="display:<?php echo ($row['existingProsthetics'] == 'Others') ? 'block' : 'none'; ?>;">

            <label for="knownAllergies">Known Allergies:</label>
            <input type="text" id="knownAllergies" name="knownAllergies" value="<?php echo htmlentities($row['knownAllergies']); ?>">

            <label for="medicalConditions">Other Medical Conditions (e.g., diabetes, heart issues):</label>
            <textarea id="medicalConditions" name="medicalConditions"><?php echo htmlentities($row['medicalConditions']); ?></textarea>

            <h2>Dental Lab Tests/Services Requested</h2>
            <label for="prostheticWork">1. Prosthetic Work:</label>
            <select id="prostheticWork" name="prostheticWork" onchange="toggleOthersInput(this, 'othersProstheticInput')">
                <option value="">Select</option>
                <option value="Crown" <?php echo ($row['prostheticWork'] == 'Crown') ? 'selected' : ''; ?>>Crown</option>
                <option value="Bridge" <?php echo ($row['prostheticWork'] == 'Bridge') ? 'selected' : ''; ?>>Bridge</option>
                <option value="Complete Denture" <?php echo ($row['prostheticWork'] == 'Complete Denture') ? 'selected' : ''; ?>>Complete Denture</option>
                <option value="Partial Denture" <?php echo ($row['prostheticWork'] == 'Partial Denture') ? 'selected' : ''; ?>>Partial Denture</option>
                <option value="Implant Restoration" <?php echo ($row['prostheticWork'] == 'Implant Restoration') ? 'selected' : ''; ?>>Implant Restoration</option>
                <option value="Veneers" <?php echo ($row['prostheticWork'] == 'Veneers') ? 'selected' : ''; ?>>Veneers</option>
                <option value="Inlays/Onlays" <?php echo ($row['prostheticWork'] == 'Inlays/Onlays') ? 'selected' : ''; ?>>Inlays/Onlays</option>
                <option value="Others" <?php echo ($row['prostheticWork'] == 'Others') ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersProstheticInput" name="othersProsthetic" class="others-input" placeholder="Please specify" value="<?php echo ($row['prostheticWork'] == 'Others') ? htmlentities($row['othersProsthetic']) : ''; ?>" onfocus="this.value=''" style="display:<?php echo ($row['prostheticWork'] == 'Others') ? 'block' : 'none'; ?>;">

            <label for="materials">2. Materials:</label>
            <select id="materials" name="materials" onchange="toggleOthersInput(this, 'othersMaterialsInput')">
                <option value="">Select</option>
                <option value="Porcelain" <?php echo ($row['materials'] == 'Porcelain') ? 'selected' : ''; ?>>Porcelain</option>
                <option value="Ceramic" <?php echo ($row['materials'] == 'Ceramic') ? 'selected' : ''; ?>>Ceramic</option>
                <option value="Metal" <?php echo ($row['materials'] == 'Metal') ? 'selected' : ''; ?>>Metal (e.g., gold, stainless steel)</option>
                <option value="Composite Resin" <?php echo ($row['materials'] == 'Composite Resin') ? 'selected' : ''; ?>>Composite Resin</option>
                <option value="Others" <?php echo ($row['materials'] == 'Others') ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersMaterialsInput" name="othersMaterials" class="others-input" placeholder="Please specify" value="<?php echo ($row['materials'] == 'Others') ? htmlentities($row['othersMaterials']) : ''; ?>" onfocus="this.value=''" style="display:<?php echo ($row['materials'] == 'Others') ? 'block' : 'none'; ?>;">

            <label for="teethImpression">3. Teeth Impression:</label>
            <select id="teethImpression" name="teethImpression">
                <option value="">Select</option>
                <option value="Upper Impression" <?php echo ($row['teethImpression'] == 'Upper Impression') ? 'selected' : ''; ?>>Upper Impression</option>
                <option value="Lower Impression" <?php echo ($row['teethImpression'] == 'Lower Impression') ? 'selected' : ''; ?>>Lower Impression</option>
                <option value="Bite Registration" <?php echo ($row['teethImpression'] == 'Bite Registration') ? 'selected' : ''; ?>>Bite Registration</option>
            </select>

            <label for="shadeGuide">4. Shade Selection:</label>
            <input type="text" id="shadeGuide" name="shadeGuide" value="<?php echo htmlentities($row['shadeGuide']); ?>" placeholder="Shade Guide Used: ____________________"><br>
            <label for="customShade">Custom Shade:</label>
            <select id="customShade" name="customShade">
                <option value="Yes" <?php echo ($row['customShade'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                <option value="No" <?php echo ($row['customShade'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
            <input type="text" name="shadeInstructions" value="<?php echo htmlentities($row['shadeInstructions']); ?>" placeholder="Special Instructions: ___________________"><br>

            <label for="otherServices">5. Other Services:</label>
            <select id="otherServices" name="otherServices" onchange="toggleOthersInput(this, 'othersServicesInput')">
                <option value="">Select</option>
                <option value="Orthodontic Appliances" <?php echo ($row['otherServices'] == 'Orthodontic Appliances') ? 'selected' : ''; ?>>Orthodontic Appliances</option>
                <option value="Night Guards" <?php echo ($row['otherServices'] == 'Night Guards') ? 'selected' : ''; ?>>Night Guards</option>
                <option value="Retainers" <?php echo ($row['otherServices'] == 'Retainers') ? 'selected' : ''; ?>>Retainers</option>
                <option value="Teeth Whitening Trays" <?php echo ($row['otherServices'] == 'Teeth Whitening Trays') ? 'selected' : ''; ?>>Teeth Whitening Trays</option>
                <option value="Others" <?php echo ($row['otherServices'] == 'Others') ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersServicesInput" name="othersServices" class="others-input" placeholder="Please specify" value="<?php echo ($row['otherServices'] == 'Others') ? htmlentities($row['othersServices']) : ''; ?>" onfocus="this.value=''" style="display:<?php echo ($row['otherServices'] == 'Others') ? 'block' : 'none'; ?>;">

            <label for="urgency">6. Urgency of Case:</label>
            <select id="urgency" name="urgency" required>
                <option value="Standard" <?php echo ($row['urgency'] == 'Standard') ? 'selected' : ''; ?>>Standard</option>
                <option value="Rush" <?php echo ($row['urgency'] == 'Rush') ? 'selected' : ''; ?>>Rush (Extra Charges Apply)</option>
            </select>

            <label for="dentistNotes">Dentist's Notes and Special Instructions:</label>
            <textarea id="dentistNotes" name="dentistNotes"><?php echo htmlentities($row['dentistNotes']); ?></textarea>

            <button type="submit">Update</button>
            <a href="manage-dental.php" class="btn btn-secondary" style="margin-left: 10px;">Back</a>
        </form>
    </div>
</body>
</html>

