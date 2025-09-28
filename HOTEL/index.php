<?php 
session_start();
include 'components/head.php'; 
include '../CONFIG/config.php'; // DB connection

// ✅ Only allow logged-in hotel
if(!isset($_SESSION['hotel_id'])){
    header("Location: login.php");
    exit;
}

$hotel_id = $_SESSION['hotel_id'];

// Fetch hotel details
$stmt = $conn->prepare("SELECT h.*, d.name AS district_name, t.name AS spot_name 
                        FROM hotels h
                        LEFT JOIN districts d ON h.district_id = d.id
                        LEFT JOIN tourist_spots t ON h.spot_id = t.id
                        WHERE h.id=?");
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();

// Handle update
if(isset($_POST['update_profile'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];

    // Optional: file upload
    $image = $hotel['image']; // default existing image
    if(!empty($_FILES['image']['name'])){
        $targetDir = __DIR__ . "/uploads/hotels/";
        if(!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $image;

        if(!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
            $error = "❌ File upload failed. Check folder permissions.";
        }
    }

    if(!isset($error)){
        $update = $conn->prepare("UPDATE hotels 
                                  SET name=?, email=?, mobile=?, username=?, image=? 
                                  WHERE id=?");
        $update->bind_param("sssssi", $name, $email, $mobile, $username, $image, $hotel_id);

        if($update->execute()){
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: index.php");
            exit;
        } else {
            $error = "Something went wrong while updating!";
        }
    }
}

// Fetch monthly booking counts
$chartStmt = $conn->prepare("
    SELECT DATE_FORMAT(hb.created_at, '%Y-%m') AS month, COUNT(*) AS total_bookings
    FROM hotel_bookings hb
    JOIN hotel_rooms hr ON hb.room_id = hr.id
    JOIN users u ON hb.user_id = u.id
    WHERE hb.hotel_id=? AND hb.status='Confirmed'
    GROUP BY DATE_FORMAT(hb.created_at, '%Y-%m')
    ORDER BY month ASC
");
$chartStmt->bind_param("i", $hotel_id);
$chartStmt->execute();
$chartResult = $chartStmt->get_result();

$months = [];
$bookings = [];
while($row = $chartResult->fetch_assoc()){
    $months[] = $row['month'];
    $bookings[] = (int)$row['total_bookings'];
}

?>

<body>
<?php include 'components/navbar.php'; ?>

<div class="content">
    <div class="pt-4"></div>

 <!-- Hotel Dashboard -->
<div class="container my-4">
    <div class="card shadow-sm p-4">
        <h4 class="mb-3">🏨 Hotel Dashboard</h4>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Profile Details -->
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?php echo !empty($hotel['image']) 
                    ? 'uploads/hotels/' . htmlspecialchars($hotel['image']) 
                    : 'assets/default_hotel.png'; ?>" 
                 width="150" height="120" style="object-fit:cover;">
                <p class="fw-bold text-success">Status: <?php echo $hotel['status']; ?></p>
            </div>
            <div class="col-md-8">
                <p><strong>Hotel Name:</strong> <?php echo $hotel['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $hotel['email']; ?></p>
                <p><strong>Mobile:</strong> <?php echo $hotel['mobile']; ?></p>
                <p><strong>Username:</strong> <?php echo $hotel['username']; ?></p>
                <p><strong>District:</strong> <?php echo $hotel['district_name']; ?></p>
                <p><strong>Nearby Spot:</strong> <?php echo $hotel['spot_name']; ?></p>
            </div>
        </div>
        
        <!-- Update Button -->
        <div class="mt-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateModal">
                ✏️ Update Profile
            </button>
        </div>
    </div>

    <!-- Monthly Bookings Chart (✅ OUTSIDE the modal now) -->
    <div class="card shadow-sm p-4 mt-4">
        <h5 class="mb-3">📊 Monthly Booking Statistics</h5>
        <canvas id="bookingChart" height="120"></canvas>
    </div>
</div>


    <!-- Update Profile Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Hotel Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $hotel['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $hotel['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo $hotel['mobile']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $hotel['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Hotel Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
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
        <p class="mb-0">Kerala Tourism Hotels. All Rights Reserved.</p>
    </div>
</div>

<!-- Scripts -->
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('bookingChart').getContext('2d');
const bookingChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Confirmed Bookings',
            data: <?php echo json_encode($bookings); ?>,
            borderColor: 'rgba(46, 125, 50, 1)',
            backgroundColor: 'rgba(102, 187, 106, 0.2)',
            borderWidth: 2,
            tension: 0.3,
            fill: true,
            pointBackgroundColor: 'rgba(46, 125, 50, 1)',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            tooltip: { enabled: true }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
