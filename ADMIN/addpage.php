<?php
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['submit'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // File upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "uploads/pages/" . $image;

    // Create folder if not exists
    if (!file_exists('uploads/pages/')) {
        mkdir('uploads/pages/', 0777, true);
    }

    if (!empty($category) && !empty($title) && !empty($image) && !empty($description)) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($image_tmp, $upload_folder)) {
                // Insert into DB
                $query = "INSERT INTO pages (category, title, image, description) 
                          VALUES ('$category', '$title', '$image', '$description')";
                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    echo '<script>alert("Page data saved successfully!");</script>';
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
    <!-- Top padding for fixed navbar -->
    <div class="pt-4"></div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="px-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Page Data</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="container-fluid px-3">
        <div class="card shadow-sm p-4 mb-4">
            <h5 class="mb-4">Update Page Data</h5>
            <form method="post" enctype="multipart/form-data">
                
                <!-- Category -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Select Page</label>
                    <div class="col-sm-8">
                        <select name="category" class="form-select" required>
                            <option value="">***Select One***</option>
                            <option value="Activity">Activity</option>
                            <option value="Culture">Culture</option>
                            <option value="Wedding Destinations">Wedding Destinations</option>
                            <option value="Souvenir">Souvenir</option>
                            <option value="Food">Food</option>
                        </select>
                    </div>
                </div>

                <!-- Title -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-8">
                        <input type="text" name="title" class="form-control" placeholder="Enter title" required>
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
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
