<?php
session_start();
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ Ensure hotel owner is logged in
if (!isset($_SESSION['hotel_id'])) {
    echo "<script>alert('Login first'); window.location='login.php';</script>";
    exit();
}

$hotel_id = $_SESSION['hotel_id'];

if (isset($_POST['submit'])) {
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $total_rooms = intval($_POST['total_rooms']);
    $available_rooms = intval($_POST['available_rooms']);

    // Default available rooms to total rooms if empty
    if (empty($available_rooms)) {
        $available_rooms = $total_rooms;
    }

    if (!empty($room_type) && !empty($price) && !empty($total_rooms)) {
        $query = "INSERT INTO hotel_rooms (hotel_id, room_type, description, price, total_rooms, available_rooms, created_at) 
                  VALUES ('$hotel_id', '$room_type', '$description', '$price', '$total_rooms', '$available_rooms', NOW())";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo '<script>alert("Hotel room added successfully!");</script>';
        } else {
            echo '<script>alert("Database error: ' . mysqli_error($conn) . '");</script>';
        }
    } else {
        echo '<script>alert("Please fill in all required fields.");</script>';
    }
}
?>

<?php include 'components/head.php'; ?>
<body>
<?php include 'components/navbar.php'; ?>

<div class="content">
    <div class="pt-4"></div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="px-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Hotel Room</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="container-fluid px-3">
        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-4">Add Room for Your Hotel</h5>
            <form method="post">

                <!-- Hidden Hotel ID -->
                <input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">

                <!-- Room Type -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Room Type</label>
                    <div class="col-sm-8">
                        <input type="text" name="room_type" class="form-control" placeholder="e.g. Deluxe, Suite" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <textarea name="description" rows="4" class="form-control" placeholder="Enter room description"></textarea>
                    </div>
                </div>

                <!-- Price -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Price (₹)</label>
                    <div class="col-sm-8">
                        <input type="number" name="price" class="form-control" step="0.01" placeholder="Enter price per night" required>
                    </div>
                </div>

                <!-- Total Rooms -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Total Rooms</label>
                    <div class="col-sm-8">
                        <input type="number" name="total_rooms" class="form-control" placeholder="Enter total number of rooms" required>
                    </div>
                </div>

                <!-- Available Rooms -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Available Rooms</label>
                    <div class="col-sm-8">
                        <input type="number" name="available_rooms" class="form-control" placeholder="Enter available rooms (optional)">
                    </div>
                </div>

                <!-- Submit -->
                <div class="row">
                    <div class="col-sm-8 offset-sm-2">
                        <button type="submit" name="submit" class="btn btn-primary">Add Room</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="copyrights mt-4 text-center py-2 bg-light">
        <p class="mb-0">Kerala Tourism. All Rights Reserved | <a href="#">Kerala Tourism</a></p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
