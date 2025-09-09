<?php
include '../CONFIG/config.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $district_id = intval($_POST['district_id']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // File upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "uploads/emergency/" . $image;

    if (!file_exists('uploads/emergency/')) {
        mkdir('uploads/emergency/', 0777, true);
    }

    if (!empty($district_id) && !empty($type) && !empty($name)) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($image_tmp, $upload_folder)) {
                $query = "INSERT INTO emergency_services (district_id, type, name, contact, address, image, description) 
                          VALUES ('$district_id', '$type', '$name', '$contact', '$address', '$image', '$description')";
                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    echo '<script>alert("Emergency service added successfully!");</script>';
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
            <li class="breadcrumb-item active" aria-current="page">Add Emergency Service</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="container-fluid px-3">
        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-4">Add Emergency Service</h5>
            <form method="post" enctype="multipart/form-data">

                <!-- District -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">District</label>
                    <div class="col-sm-8">
                        <select name="district_id" class="form-select" required>
                            <option value="">***Select District***</option>
                            <?php
                            $districts = mysqli_query($conn, "SELECT id, name FROM districts ORDER BY name ASC");
                            while ($d = mysqli_fetch_assoc($districts)) {
                                echo '<option value="'.$d['id'].'">'.$d['name'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Type -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-8">
                        <select name="type" class="form-select" required>
                            <option value="">***Select Type***</option>
                            <option value="Hospital">Hospital</option>
                            <option value="Fire & Rescue">Fire & Rescue</option>
                            <option value="Ham Radio">Ham Radio</option>
                            <option value="Elephant Squad">Elephant Squad</option>
                            <option value="Police">Police</option>
                            <option value="Ambulance">Ambulance</option>
                            <option value="Coast Guard">Coast Guard</option>
                        </select>
                    </div>
                </div>

                <!-- Name -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" class="form-control" placeholder="Enter service name" required>
                    </div>
                </div>

                <!-- Contact -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Contact</label>
                    <div class="col-sm-8">
                        <input type="text" name="contact" class="form-control" placeholder="Enter contact number">
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Address</label>
                    <div class="col-sm-8">
                        <textarea name="address" rows="3" class="form-control" placeholder="Enter address"></textarea>
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
                        <textarea name="description" rows="4" class="form-control" placeholder="Enter description"></textarea>
                    </div>
                </div>

                <!-- Submit -->
                <div class="row">
                    <div class="col-sm-8 offset-sm-2">
                        <button type="submit" name="submit" class="btn btn-success">Add Service</button>
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
