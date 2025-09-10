<?php 
session_start();
  if (!isset($_SESSION['user_id'])) {
         echo "<script>
                        alert('Login First');
                        window.location='map.php';
                      </script>";
                exit();
}
include 'components/head.php'; 
include '../CONFIG/config.php'; 



// Get tourist spot id
$spot_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If user not logged in, redirect
  

    $user_id = $_SESSION['user_id'];
    $spot_id = intval($_POST['spot_id']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Combine date + time into one DateTime object
    $visit_datetime = strtotime($date . ' ' . $time);
    $now = time();

    if ($visit_datetime < $now) {
        // ❌ User selected a past date/time
        $error_message = "You cannot book a visit in the past. Please select a valid date and time.";
    } else {
        // Fetch district id from tourist_spots
        $stmt = $conn->prepare("SELECT district_id FROM tourist_spots WHERE id = ?");
        $stmt->bind_param("i", $spot_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $district_id = $result['district_id'] ?? 0;
        $stmt->close();

        // Insert into bookings
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, spot_id, district_id, visit_date, visit_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $user_id, $spot_id, $district_id, $date, $time);

        if ($stmt->execute()) {
            // ✅ Booking successful
            $success_message = "Your booking has been confirmed! You will receive updates via email.";
        } else {
            $error_message = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}





// Fetch tourist spot
$stmt = $conn->prepare("SELECT * FROM tourist_spots WHERE id = ?");
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$spot = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch emergency services for same district
$district_id = $spot['district_id'];
$eservices = $conn->query("SELECT * FROM emergency_services WHERE district_id = $district_id")->fetch_all(MYSQLI_ASSOC);
?>

<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<br><br><br>
<section id="news_details_main_arae" class="section_padding">
    <div class="container">
        <div class="row">
            <!-- Tourist Spot Details -->
            <div class="col-lg-8">
                <div class="news_detail_wrapper">
                    <div class="news_details_content_area">
                        <img src="../ADMIN/uploads/tourist_spots/<?php echo $spot['image']; ?>" 
                             alt="<?php echo $spot['name']; ?>" class="img-fluid mb-3">
                        <h2><?php echo $spot['name']; ?></h2>
                        <p><?php echo $spot['description']; ?></p>
                    </div>
                </div>

                <!-- Horizontal Hotel Cards -->
                <h3 class="mt-5 mb-3">Nearby Hotels</h3>
                <div class="d-flex overflow-auto pb-3" style="gap:15px;">
                    <?php 
                    $hotels = [
                        ["name"=>"Hotel Elite","img"=>"assets/img/hotel/hotel-1.jpg","link"=>"#"],
                        ["name"=>"Grand Palace","img"=>"assets/img/hotel/hotel-2.jpg","link"=>"#"],
                        ["name"=>"Sea Breeze","img"=>"assets/img/hotel/hotel-3.jpg","link"=>"#"],
                        ["name"=>"Hill View","img"=>"assets/img/hotel/hotel-1.jpg","link"=>"#"],
                        ["name"=>"Hotel Elite","img"=>"assets/img/hotel/hotel-2.jpg","link"=>"#"],
                        ["name"=>"Grand Palace","img"=>"assets/img/hotel/hotel-3.jpg","link"=>"#"],
                        ["name"=>"Sea Breeze","img"=>"assets/img/hotel/hotel-1.jpg","link"=>"#"]
                    ];
                    foreach($hotels as $h){
                        echo '
                        <div class="card" style="min-width:200px;">
                            <img src="'.$h['img'].'" class="card-img-top" alt="'.$h['name'].'">
                            <div class="card-body">
                                <h6 class="card-title">'.$h['name'].'</h6>
                                <a href="'.$h['link'].'" class="btn btn-success btn-sm">View</a>
                            </div>
                        </div>';
                    }
                    ?>
                </div>

                <!-- Emergency Services -->
                <h3 class="mt-5 mb-3">Emergency Services</h3>
                <div class="row">
                    <?php foreach($eservices as $e){ ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <?php if($e['image']){ ?>
                                    <img src="../ADMIN/uploads/emergency/<?php echo $e['image']; ?>" 
                                         class="card-img-top" alt="<?php echo $e['name']; ?>">
                                <?php } ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $e['name']; ?></h5>
                                    <p class="card-text"><?php echo $e['description']; ?></p>
                                    <p><strong>Contact:</strong> <?php echo $e['contact']; ?></p>
                                    <p><strong>Type:</strong> <?php echo $e['type']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                
                <div class="news_details_right_item mb-4">
                    <h3>Plan Your Visit</h3>
                    <form action="" method="POST">
                        <?php if (!empty($success_message)): ?>
    <div class="alert alert-success"><?php echo $success_message; ?></div>
<?php endif; ?>
<?php if (!empty($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                        <input type="hidden" name="spot_id" value="<?php echo $spot['id']; ?>">
                        <div class="form-group mb-3">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Time</label>
                            <input type="time" name="time" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">SUBMIT</button>
                    </form>
                </div>

                <!-- Guides List -->
<div class="news_details_right_item">
    <h3>Available Guides</h3>
    <div class="overflow-auto" style="max-height: 300px; padding-right: 5px;">
        <?php 
        $guides = [
            ["name"=>"Ramesh","img"=>"assets/img/tour-guides/g1.jpg","link"=>"#"],
            ["name"=>"Anil","img"=>"assets/img/tour-guides/g2.jpg","link"=>"#"],
            ["name"=>"Suresh","img"=>"assets/img/tour-guides/g3.jpg","link"=>"#"],
            ["name"=>"Ramesh","img"=>"assets/img/tour-guides/g1.jpg","link"=>"#"],
            ["name"=>"Anil","img"=>"assets/img/tour-guides/g2.jpg","link"=>"#"]
        ];
        foreach($guides as $g){
            echo '
            <div class="card mb-2 shadow-sm" style="border:1px solid #ddd;">
                <div class="d-flex align-items-center p-2">
                    <img src="'.$g['img'].'" style="width:50px; height:50px; object-fit:cover; border-radius:50%;" alt="'.$g['name'].'">
                    <h6 class="ms-3 mb-0">'.$g['name'].'</h6>
                </div>
            </div>';
        }
        ?>
    </div>
</div>


            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>
