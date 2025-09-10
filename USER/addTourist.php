<?php
session_start();
include '../CONFIG/config.php';

// ✅ Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Enable error reporting (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch districts for dropdown
$districts = $conn->query("SELECT id, name FROM districts ORDER BY name ASC");

if (isset($_POST['submit'])) {
    $district_id = mysqli_real_escape_string($conn, $_POST['district_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id']; // ✅ Track who submitted

    // File upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "../ADMIN/uploads/tourist_spots/" . $image;

    // Create folder if not exists
    if (!file_exists('../ADMIN/uploads/tourist_spots/')) {
        mkdir('../ADMIN/uploads/tourist_spots/', 0777, true);
    }

    if (!empty($district_id) && !empty($name) && !empty($image) && !empty($description)) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($image_tmp, $upload_folder)) {
                // ✅ Insert with status = Pending
                $query = "INSERT INTO tourist_spots (district_id, name, image, description, status) 
                          VALUES ('$district_id', '$name', '$image', '$description', 'Pending')";
                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    echo '<script>alert("Tourist spot submitted successfully! Waiting for admin approval.");</script>';
                } else {
                    echo '<script>alert("Database error: ' . mysqli_error($conn) . '");</script>';
                }
            } else {
                echo '<script>alert("Image upload failed.");</script>';
            }
        } else {
            echo '<script>alert("Error uploading image.");</script>';
        }
    } else {
        echo '<script>alert("Please fill in all fields.");</script>';
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
            <li class="breadcrumb-item active" aria-current="page">Add Tourist Spot</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="container-fluid px-3">
        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-4">Add Tourist Spot</h5>
            <form method="post" enctype="multipart/form-data">
                
                <!-- District -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Select District</label>
                    <div class="col-sm-8">
                        <select name="district_id" class="form-select" required>
                            <option value="">*** Select District ***</option>
                            <?php while ($row = $districts->fetch_assoc()) { ?>
                                <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Tourist Spot Name -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tourist Spot Name</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" placeholder="Enter tourist spot name" required>
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-8">
                        <input type="file" name="image" accept="image/*" class="form-control" required>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <textarea name="description" rows="5" class="form-control" placeholder="Enter description" required></textarea>
                    </div>
                </div>

                <!-- Submit -->
                <div class="row">
                    <div class="col-sm-8 offset-sm-2">
                        <button type="submit" name="submit" class="btn btn-success">Submit Spot</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
