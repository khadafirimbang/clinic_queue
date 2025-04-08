<?php
// Database connection
include('include/config.php');

$submissionSuccess = false; // Flag to indicate successful submission

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
    $knownAllergies = $_POST['knownAllergies'];
    $medicalConditions = $_POST['medicalConditions'];

    // Dental lab tests/services requested
    $prostheticWork = $_POST['prostheticWork'] ?? '';
    $materials = $_POST['materials'] ?? '';
    $teethImpression = $_POST['teethImpression'] ?? '';
    $shadeGuide = $_POST['shadeGuide'] ?? '';
    $customShade = $_POST['customShade'] ?? '';
    $shadeInstructions = $_POST['shadeInstructions'] ?? '';
    $otherServices = $_POST['otherServices'] ?? '';
    $urgency = $_POST['urgency'];

    $dentistNotes = $_POST['dentistNotes'];

    // Insert into database
    $sql = "INSERT INTO dental_lab_form (labName, address, phone, date, patientId, fullName, dob, age, gender, contactNumber, email, patientAddress, dentistName, dentistContact, previousProcedures, existingProsthetics, knownAllergies, medicalConditions, prostheticWork, materials, teethImpression, shadeGuide, customShade, shadeInstructions, otherServices, urgency, dentistNotes) 
            VALUES ('$labName', '$address', '$phone', '$date', '$patientId', '$fullName', '$dob', '$age', '$gender', '$contactNumber', '$email', '$patientAddress', '$dentistName', '$dentistContact', '$previousProcedures', '$existingProsthetics', '$knownAllergies', '$medicalConditions', '$prostheticWork', '$materials', '$teethImpression', '$shadeGuide', '$customShade', '$shadeInstructions', '$otherServices', '$urgency', '$dentistNotes')";

    if (mysqli_query($con, $sql)) {
        $submissionSuccess = true; // Set success flag
        mysqli_close($con);
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
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
    <title>Dental Laboratory Form</title>
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
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Dental Laboratory Form</h1>
        
        <!-- Success Message -->
        <div id="successMessage" class="success-message">
            Your submission was successful! Thank you for your submission.
        </div>

        <form id="dentalForm" action="" method="POST">
            <h2>Laboratory Information</h2>
            <label for="labName">Laboratory Name:</label>
            <input type="text" id="labName" name="labName" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="patientId">Patient ID:</label>
            <input type="text" id="patientId" name="patientId" required>

            <h2>Patient Information</h2>
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Other">Other</option>
            </select>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="patientAddress">Address:</label>
            <input type="text" id="patientAddress" name="patientAddress" required>

            <label for="dentistName">Dentist Name:</label>
            <input type="text" id="dentistName" name="dentistName" required>

            <label for="dentistContact">Dentist Contact Information:</label>
            <input type="text" id="dentistContact" name="dentistContact" required>

            <h2>Dental History</h2>
            <label for="previousProcedures">Previous Dental Procedures:</label>
            <textarea id="previousProcedures" name="previousProcedures" rows="3"></textarea>

            <label for="existingProsthetics">Existing Dental Prosthetics (if any):</label>
            <select id="existingProsthetics" name="existingProsthetics" onchange="toggleOthersInput(this, 'othersProstheticsInput')">
                <option value="">Select</option>
                <option value="Crowns">Crowns</option>
                <option value="Bridges">Bridges</option>
                <option value="Dentures">Dentures</option>
                <option value="Veneers">Veneers</option>
                <option value="Implants">Implants</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersProstheticsInput" name="othersProsthetics" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="knownAllergies">Known Allergies:</label>
            <input type="text" id="knownAllergies" name="knownAllergies">

            <label for="medicalConditions">Other Medical Conditions (e.g., diabetes, heart issues):</label>
            <textarea id="medicalConditions" name="medicalConditions"></textarea>

            <h2>Dental Lab Tests/Services Requested</h2>
            <label for="prostheticWork">1. Prosthetic Work:</label>
            <select id="prostheticWork" name="prostheticWork" onchange="toggleOthersInput(this, 'othersProstheticInput')">
                <option value="">Select</option>
                <option value="Crown">Crown</option>
                <option value="Bridge">Bridge</option>
                <option value="Complete Denture">Complete Denture</option>
                <option value="Partial Denture">Partial Denture</option>
                <option value="Implant Restoration">Implant Restoration</option>
                <option value="Veneers">Veneers</option>
                <option value="Inlays/Onlays">Inlays/Onlays</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersProstheticInput" name="othersProsthetic" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="materials">2. Materials:</label>
            <select id="materials" name="materials" onchange="toggleOthersInput(this, 'othersMaterialsInput')">
                <option value="">Select</option>
                <option value="Porcelain">Porcelain</option>
                <option value="Ceramic">Ceramic</option>
                <option value="Metal">Metal (e.g., gold, stainless steel)</option>
                <option value="Composite Resin">Composite Resin</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersMaterialsInput" name="othersMaterials" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="teethImpression">3. Teeth Impression:</label>
            <select id="teethImpression" name="teethImpression">
                <option value="">Select</option>
                <option value="Upper Impression">Upper Impression</option>
                <option value="Lower Impression">Lower Impression</option>
                <option value="Bite Registration">Bite Registration</option>
            </select>

            <label for="shadeGuide">4. Shade Selection:</label>
            <input type="text" id="shadeGuide" name="shadeGuide" placeholder="Shade Guide Used: ____________________"><br>
            <label for="customShade">Custom Shade:</label>
            <select id="customShade" name="customShade">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            <input type="text" name="shadeInstructions" placeholder="Special Instructions: ___________________"><br>

            <label for="otherServices">5. Other Services:</label>
            <select id="otherServices" name="otherServices" onchange="toggleOthersInput(this, 'othersServicesInput')">
                <option value="">Select</option>
                <option value="Orthodontic Appliances">Orthodontic Appliances</option>
                <option value="Night Guards">Night Guards</option>
                <option value="Retainers">Retainers</option>
                <option value="Teeth Whitening Trays">Teeth Whitening Trays</option>
                <option value="Others">Others</option>
            </select>
            <input type="text" id="othersServicesInput" name="othersServices" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="urgency">6. Urgency of Case:</label>
            <select id="urgency" name="urgency" required>
                <option value="Standard">Standard</option>
                <option value="Rush">Rush (Extra Charges Apply)</option>
            </select>

            <label for="dentistNotes">Dentist's Notes and Special Instructions:</label>
            <textarea id="dentistNotes" name="dentistNotes"></textarea>

            <button type="submit">Submit</button>
            <a href="manage-dental.php" class="btn btn-secondary" style="margin-left: 10px;">Back</a>
        </form>
    </div>
</body>
</html>
