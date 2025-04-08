<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id'])==0) {
    header('location:logout.php');
} else {
    if(isset($_GET['del'])) {
        $labId = $_GET['id'];
        mysqli_query($con, "DELETE FROM prenatal_lab_form WHERE id ='$labId'");
        $_SESSION['msg'] = "Data deleted !!";
    }

    // Initialize search variable
    $search = '';
    if (isset($_GET['search'])) {
        $search = mysqli_real_escape_string($con, $_GET['search']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Prenatal Laboratory Data</title>
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
        function resetSearch() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput.value === '') {
                window.location.href = window.location.pathname;
            }
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
                                <h1 class="mainTitle"><strong>View Prenatal Laboratory Data</strong></h1>
                            </div>
                            <ol class="breadcrumb">
                                <li></li>
                                <li class="active">
                                    <span>Manage Prenatal Laboratory</span>
                                </li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">&nbsp;</h5>
                                <p style="color:red;"><?php echo htmlentities($_SESSION['msg']);?>
                                <?php echo htmlentities($_SESSION['msg']="");?></p>	

                                <!-- Search Form -->
                                <form method="GET" action="">
                                    <div class="form-group">
                                        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search by Patient Name or Laboratory" value="<?php echo htmlentities($search); ?>" oninput="resetSearch()" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                                <br>

                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">No.</th>
                                            <th>Laboratory Name</th>
                                            <th>Patient Name</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
// Modify SQL query to include search functionality
$sql = "SELECT * FROM prenatal_lab_form";
if ($search != '') {
    $sql .= " WHERE fullName LIKE '%$search%' OR labName LIKE '%$search%'";
}
$result = mysqli_query($con, $sql);
$cnt = 1;
while($row = mysqli_fetch_array($result)) {
?>
                                        <tr onclick="window.location='edit-prenatal.php?id=<?php echo $row['id'];?>';" style="cursor:pointer;">
                                            <td class="center"><?php echo $cnt;?>.</td>
                                            <td><?php echo $row['labName'];?></td>
                                            <td><?php echo $row['fullName'];?></td>
                                            <td><?php echo $row['date'];?></td>
                                            <td>
                                                <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                    <a href="edit-prenatal.php?id=<?php echo $row['id'];?>" class="btn btn-transparent btn-xs" tooltip-placement="top" tooltip="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a href="manage-prenatal.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete this record?')" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>
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
