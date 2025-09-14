<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include '../CONFIG/config.php';

$guide_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("
    SELECT g.*, 
           ts.name AS spot_name, ts.image AS spot_image,
           d.name AS district_name 
    FROM guides g
    LEFT JOIN tourist_spots ts ON g.spot_id = ts.id
    LEFT JOIN districts d ON g.district_id = d.id
    WHERE g.id = ?
");
$stmt->bind_param("i", $guide_id);
$stmt->execute();
$guide = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<?php include 'components/head.php'; ?>
<body>
<?php include 'components/navbar.php'; ?>

<div class="container py-5">
    <?php if ($guide): ?>
        <div class="card shadow-lg p-4">
            <div class="row g-4 align-items-center">
                <!-- Guide Image -->
                <div class="col-md-4 text-center">
                    <img src="<?php echo !empty($guide['image']) ? '../GUIDE/uploads/guides/'.$guide['image'] : 'assets/default_guide.png'; ?>" 
                         class="rounded-circle border shadow"
                         style="width:180px; height:180px; object-fit:cover;" alt="Guide">
                </div>

                <!-- Guide Info -->
                <div class="col-md-8">
                    <h3 class="fw-bold mb-2"><?php echo $guide['first_name'].' '.$guide['last_name']; ?></h3>
                    <p class="mb-1"><strong>Email:</strong> <?php echo $guide['email']; ?></p>
                    <p class="mb-1"><strong>Mobile:</strong> <?php echo $guide['mobile']; ?></p>
                    <p class="mb-1"><strong>District:</strong> <?php echo $guide['district_name'] ?? 'N/A'; ?></p>
                    <p class="mb-1"><strong>Familiar Spot:</strong> <?php echo $guide['spot_name'] ?? 'All District'; ?></p>
                </div>
            </div>
            <hr>

            <!-- Spot Familiar Section -->
            <?php if (!empty($guide['spot_name'])): ?>
                <div class="mb-4">
                    <h5>Familiar with:</h5>
                    <div class="card" style="max-width:400px;">
                        <?php if (!empty($guide['spot_image'])): ?>
                            <img src="../ADMIN/uploads/tourist_spots/<?php echo $guide['spot_image']; ?>" 
                                 class="card-img-top" style="height:200px; object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h6 class="card-title"><?php echo $guide['spot_name']; ?></h6>
                            <p class="text-muted">Located in <?php echo $guide['district_name']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Booking Form -->
           <!-- Booking Form -->
<h5 class="mb-3">📅 Book This Guide</h5>
<form method="post" action="book_guide.php" class="row g-3">
    <input type="hidden" name="guide_id" value="<?php echo $guide['id']; ?>">

    <div class="col-12">
        <label class="form-label">Describe Your Trip / Spot</label>
         <input type="text" name="description" class="form-control" placeholder="Enter spot or description" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Select Date</label>
        <input type="date" name="booking_date" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Select Time</label>
        <input type="time" name="booking_time" class="form-control" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success w-100">Confirm Booking</button>
    </div>
</form>

        </div>
    <?php else: ?>
        <p class="text-danger">❌ Guide not found.</p>
    <?php endif; ?>
</div>

<?php include 'components/footer.php'; ?>
</body>
</html>
