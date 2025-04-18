<?php
// Include the database connection
include 'include/config.php';
session_start(); // Start the session to access user data

// Assuming you have a user ID stored in the session
$userId = $_SESSION['id']; // Get the logged-in user's ID

// SQL query to fetch data from the doctorspecilization table
$sql = "SELECT specilization, max_patients, avail_slots, open_time, close_time FROM doctorspecilization";
$result = $con->query($sql);

// SQL query to check if the user has already booked an appointment
$booking_check_sql = "SELECT COUNT(*) as booking_count FROM appointment WHERE userId = ? AND bookingStatus = 'Pending' OR bookingStatus = 'Approved'";
$stmt = $con->prepare($booking_check_sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$booking_result = $stmt->get_result();
$booking_row = $booking_result->fetch_assoc();
$has_booking = $booking_row['booking_count'] > 0;

// Start HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Slot List</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <style>
        .go-back-btn {
            margin-bottom: 15px;
        }
        .btn-red {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-red:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Appointment Slot List</h2>
        
        <!-- Go Back Button - Top Left above table -->
        <div class="go-back-btn">
            <a href="dashboard.php" class="btn btn-red">
                <i class="fa fa-arrow-left"></i> Go Back
            </a>
        </div>
        
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Specialization</th>
                        <th>Available Slots</th>
                        <th>Max Patients</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php 
                                $open_time_12hr = date('h:i A', strtotime($row['open_time']));
                                $close_time_12hr = date('h:i A', strtotime($row['close_time']));
                                echo htmlspecialchars($open_time_12hr . ' to ' . $close_time_12hr); 
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['specilization']); ?></td>
                            <td><?php echo htmlspecialchars($row['avail_slots']); ?></td>
                            <td><?php echo htmlspecialchars($row['max_patients']); ?></td>
                            <td>
                                <?php if ($has_booking): ?>
                                    <span class="text-danger">Already Booked</span>
                                <?php elseif ($row['avail_slots'] > 0): ?>
                                    <a href="book-appointment.php?specialization=<?php echo urlencode($row['specilization']); ?>" class="btn btn-primary">Book Now</a>
                                <?php else: ?>
                                    <span class="text-danger">Fully Booked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                No records found.
            </div>
        <?php endif; ?>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$con->close();
?>
