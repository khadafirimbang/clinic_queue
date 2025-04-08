<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
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
                                <h1 class="mainTitle"><strong>Appointment History</strong></h1>
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
                                        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search by Doctor Name, Patient Name, Specialization, Appointment Date, or Status" value="<?php echo htmlentities($search); ?>" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>

                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">No.</th>
                                            <th class="hidden-xs">Doctor Name</th>
                                            <th>Patient Name</th>
                                            <th>Specialization/Laboratory</th>
                                            <th>&nbsp;</th>
                                            <th>Appointment Date / Time</th>
                                            <th>Appointment Creation Date</th>
                                            <th>Current Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
// Modify SQL query to include search functionality
$sql = "SELECT doctors.doctorName AS docname, users.fullName AS pname, appointment.* 
        FROM appointment 
        JOIN doctors ON doctors.id = appointment.doctorId 
        JOIN users ON users.id = appointment.userId";

if (!empty($search)) { // Check if search is not empty
    $sql .= " WHERE doctors.doctorName LIKE '%$search%' 
              OR users.fullName LIKE '%$search%' 
              OR appointment.doctorSpecialization LIKE '%$search%' 
              OR appointment.appointmentDate LIKE '%$search%' 
              OR (CASE 
                    WHEN appointment.userStatus = 1 AND appointment.doctorStatus = 1 THEN 'Active' 
                    WHEN appointment.userStatus = 0 AND appointment.doctorStatus = 1 THEN 'Canceled by Patient' 
                    WHEN appointment.userStatus = 1 AND appointment.doctorStatus = 0 THEN 'Canceled by Doctor' 
                    ELSE 'Unknown' 
                  END) LIKE '%$search%'";
}

$result = mysqli_query($con, $sql);
$cnt = 1;
while ($row = mysqli_fetch_array($result)) {
?>
                                        <tr>
                                            <td class="center"><?php echo $cnt;?>.</td>
                                            <td class="hidden-xs"><?php echo $row['docname'];?></td>
                                            <td class="hidden-xs"><?php echo $row['pname'];?></td>
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
    echo "Canceled by Doctor";
}
?>
                                            </td>
                                            <td>
                                                <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                    <?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { 
                                                        echo "No Action yet"; 
                                                    } else {
                                                        echo "Canceled"; 
                                                    } ?>
                                                </div>
                                                <div class="visible-xs visible-sm hidden-md hidden-lg">
                                                    <div class="btn-group" dropdown is-open="status.isopen">
                                                        <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
                                                            <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                                            <li><a href="#">Edit</a></li>
                                                            <li><a href="#">Share</a></li>
                                                            <li><a href="#">Remove</a></li>
                                                        </ul>
                                                    </div>
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
