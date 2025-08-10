<?php
include '../config.php'; // Your DB connection file

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
<div class="page-container">
    <div class="left-content">
        <?php include 'components/top-bar.php'; ?>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i> Update Page Data
            </li>
        </ol>

        <div class="grid-form">
            <div class="grid-form1">
                <h3>Update Page Data</h3>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    
                    <!-- Category -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Select Page</label>
                        <div class="col-sm-8">
                            <select name="category" class="form-control" required>
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
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-8">
                            <input type="text" name="title" class="form-control" placeholder="Enter title" required>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-8">
                            <input type="file" name="image" accept="image/*" class="form-control" required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-8">
                            <textarea name="description" rows="5" class="form-control" placeholder="Enter description" required></textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="inner-block"></div>

        <div class="copyrights">
            <p>TMS. All Rights Reserved | <a href="#">TMS</a></p>
        </div>
    </div>
</div>

<?php include 'components/navbar.php'; ?>
</body>
</html>
