<?php
session_start();
error_reporting(0);
include('include/config.php');

$submissionSuccess = false; // Flag to indicate successful submission

// Fetch the record to edit
$labId = $_GET['id'];
$query = mysqli_query($con, "SELECT * FROM prenatal_lab_form WHERE id='$labId'");
$row = mysqli_fetch_array($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
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
    $obgynName = $_POST['obgynName'];
    $obgynContact = $_POST['obgynContact'];
    $lmp = $_POST['lmp'];
    $edd = $_POST['edd'];
    $gravida = $_POST['gravida'];
    $para = $_POST['para'];
    $previousPregnancies = $_POST['previousPregnancies'];
    $previousComplications = $_POST['previousComplications'];

    // Handle selected tests
    $bloodTests = $_POST['bloodTests'] ?? [];
    $urineTests = $_POST['urineTests'] ?? [];
    $diseaseScreening = $_POST['diseaseScreening'] ?? [];
    $geneticScreening = $_POST['geneticScreening'] ?? [];
    $ultrasound = $_POST['ultrasound'] ?? [];

    // Handle "Others" text fields
    $othersBlood = $_POST['othersBlood'] ?? '';
    $othersUrine = $_POST['othersUrine'] ?? '';
    $othersDisease = $_POST['othersDisease'] ?? '';
    $othersGenetic = $_POST['othersGenetic'] ?? '';
    $othersUltrasound = $_POST['othersUltrasound'] ?? '';

    // Append "Others" text if provided
    if (!empty($othersBlood)) $bloodTests[] = $othersBlood;
    if (!empty($othersUrine)) $urineTests[] = $othersUrine;
    if (!empty($othersDisease)) $diseaseScreening[] = $othersDisease;
    if (!empty($othersGenetic)) $geneticScreening[] = $othersGenetic;
    if (!empty($othersUltrasound)) $ultrasound[] = $othersUltrasound;

    // Convert arrays to strings
    $bloodTests = implode(", ", $bloodTests);
    $urineTests = implode(", ", $urineTests);
    $diseaseScreening = implode(", ", $diseaseScreening);
    $geneticScreening = implode(", ", $geneticScreening);
    $ultrasound = implode(", ", $ultrasound);

    $notes = $_POST['notes'];
    $physicianNotes = $_POST['physicianNotes'];

    // Update the record
    $sql = "UPDATE prenatal_lab_form SET 
            labName='$labName', 
            address='$address', 
            phone='$phone', 
            date='$date', 
            patientId='$patientId', 
            fullName='$fullName', 
            dob='$dob', 
            age='$age', 
            gender='$gender', 
            contactNumber='$contactNumber', 
            email='$email', 
            patientAddress='$patientAddress', 
            obgynName='$obgynName', 
            obgynContact='$obgynContact', 
            lmp='$lmp', 
            edd='$edd', 
            gravida='$gravida', 
            para='$para', 
            previousPregnancies='$previousPregnancies', 
            previousComplications='$previousComplications', 
            bloodTests='$bloodTests', 
            urineTests='$urineTests', 
            diseaseScreening='$diseaseScreening', 
            geneticScreening='$geneticScreening', 
            ultrasound='$ultrasound', 
            notes='$notes', 
            physicianNotes='$physicianNotes' 
            WHERE id='$labId'";

    if (mysqli_query($con, $sql)) {
        $submissionSuccess = true; // Set success flag
        header("Location: manage-prenatal.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prenatal Laboratory Form</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
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

        /* Success message style */
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
        <h1>Edit Prenatal Laboratory Form</h1>

        <!-- Success Message -->
        <div id="successMessage" class="success-message">
            Your changes were saved successfully!
        </div>

        <form id="prenatalForm" action="" method="POST">
            <h2>Laboratory Information</h2>
            <label for="labName">Laboratory Name:</label>
            <input type="text" id="labName" name="labName" value="<?php echo $row['labName']; ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>" required>

            <label for="patientId">Patient ID:</label>
            <input type="text" id="patientId" name="patientId" value="<?php echo $row['patientId']; ?>" required>

            <h2>Patient Information</h2>
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo $row['fullName']; ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $row['dob']; ?>" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $row['age']; ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Other" <?php echo ($row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <label for="contactNumber">Contact Number:</label>
            <input type="tel" id="contactNumber" name="contactNumber" value="<?php echo $row['contactNumber']; ?>" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>

            <label for="patientAddress">Address:</label>
            <input type="text" id="patientAddress" name="patientAddress" value="<?php echo $row['patientAddress']; ?>" required>

            <label for="obgynName">Obstetrician/Gynecologist Name:</label>
            <input type="text" id="obgynName" name="obgynName" value="<?php echo $row['obgynName']; ?>" required>

            <label for="obgynContact">OB/GYN Contact Information:</label>
            <input type="text" id="obgynContact" name="obgynContact" value="<?php echo $row['obgynContact']; ?>" required>

            <label for="lmp">Last Menstrual Period (LMP):</label>
            <input type="date" id="lmp" name="lmp" value="<?php echo $row['lmp']; ?>" required>

            <label for="edd">Estimated Due Date (EDD):</label>
            <input type="date" id="edd" name="edd" value="<?php echo $row['edd']; ?>" required>

            <label for="gravida">Gravida:</label>
            <input type="number" id="gravida" name="gravida" value="<?php echo $row['gravida']; ?>" required>

            <label for="para">Para:</label>
            <input type="number" id="para" name="para" value="<?php echo $row['para']; ?>" required>

            <label for="previousPregnancies">Previous Pregnancies:</label>
            <input type="text" id="previousPregnancies" name="previousPregnancies" value="<?php echo $row['previousPregnancies']; ?>" required>

            <label for="previousComplications">Previous Complications:</label>
            <input type="text" id="previousComplications" name="previousComplications" value="<?php echo $row['previousComplications']; ?>">

            <h2>Prenatal Lab Tests Requested</h2>

            <label for="bloodTests">Blood Work:</label>
            <select id="bloodTests" name="bloodTests[]" onchange="toggleOthersInput(this, 'othersBloodInput')" required>
                <option value="">Select</option>
                <option value="CBC" <?php echo (strpos($row['bloodTests'], 'CBC') !== false) ? 'selected' : ''; ?>>Complete Blood Count (CBC)</option>
                <option value="BloodType" <?php echo (strpos($row['bloodTests'], 'BloodType') !== false) ? 'selected' : ''; ?>>Blood Type & Rh Factor</option>
                <option value="Hemoglobin" <?php echo (strpos($row['bloodTests'], 'Hemoglobin') !== false) ? 'selected' : ''; ?>>Hemoglobin & Hematocrit</option>
                <option value="Glucose" <?php echo (strpos($row['bloodTests'], 'Glucose') !== false) ? 'selected' : ''; ?>>Glucose Screening</option>
                <option value="Rubella" <?php echo (strpos($row['bloodTests'], 'Rubella') !== false) ? 'selected' : ''; ?>>Rubella Immunity</option>
                <option value="HIV" <?php echo (strpos($row['bloodTests'], 'HIV') !== false) ? 'selected' : ''; ?>>HIV Screening</option>
                <option value="Hepatitis" <?php echo (strpos($row['bloodTests'], 'Hepatitis') !== false) ? 'selected' : ''; ?>>Hepatitis B & C</option>
                <option value="Syphilis" <?php echo (strpos($row['bloodTests'], 'Syphilis') !== false) ? 'selected' : ''; ?>>Syphilis Test</option>
                <option value="TORCH" <?php echo (strpos($row['bloodTests'], 'TORCH') !== false) ? 'selected' : ''; ?>>TORCH Panel</option>
                <option value="Others" <?php echo (strpos($row['bloodTests'], 'Others') !== false) ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersBloodInput" name="othersBlood" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="urineTests">Urine Tests:</label>
            <select id="urineTests" name="urineTests[]" onchange="toggleOthersInput(this, 'othersUrineInput')" required>
                <option value="">Select</option>
                <option value="Urinalysis" <?php echo (strpos($row['urineTests'], 'Urinalysis') !== false) ? 'selected' : ''; ?>>Urinalysis</option>
                <option value="Proteinuria" <?php echo (strpos($row['urineTests'], 'Proteinuria') !== false) ? 'selected' : ''; ?>>Proteinuria</option>
                <option value="UrineCulture" <?php echo (strpos($row['urineTests'], 'UrineCulture') !== false) ? 'selected' : ''; ?>>Urine Culture</option>
                <option value="Others" <?php echo (strpos($row['urineTests'], 'Others') !== false) ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersUrineInput" name="othersUrine" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="diseaseScreening">Infectious Disease Screening:</label>
            <select id="diseaseScreening" name="diseaseScreening[]" onchange="toggleOthersInput(this, 'othersDiseaseInput')" required>
                <option value="">Select</option>
                <option value="GBS" <?php echo (strpos($row['diseaseScreening'], 'GBS') !== false) ? 'selected' : ''; ?>>Group B Streptococcus (GBS)</option>
                <option value="Chlamydia" <?php echo (strpos($row['diseaseScreening'], 'Chlamydia') !== false) ? 'selected' : ''; ?>>Chlamydia</option>
                <option value="Gonorrhea" <?php echo (strpos($row['diseaseScreening'], 'Gonorrhea') !== false) ? 'selected' : ''; ?>>Gonorrhea</option>
                <option value="Others" <?php echo (strpos($row['diseaseScreening'], 'Others') !== false) ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersDiseaseInput" name="othersDisease" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="geneticScreening">Genetic Screening (Optional):</label>
            <select id="geneticScreening" name="geneticScreening[]" onchange="toggleOthersInput(this, 'othersGeneticInput')" required>
                <option value="">Select</option>
                <option value="Carrier" <?php echo (strpos($row['geneticScreening'], 'Carrier') !== false) ? 'selected' : ''; ?>>Carrier Screening</option>
                <option value="CysticFibrosis" <?php echo (strpos($row['geneticScreening'], 'CysticFibrosis') !== false) ? 'selected' : ''; ?>>Cystic Fibrosis</option>
                <option value="DownSyndrome" <?php echo (strpos($row['geneticScreening'], 'DownSyndrome') !== false) ? 'selected' : ''; ?>>Down Syndrome</option>
                <option value="Trisomy" <?php echo (strpos($row['geneticScreening'], 'Trisomy') !== false) ? 'selected' : ''; ?>>Trisomy 18 & 13</option>
                <option value="Others" <?php echo (strpos($row['geneticScreening'], 'Others') !== false) ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersGeneticInput" name="othersGenetic" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="ultrasound">Ultrasound and Imaging:</label>
            <select id="ultrasound" name="ultrasound[]" onchange="toggleOthersInput(this, 'othersUltrasoundInput')" required>
                <option value="">Select</option>
                <option value="FetalUltrasound" <?php echo (strpos($row['ultrasound'], 'FetalUltrasound') !== false) ? 'selected' : ''; ?>>Fetal Ultrasound</option>
                <option value="NTScan" <?php echo (strpos($row['ultrasound'], 'NTScan') !== false) ? 'selected' : ''; ?>>Nuchal Translucency (NT) Scan</option>
                <option value="Others" <?php echo (strpos($row['ultrasound'], 'Others') !== false) ? 'selected' : ''; ?>>Others</option>
            </select>
            <input type="text" id="othersUltrasoundInput" name="othersUltrasound" class="others-input" placeholder="Please specify" onfocus="this.value=''" style="display:none;">

            <label for="notes">Other Tests/Notes:</label>
            <textarea id="notes" name="notes"><?php echo $row['notes']; ?></textarea>

            <h2>Physician's Notes and Recommendations</h2>
            <textarea id="physicianNotes" name="physicianNotes"><?php echo $row['physicianNotes']; ?></textarea>

            <button type="submit">Update</button>
            <a href="manage-prenatal.php" class="btn btn-secondary" style="margin-left: 10px;">Back</a>
        </form>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
