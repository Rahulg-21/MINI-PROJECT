<?php
session_start();
include '../CONFIG/config.php';

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Enable debug logs (optional)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Fetch districts
$districts = $conn->query("SELECT id, name FROM districts ORDER BY name ASC");

// ✅ Handle form submit
if (isset($_POST['submit'])) {
    $district_id = mysqli_real_escape_string($conn, $_POST['district_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id'];

    // File upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_folder = "../ADMIN/uploads/tourist_spots/" . $image;

    if (!file_exists('../ADMIN/uploads/tourist_spots/')) {
        mkdir('../ADMIN/uploads/tourist_spots/', 0777, true);
    }

    if (!empty($district_id) && !empty($name) && !empty($image) && !empty($description)) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($image_tmp, $upload_folder)) {
                $query = "INSERT INTO tourist_spots (district_id, name, image, description, status) 
                          VALUES ('$district_id', '$name', '$image', '$description', 'Pending')";
                if (mysqli_query($conn, $query)) {
                    echo '<script>alert("✅ Tourist spot submitted successfully! Waiting for admin approval.");</script>';
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
            <h5 class="mb-4">🏞️ Add Tourist Spot</h5>

            <form method="post" enctype="multipart/form-data" id="touristForm" novalidate>

                <!-- District -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Select District</label>
                    <div class="col-sm-8">
                        <select name="district_id" id="district_id" class="form-select" required>
                            <option value="">*** Select District ***</option>
                            <?php while ($row = $districts->fetch_assoc()) { ?>
                                <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['name']); ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback">Please select a district.</div>
                    </div>
                </div>

                <!-- Tourist Spot Name -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tourist Spot Name</label>
                    <div class="col-sm-8">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter tourist spot name" required>
                        <div class="invalid-feedback">Name must be 3–50 characters (letters, spaces only).</div>
                    </div>
                </div>

                <!-- Image -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Image</label>
                    <div class="col-sm-8">
                        <input type="file" name="image" id="image" accept="image/*" class="form-control" required>
                        <div id="imageFeedback" class="form-text text-muted">Only JPG, PNG, or JPEG under 2MB allowed.</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter description (min 20 characters)" required></textarea>
                        <div class="invalid-feedback">Description must be at least 20 characters.</div>
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

<!-- ✅ Real-time validation -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("touristForm");
    const district = document.getElementById("district_id");
    const name = document.getElementById("name");
    const image = document.getElementById("image");
    const description = document.getElementById("description");
    const imageFeedback = document.getElementById("imageFeedback");

    // Validators
    const isNameValid = v => /^[A-Za-z\s]{3,50}$/.test(v);
    const isDescriptionValid = v => v.trim().length >= 20;
    const isImageValid = file => {
        if (!file) return false;
        const allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        const sizeOK = file.size <= 2 * 1024 * 1024; // 2MB
        return allowed.includes(file.type) && sizeOK;
    };

    // Utility
    const setValidity = (el, valid) => {
        el.classList.toggle("is-valid", valid);
        el.classList.toggle("is-invalid", !valid);
    };

    // Real-time checks
    name.addEventListener("input", () => setValidity(name, isNameValid(name.value)));
    description.addEventListener("input", () => setValidity(description, isDescriptionValid(description.value)));
    district.addEventListener("change", () => setValidity(district, district.value !== ""));
    image.addEventListener("change", () => {
        const file = image.files[0];
        if (!file) return setValidity(image, false);
        if (!isImageValid(file)) {
            setValidity(image, false);
            imageFeedback.textContent = "❌ Invalid file (must be JPG/PNG under 2MB)";
            imageFeedback.className = "form-text text-danger";
        } else {
            setValidity(image, true);
            imageFeedback.textContent = "✅ Image looks good!";
            imageFeedback.className = "form-text text-success";
        }
    });

    // Final submit check
    form.addEventListener("submit", e => {
        const valid =
            district.value !== "" &&
            isNameValid(name.value) &&
            isDescriptionValid(description.value) &&
            image.files.length > 0 &&
            isImageValid(image.files[0]);

        if (!valid) {
            e.preventDefault();
            alert("⚠️ Please correct the highlighted fields before submitting.");
            form.classList.add("was-validated");
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
