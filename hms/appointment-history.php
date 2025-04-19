<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
} else {
    if(isset($_GET['cancel'])) {
        // Begin transaction
        mysqli_begin_transaction($con);
        
        try {
            // 1. Get the appointment details before cancelling
            $appointmentId = $_GET['id'];
            $query = "SELECT doctorSpecialization FROM appointment WHERE id = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "i", $appointmentId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $appointment = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            
            $specialization = $appointment['doctorSpecialization'];
            
            // 2. Update the appointment status
            $updateQuery = "UPDATE appointment SET userStatus='0', bookingStatus='Cancelled' WHERE id = ?";
            $stmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($stmt, "i", $appointmentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            // 3. Increment available slots for the specialization
            $updateSpecQuery = "UPDATE doctorspecilization 
                               SET avail_slots = avail_slots + 1 
                               WHERE specilization = ?";
            $stmt = mysqli_prepare($con, $updateSpecQuery);
            mysqli_stmt_bind_param($stmt, "s", $specialization);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            // Commit transaction
            mysqli_commit($con);
            $_SESSION['msg'] = "Your appointment has been cancelled successfully!";
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            mysqli_rollback($con);
            $_SESSION['msg'] = "Error cancelling appointment: " . $e->getMessage();
        }
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

                <div class="main-content" >
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
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th class="hidden-xs">Doctor Name</th>
                                                <th>Specialization</th>
                                                <th>&nbsp;</th>
                                                <th>Appointment Date / Time </th>
                                                <th>Reference ID</th>
                                                <th>Current Status</th>
                                                <th>Booking Status</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$sql=mysqli_query($con,"select doctors.doctorName as docname,appointment.*  from appointment join doctors on doctors.id=appointment.doctorId where appointment.userId='".$_SESSION['id']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>

                                            <tr>
                                                <td class="center"><?php echo $cnt;?>.</td>
                                                <td class="hidden-xs"><?php echo $row['docname'];?></td>
                                                <td><?php echo $row['doctorSpecialization'];?></td>
                                                <td>&nbsp;</td>
                                                <td><?php echo $row['appointmentDate'];?> / <?php echo
                                                 $row['appointmentTime'];?>
                                                </td>
                                                <td><?php echo $row['ref'];?></td>
                                                <td>
<?php if(($row['userStatus']==1) && ($row['doctorStatus']==1))  
{
    echo "Active";
}
if(($row['userStatus']==0) && ($row['doctorStatus']==1))  
{
    echo "Cancel by You";
}

if(($row['userStatus']==1) && ($row['doctorStatus']==0))  
{
    echo "Cancel by Doctor";
}



												?></td>
												<td><?php echo $row['bookingStatus'];?></td>
												<td >
												<div class="visible-md visible-lg hidden-sm hidden-xs">
											<?php if (($row['userStatus'] == 1) && ($row['doctorStatus'] == 1)) { ?>
												<?php if ($row['bookingStatus'] == 'Approved' || $row['bookingStatus'] == 'Completed') { ?>
													<button class="btn btn-danger btn-xs" title="Cancel Appointment" disabled>Cancel</button>
												<?php } else { ?>
													<button class="btn btn-warning btn-xs edit-btn" 
    data-id="<?php echo $row['id']; ?>" 
    data-specialization="<?php echo $row['doctorSpecialization']; ?>" 
    data-doctorid="<?php echo $row['doctorId']; ?>" 
    data-date="<?php echo $row['appointmentDate']; ?>" 
    data-time="<?php echo $row['appointmentTime']; ?>" 
    data-toggle="modal" 
    data-target="#editAppointmentModal">Edit</button>

													<a href="appointment-history.php?id=<?php echo $row['id']?>&cancel=update" onClick="return confirm('Are you sure you want to cancel this appointment?')" class="btn btn-danger btn-xs" title="Cancel Appointment">Cancel</a>
												<?php } ?>
											<?php } else {
												echo "Canceled";
											} ?>
										</div>
												<div class="visible-xs visible-sm hidden-md hidden-lg">
													<div class="btn-group" dropdown is-open="status.isopen">
														<button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" dropdown-toggle>
															<i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
														</button>
														<ul class="dropdown-menu pull-right dropdown-light" role="menu">
															<li>
																<a href="#">
																	Edit
																</a>
															</li>
															<li>
																<a href="#">
																	Share
																</a>
															</li>
															<li>
																<a href="#">
																	Remove
																</a>
															</li>
														</ul>
													</div>
												</div></td>
											</tr>
											
											<?php 
$cnt=$cnt+1;
											 }?>
											
											
										</tbody>
									</table>

									<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="editAppointmentModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editAppointmentModalLabel">Edit Appointment</h4>
            </div>
            <div class="modal-body">
                <form id="editAppointmentForm">
                    <input type="hidden" name="appointmentId" id="appointmentId">
                    <div class="form-group">
                        <label for="doctorSpecialization">Specialization</label>
                        <select name="doctorSpecialization" id="doctorSpecialization" class="form-control" required>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="doctorId">Doctor</label>
                        <select name="doctorId" id="doctorId" class="form-control" required>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointmentDate">Date</label>
                        <input type="date" class="form-control" name="appointmentDate" id="appointmentDate" required>
                    </div>
                    <div class="form-group">
                        <label for="appointmentTime">Time</label>
                        <input type="time" class="form-control" name="appointmentTime" id="appointmentTime" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

									<!-- End Edit Appointment Modal -->

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

		<!-- Previous HTML/PHP code remains the same until the JavaScript section -->
		<script src="assets/js/main.js"></script>

		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
				
				// First, load all specializations with available slots when page loads
				$.ajax({
					type: "POST",
					url: "get_specializations.php",
					success: function(data) {
						$('#doctorSpecialization').html(data);
					}
				});

				$(document).on('click', '.edit-btn', function() {
					var appointmentId = $(this).data('id');
					var doctorId = $(this).data('doctorid');
					var appointmentDate = $(this).data('date');
					var appointmentTime = $(this).data('time');
					var doctorSpecialization = $(this).data('specialization');

					// Set the basic values in the modal
					$('#appointmentId').val(appointmentId);
					$('#appointmentDate').val(appointmentDate);
					
					// Format time to HH:MM for the time input
					var formattedTime = formatTimeForInput(appointmentTime);
					$('#appointmentTime').val(formattedTime);
					
					// Set the specialization after ensuring options are loaded
					setTimeout(function() {
						$('#doctorSpecialization').val(doctorSpecialization);
						
						// Fetch doctors for the selected specialization
						$.ajax({
							type: "POST",
							url: "get_doctor.php",
							data: { 
								specilizationid: doctorSpecialization,
								currentDoctor: doctorId // Pass current doctor ID
							},
							success: function(data) {
								$('#doctorId').html(data);
								// Set the selected doctor
								$('#doctorId').val(doctorId);
							}
						});
					}, 300);
				});

				// Helper function to format time for time input
				function formatTimeForInput(timeString) {
					if (!timeString) return '';
					
					// Handle various time formats (e.g., "02:30 PM" or "14:30:00")
					var time = timeString.trim();
					var hours, minutes;
					
					// If time is in AM/PM format
					if (time.match(/[AP]M/i)) {
						var period = time.match(/[AP]M/i)[0];
						var parts = time.split(/[\s:]/);
						hours = parseInt(parts[0]);
						minutes = parseInt(parts[1]) || 0;
						
						if (period === 'PM' && hours < 12) hours += 12;
						if (period === 'AM' && hours === 12) hours = 0;
					} 
					// If time is in 24-hour format
					else {
						var parts = time.split(':');
						hours = parseInt(parts[0]);
						minutes = parseInt(parts[1]) || 0;
					}
					
					// Format to HH:MM
					return (hours < 10 ? '0' + hours : hours) + ':' + 
						   (minutes < 10 ? '0' + minutes : minutes);
				}

				// Handle form submission
				$('#editAppointmentForm').on('submit', function(e) {
					e.preventDefault();
					var formData = $(this).serialize();

					$.ajax({
						type: "POST",
						url: "update_appointment.php",
						data: formData,
						success: function(response) {
							alert(response);
							$('#editAppointmentModal').modal('hide');
							location.reload();
						},
						error: function(xhr, status, error) {
							alert("An error occurred: " + error);
						}
					});
				});

				// When specialization changes, fetch doctors
				$('#doctorSpecialization').change(function() {
					var specialization = $(this).val();
					if (!specialization) {
						$('#doctorId').html('<option value="">Select Doctor</option>');
						return;
					}
					
					$.ajax({
						type: "POST",
						url: "get_doctor.php",
						data: { specilizationid: specialization },
						success: function(data) {
							$('#doctorId').html(data);
						}
					});
				});
			});
		</script>
	</body>
</html>
<?php } ?>