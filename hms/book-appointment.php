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

    // Generate the reference ID with uppercase letters
    $ref = strtoupper(substr($specilization, 0, 2)) . $userid . str_replace(['-', ':'], '', $appdate . $time);

    // Insert appointment into the database
    $query = mysqli_query($con, "INSERT INTO appointment(ref, doctorSpecialization, doctorId, userId, appointmentDate, appointmentTime, userStatus, doctorStatus) VALUES('$ref', '$specilization', '$doctorid', '$userid', '$appdate', '$time', '$userstatus', '$docstatus')");
    
    if ($query) {
        // Decrement avail_slots in doctorspecilization table
        $updateQuery = mysqli_query($con, "UPDATE doctorspecilization SET avail_slots = avail_slots - 1 WHERE specilization = '$specilization'");
        
        if ($updateQuery) {
            echo "<script>
            alert('Your appointment successfully booked');
            window.location.href = 'appointment-history.php';
            </script>";
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
        
        // Handle the show confirmation modal button click
        $("#showConfirmModal").click(function(e) {
            e.preventDefault();
            
            // Validate form before showing modal
            var isValid = true;
            $("#appointmentForm").find('select, input').each(function() {
                if($(this).prop('required') && !$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            if(!isValid) {
                alert("Please fill all required fields.");
                return false;
            }
            
            // Get the form values to display in the modal
            var doctor = $("#doctor option:selected").text();
            var date = $("input[name='appdate']").val();
            var time = $("input[name='apptime']").val();
            
            // Update the modal content with appointment details
            $("#confirmDoctorName").text(doctor);
            $("#confirmSpecialization").text("<?php echo htmlentities($specilization); ?>");
            $("#confirmDate").text(date);
            $("#confirmTime").text(time);
            
            // Show the modal
            $("#confirmationModal").modal('show');
        });
        
        // Handle the actual form submission
        $("#confirmAppointment").click(function() {
            // Submit the form directly
            document.getElementById("realSubmitBtn").click();
        });
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

    <style>
        .go-back-btn{
            margin-top: 10px;
        }
    </style>
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
                                                <form role="form" name="book" method="post" id="appointmentForm">
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
                                                    
                                                    <!-- This is the button that shows the modal -->
                                                    <button type="button" id="showConfirmModal" class="btn btn-o btn-primary">Book Appointment</button>
                                                    <div class="go-back-btn">
                                                        <a href="appointment-slot.php" class="btn btn-red">
                                                            <i></i> Go Back
                                                        </a>
                                                    </div>
                                                    
                                                    <!-- This is the actual submit button that will be clicked programmatically -->
                                                    <button type="submit" id="realSubmitBtn" name="submit" value="1" class="btn btn-o btn-primary" style="display:none;">Submit</button>
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
            
            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="confirmationModalLabel">Confirm Your Appointment</h4>
                        </div>
                        <div class="modal-body">
                            <p>Please confirm your appointment details:</p>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Specialization</th>
                                    <td id="confirmSpecialization"></td>
                                </tr>
                                <tr>
                                    <th>Doctor</th>
                                    <td id="confirmDoctorName"></td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td id="confirmDate"></td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td id="confirmTime"></td>
                                </tr>
                            </table>
                            <p class="text-warning"><small>Note: Once confirmed, appointment slots will be reserved for you.</small></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmAppointment">Confirm Appointment</button>
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