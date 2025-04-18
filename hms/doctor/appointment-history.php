<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {

    if (isset($_GET['cancel'])) {
        mysqli_query($con, "UPDATE appointment SET doctorStatus='0' WHERE id ='" . $_GET['id'] . "'");
        $_SESSION['msg'] = "Appointment canceled !!";
    }

    // Handle Approve and Complete actions
    if (isset($_GET['approve'])) {
        mysqli_query($con, "UPDATE appointment SET bookingStatus='Approved' WHERE id ='" . $_GET['id'] . "'");
        $_SESSION['msg'] = "Appointment approved!";
    }

    if (isset($_GET['complete'])) {
        mysqli_query($con, "UPDATE appointment SET bookingStatus='Completed' WHERE id ='" . $_GET['id'] . "'");
        $_SESSION['msg'] = "Appointment completed!";
    }

    // Initialize search variable
    $search = '';
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($con, trim($_GET['search'])); // Trim whitespace
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Appointment History</title>
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
                                <h1 class="mainTitle"><strong>VIEW APPOINTMENTS</strong></h1>
                            </div>
                            <ol class="breadcrumb">
                                <li></li>
                                <li class="active">
                                    <span>Appointment History</span>
                                </li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg']);?>
                                <?php echo htmlentities($_SESSION['msg']="");?></p>	
                                
                                <!-- Search Form -->
                                <form method="GET" action="" class="mb-3">
                                    <div class="form-group">
                                        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search by Patient Name, Specialization, Appointment Date, or Status" value="<?php echo htmlentities($search); ?>" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>

                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">No.</th>
                                            <th class="hidden-xs">Patient Name</th>
                                            <th>Specialization</th>
                                            <th>&nbsp;</th>
                                            <th>Appointment Date / Time</th>
                                            <th>Appointment Creation Date</th>
                                            <th>Current Status</th>
                                            <th>Booking Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
// Modify SQL query to include search functionality
$sql = "SELECT users.fullName AS fname, appointment.* 
        FROM appointment 
        JOIN users ON users.id = appointment.userId 
        WHERE appointment.doctorId = '" . $_SESSION['id'] . "'";

if (!empty($search)) { // Check if search is not empty
    $sql .= " AND (users.fullName LIKE '%$search%' 
              OR appointment.doctorSpecialization LIKE '%$search%' 
              OR appointment.appointmentDate LIKE '%$search%' 
              OR (CASE 
                    WHEN appointment.userStatus = 1 AND appointment.doctorStatus = 1 THEN 'Active' 
                    WHEN appointment.userStatus = 0 AND appointment.doctorStatus = 1 THEN 'Canceled by Patient' 
                    WHEN appointment.userStatus = 1 AND appointment.doctorStatus = 0 THEN 'Canceled by you' 
                    ELSE 'Unknown' 
                  END) LIKE '%$search%')";
}

$result = mysqli_query($con, $sql);
$cnt = 1;
while ($row = mysqli_fetch_array($result)) {
?>
                                        <tr>
                                            <td class="center"><?php echo $cnt;?>.</td>
                                            <td class="hidden-xs"><?php echo $row['fname'];?></td>
                                            <td><?php echo $row['doctorSpecialization'];?></td>
                                            <td>&nbsp;</td>
                                            <td><?php echo $row['appointmentDate'];?> / <?php echo $row['appointmentTime'];?></td>
                                            <td><?php echo $row['postingDate'];?></td>
                                            <td>
<?php 
if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) {
    echo "Active";
} elseif (($row['userStatus'] == 0) && ($row['doctorStatus'] == 1)) {
    echo "Canceled by Patient";
} elseif (($row['userStatus'] == 1) && ($row['doctorStatus'] == 0)) {
    echo "Canceled by you";
}
?>
                                            </td>
                                            <td><?php echo $row['bookingStatus'];?></td>
                                            <td>
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
        <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
            <?php if ($row['bookingStatus'] == 'Approved' || $row['bookingStatus'] == 'Completed') { ?>
                <button class="btn btn-danger btn-xs" title="Cancel Appointment" disabled>Cancel</button>
            <?php } else { ?>
                <a href="appointment-history.php?id=<?php echo $row['id']?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment?')" class="btn btn-danger btn-xs" title="Cancel Appointment">Cancel</a>
            <?php } ?>
        <?php } else {
            echo "Canceled";
        } ?>

        <!-- Approve and Complete buttons -->
        <?php if ($row['bookingStatus'] == 'Pending') { ?>
            <a href="appointment-history.php?id=<?php echo $row['id']?>&approve=update" class="btn btn-success btn-xs" style="margin-top: 5px;" title="Approve Appointment">Approve</a>
        <?php } elseif ($row['bookingStatus'] == 'Approved') { ?>
            <a href="appointment-history.php?id=<?php echo $row['id']?>&complete=update" class="btn btn-warning btn-xs" style="margin-top: 5px;" title="Complete Appointment">Complete</a>
        <?php } ?>
    </div>
                                            </td>
                                        </tr>
<?php 
    $cnt++;
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('include/footer.php');?>
        <?php include('include/setting.php');?>
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
