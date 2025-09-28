<?php 
session_start();
include 'components/head.php'; 
include '../CONFIG/config.php'; // DB connection

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ Only allow logged-in guide
if(!isset($_SESSION['guide_id'])){
    header("Location: login.php");
    exit;
}

$guide_id = $_SESSION['guide_id'];

// Fetch guide details
$stmt = $conn->prepare("SELECT g.*, d.name AS district_name, t.name AS spot_name 
                        FROM guides g
                        LEFT JOIN districts d ON g.district_id = d.id
                        LEFT JOIN tourist_spots t ON g.spot_id = t.id
                        WHERE g.id=?");
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$result = $stmt->get_result();
$guide = $result->fetch_assoc();

// Handle update
if(isset($_POST['update_profile'])){
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];

    $update = $conn->prepare("UPDATE guides 
                              SET first_name=?, last_name=?, email=?, mobile=?, username=? 
                              WHERE id=?");
    $update->bind_param("sssssi", $fname, $lname, $email, $mobile, $username, $guide_id);

    if($update->execute()){
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Something went wrong while updating!";
    }
}



// ✅ Fetch monthly booking counts for this guide
$booking_stmt = $conn->prepare("
    SELECT DATE_FORMAT(gb.booking_date, '%Y-%m') AS month, COUNT(*) AS total 
    FROM guide_bookings gb
    WHERE gb.guide_id = ?
    GROUP BY DATE_FORMAT(gb.booking_date, '%Y-%m')
    ORDER BY month ASC
");
$booking_stmt->bind_param("i", $guide_id);
$booking_stmt->execute();
$booking_result = $booking_stmt->get_result();

$months = [];
$totals = [];
while($row = $booking_result->fetch_assoc()){
    $months[] = $row['month'];
    $totals[] = $row['total'];
}


?>

<body>
<?php include 'components/navbar.php'; ?>

<div class="content">
    <div class="pt-4"></div>

    <!-- Guide Dashboard -->
    <div class="container my-4">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3">👨‍💼 Guide Dashboard</h4>
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Profile Details -->
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="<?php echo !empty($guide['image']) 
        ? '../GUIDE/uploads/guides/' . htmlspecialchars($guide['image']) 
        : 'assets/default_guide.png'; ?>" 
     width="80" height="60" style="object-fit:cover;">

                    <p class="fw-bold text-success">Status: <?php echo $guide['status']; ?></p>
                </div>
                <div class="col-md-8">
                    <p><strong>Name:</strong> <?php echo $guide['first_name'].' '.$guide['last_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $guide['email']; ?></p>
                    <p><strong>Mobile:</strong> <?php echo $guide['mobile']; ?></p>
                    <p><strong>Username:</strong> <?php echo $guide['username']; ?></p>
                    <p><strong>District:</strong> <?php echo $guide['district_name']; ?></p>
                    <p><strong>Tourist Spot:</strong> <?php echo $guide['spot_name']; ?></p>
                </div>
            </div>
            
            <!-- Update Button -->
            <div class="mt-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateModal">✏️ Update Profile</button>
            </div>
        </div>
    </div>
    <!-- Monthly Booking Chart -->
<div class="container my-5">
    <div class="card shadow-sm p-4">
        <h5 class="mb-3">📊 Monthly Bookings</h5>
        <canvas id="bookingChart" height="120"></canvas>
    </div>
</div>


    <!-- Update Profile Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo $guide['first_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo $guide['last_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $guide['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo $guide['mobile']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $guide['username']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_profile" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="copyrights mt-4 text-center py-2 bg-light">
        <p class="mb-0">Kerala Tourism. All Rights Reserved | <a href="#">Kerala Tourism</a></p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('bookingChart').getContext('2d');
const bookingChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Total Bookings',
            data: <?php echo json_encode($totals); ?>,
            backgroundColor: 'rgba(25, 135, 84, 0.6)',
            borderColor: 'rgba(25, 135, 84, 1)',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>


<!-- Scripts -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
