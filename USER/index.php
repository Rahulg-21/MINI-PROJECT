<?php 
session_start();
include 'components/head.php'; 
include '../CONFIG/config.php'; // your DB connection file

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle update
if(isset($_POST['update_profile'])){
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];

    $update = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, mobile=?, username=? WHERE id=?");
    $update->bind_param("sssssi", $fname, $lname, $email, $mobile, $username, $user_id);
    if($update->execute()){
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Something went wrong!";
    }
}
?>

<body>
<?php include 'components/navbar.php'; ?>

<div class="content">
    <div class="pt-4"></div>

    <!-- Profile Section -->
    <div class="container my-4">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3">👤 My Profile</h4>
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <p><strong>Name:</strong> <?php echo $user['first_name'].' '.$user['last_name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Mobile:</strong> <?php echo $user['mobile']; ?></p>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            
            <!-- Update Button -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateModal">Update Profile</button>
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
                        <input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo $user['mobile']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
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

<!-- Scripts -->
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
