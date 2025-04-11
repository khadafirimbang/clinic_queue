<?php
session_start();
//error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Get the specialization from the URL
$specilization = isset($_GET['specialization']) ? $_GET['specialization'] : '';

if (isset($_POST['submit'])) {
    $doctorid = $_POST['doctor'];
    $userid = $_SESSION['id'];
    $appdate = $_POST['appdate'];
    $time = $_POST['apptime'];
    $userstatus = 1;
    $docstatus = 1;

    // Insert appointment into the database
    $query = mysqli_query($con, "INSERT INTO appointment(doctorSpecialization, doctorId, userId, appointmentDate, appointmentTime, userStatus, doctorStatus) VALUES('$specilization', '$doctorid', '$userid', '$appdate', '$time', '$userstatus', '$docstatus')");
    
    if ($query) {
        // Decrement avail_slots in doctorspecilization table (assuming we want to reduce available slots)
        // Changed 'specialization' to 'specilization' to match your table column
        $updateQuery = mysqli_query($con, "UPDATE doctorspecilization SET avail_slots = avail_slots - 1 WHERE specilization = '$specilization'");
        
        if ($updateQuery) {
            echo "<script>alert('Your appointment successfully booked');</script>";
        } else {
            echo "<script>alert('Your appointment was booked but failed to update slots. Error: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to book your appointment. Error: " . mysqli_error($con) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Appointment</title>
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Call getdoctor with the specialization when the page loads
        var specialization = "<?php echo htmlentities($specilization); ?>";
        if (specialization) {
            getdoctor(specialization);
        }
    });

    function getdoctor(val) {
        $.ajax({
            type: "POST",
            url: "get_doctor.php",
            data: 'specilizationid=' + val,
            success: function(data) {
                $("#doctor").html(data);
            }
        });
    }
    </script>
</head>
<body>
    <div id="app">        
        <?php include('include/sidebar.php');?>
        <div class="app-content">
            <?php include('include/header.php');?>

            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle"><strong>Book Appointment</strong></h1>
                            </div>
                            <ol class="breadcrumb">
                                <li></li>
                                <li class="active">
                                    <span>Book Appointment</span>
                                </li>
                            </ol>
                    </section>

                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-8 col-md-12">
                                        <div class="panel panel-white">
                                            <div class="panel-body">
                                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg1']);?>
                                                <?php echo htmlentities($_SESSION['msg1']="");?></p>    
                                                <form role="form" name="book" method="post">
                                                    <div class="form-group">
                                                        <label>Specialization</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlentities($specilization); ?>" readonly>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="doctor">Doctors</label>
                                                        <select name="doctor" class="form-control" id="doctor" onChange="getfee(this.value);" required="required">
                                                            <option value="">Select Doctor</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="AppointmentDate">Date</label>
                                                        <input class="form-control datepicker" name="appdate" required="required" data-date-format="yyyy-mm-dd">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Appointmenttime">Time</label>
                                                        <input class="form-control" name="apptime" id="timepicker1" required="required">eg : 10:00 PM
                                                    </div>                                                        
                                                    
                                                    <button type="submit" name="submit" class="btn btn-o btn-primary">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php include('include/footer.php');?>
        <?php include('include/setting.php');?>
        </div>

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

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-3d'
            });

            $('#timepicker1').timepicker();
        </script>
    </body>
</html>