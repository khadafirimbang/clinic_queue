<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {   
        $docid = $_SESSION['id'];
        $patlastname = $_POST['patlastname'];
        $patfirstname = $_POST['patfirstname'];
        $patmiddlename = $_POST['patmiddlename'];
        $patcontact = $_POST['patcontact'];
        $patemail = $_POST['patemail'];
        $gender = $_POST['gender'];
        $pataddress = $_POST['pataddress'];
        $patage = $_POST['patage'];
        $medhis = $_POST['medhis'];
        $service = $_POST['service']; // Get the selected specialization

        // Insert into tblpatient
        $sql = mysqli_query($con, "INSERT INTO tblpatient(Docid, PatientLastname, PatientFirstname, PatientMiddlename, PatientContno, PatientEmail, PatientGender, PatientAdd, PatientAge, PatientMedhis, service) VALUES('$docid', '$patlastname', '$patfirstname', '$patmiddlename', '$patcontact', '$patemail', '$gender', '$pataddress', '$patage', '$medhis', '$service')");
        
        if ($sql) {
            // Get the current date in the Philippines
            date_default_timezone_set('Asia/Manila');
            $queue_date = date('Y-m-d'); // Format: YYYY-MM-DD
            $status = 'Waiting';
        
            // Get the last queue_number and increment it
            $result = mysqli_query($con, "SELECT MAX(queue_number) AS last_queue FROM patient_ques");
            $row = mysqli_fetch_assoc($result);
            $queue_number = $row['last_queue'] ? $row['last_queue'] + 1 : 1; // Start from 1 if no entries exist
        
            // Insert into patient_ques
            $patient_id = mysqli_insert_id($con); // Get the last inserted patient ID
            $sql_queue = mysqli_query($con, "INSERT INTO patient_ques(lastname, firstname, middlename, queue_number, queue_date, status, service) VALUES('$patlastname', '$patfirstname', '$patmiddlename', '$queue_number', '$queue_date', '$status', '$service')");
        
            // Check if the insertion into patient_ques was successful
            if ($sql_queue) {
                echo "<script>alert('Patient info added Successfully');</script>";
                echo "<script>window.location.href ='add-patient.php'</script>";
            } else {
                echo "<script>alert('Error adding to patient queue: " . mysqli_error($con) . "');</script>";
            }
        } else {
            echo "<script>alert('Error adding patient info: " . mysqli_error($con) . "');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Patient</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

    <script>
    function userAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'email=' + $("#patemail").val(),
            type: "POST",
            success: function(data) {
                $("#user-availability-status1").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>
</head>
<body>
    <div id="app">		
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle"><strong>Add Patient</strong></h1>
                            </div>
                            <ol class="breadcrumb">
                                <li></li>
                                <li class="active">
                                    <span>Add Patient</span>
                                </li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-body">
                                                <form role="form" name="" method="post">
                                                    <div class="form-group">
                                                        <label for="doctorname">Patient Last Name</label>
                                                        <input type="text" name="patlastname" class="form-control" placeholder="Enter Patient Name" required="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="firstname">Patient First Name</label>
                                                        <input type="text" name="patfirstname" class="form-control" placeholder="Enter Patient First Name" required="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="middlename">Patient Middle Name</label>
                                                        <input type="text" name="patmiddlename" class="form-control" placeholder="Enter Patient Middle Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fess">Patient Contact no</label>
                                                        <input type="text" name="patcontact" class="form-control" placeholder="Enter Patient Contact no" required="true" maxlength="10" pattern="[0-9]+">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fess">Patient Email</label>
                                                        <input type="email" id="patemail" name="patemail" class="form-control" placeholder="Enter Patient Email id" required="true" onBlur="userAvailability()">
                                                        <span id="user-availability-status1" style="font-size:12px;"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="block">Gender</label>
                                                        <div class="clip-radio radio-primary">
                                                            <input type="radio" id="rg-female" name="gender" value="female">
                                                            <label for="rg-female">Female</label>
                                                            <input type="radio" id="rg-male" name="gender" value="male">
                                                            <label for="rg-male">Male</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Patient Address</label>
                                                        <textarea name="pataddress" class="form-control" placeholder="Enter Patient Address" required="true"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fess">Patient Age</label>
                                                        <input type="text" name="patage" class="form-control" placeholder="Enter Patient Age" required="true">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fess">Medical History</label>
                                                        <textarea type="text" name="medhis" class="form-control" placeholder="Enter Patient Medical History(if any)" required="true"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="service">Select Service (Specialization)</label>
                                                        <select name="service" class="form-control" required>
                                                            <option value="">Select Specialization</option>
                                                            <?php
                                                            // Fetch specializations from the database
                                                            $query = mysqli_query($con, "SELECT specilization FROM doctorspecilization");
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                                echo "<option value='" . $row['specilization'] . "'>" . $row['specilization'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">Add</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="panel panel-white"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php } ?>
