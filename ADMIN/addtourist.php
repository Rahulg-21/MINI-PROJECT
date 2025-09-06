<?php
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch districts for dropdown
$districts = $conn->query("SELECT id, name FROM districts ORDER BY name ASC");

if (isset($_POST['submit'])) {
    $district_id = mysqli_real_escape_string($conn, $_POST['district_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // File upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "uploads/tourist_spots/" . $image;

    // Create folder if not exists
    if (!file_exists('uploads/tourist_spots/')) {
        mkdir('uploads/tourist_spots/', 0777, true);
    }

    if (!empty($district_id) && !empty($name) && !empty($image) && !empty($description)) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($image_tmp, $upload_folder)) {
                // Insert into DB
                $query = "INSERT INTO tourist_spot (district_id, name, image, description) 
                          VALUES ('$district_id', '$name', '$image', '$description')";
                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    echo '<script>alert("Tourist spot added successfully!");</script>';
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

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i> Add Tourist Spot
            </li>
        </ol>

        <div class="grid-form">
            <div class="grid-form1">
                <h3>Add Tourist Spot</h3>
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    
                    <!-- District -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Select District</label>
                        <div class="col-sm-8">
                            <select name="district_id" class="form-control" required>
                                <option value="">***Select District***</option>
                                <?php while ($row = $districts->fetch_assoc()) { ?>
                                    <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tourist Spot Name -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tourist Spot Name</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" placeholder="Enter tourist spot name" required>
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
                            <button type="submit" name="submit" class="btn btn-primary">Add Tourist Spot</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        <div class="inner-block"></div>

        <div class="copyrights">
            <p>Kerala Tourism. All Rights Reserved | <a href="#">Kerala Tourism</a></p>
        </div>
    </div>
</div>

<?php include 'components/navbar.php'; ?>
</body>
</html>
