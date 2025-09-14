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

// Handle booking form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $spot_id = intval($_POST['spot_id']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    $visit_datetime = strtotime($date . ' ' . $time);
    $now = time();

    if ($visit_datetime < $now) {
        $error_message = "You cannot book a visit in the past. Please select a valid date and time.";
    } else {
        // Fetch district id
        $stmt = $conn->prepare("SELECT district_id FROM tourist_spots WHERE id = ?");
        $stmt->bind_param("i", $spot_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $district_id = $result['district_id'] ?? 0;
        $stmt->close();

        // Insert booking
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, spot_id, district_id, visit_date, visit_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $user_id, $spot_id, $district_id, $date, $time);

        if ($stmt->execute()) {
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

// Fetch emergency services
$district_id = $spot['district_id'];
$eservices = $conn->query("SELECT * FROM emergency_services WHERE district_id = $district_id")->fetch_all(MYSQLI_ASSOC);

// Fetch guides: first for the spot, then from the district
$guides = [];
$guideQuery = $conn->prepare("
    SELECT * FROM guides 
    WHERE status = 'Approved' AND (spot_id = ? OR district_id = ?)
    ORDER BY (spot_id = ?) DESC, created_at DESC
");
$guideQuery->bind_param("iii", $spot_id, $district_id, $spot_id);
$guideQuery->execute();
$guides = $guideQuery->get_result()->fetch_all(MYSQLI_ASSOC);
$guideQuery->close();
?>

<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<br><br><br>
<section id="news_details_main_arae" class="section_padding">
    <div class="container">
        <div class="row">
            <!-- Main Column Full Width -->
            <div class="col-12">

                <!-- Tourist Spot Details -->
                <div class="news_detail_wrapper mb-4">
                    <div class="news_details_content_area">
                        <img src="../ADMIN/uploads/tourist_spots/<?php echo $spot['image']; ?>" 
                             alt="<?php echo $spot['name']; ?>" 
                             class="img-fluid mb-3" 
                             style="max-height:400px; width:100%; object-fit:cover; border-radius:10px;">
                        <h2><?php echo $spot['name']; ?></h2>
                        <p><?php echo $spot['description']; ?></p>
                    </div>
                </div>

               <!-- Booking Form & Guides -->
<div class="row mb-5">
    <!-- Booking Form -->
    <div class="col-lg-6 mb-3 d-flex">
        <div class="card p-3 flex-fill h-100">
            <h3>Plan Your Visit</h3>
            <form action="" method="POST" class="d-flex flex-column h-100">
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
                
                <button type="submit" class="btn btn-success mt-auto w-100">SUBMIT</button>
            </form>
        </div>
    </div>

   <!-- Guides List -->
<div class="col-lg-6 mb-3 d-flex">
    <div class="card p-3 flex-fill h-100">
        <h3>Available Guides</h3>
        <div class="overflow-auto" style="max-height:400px;">
            <?php if (!empty($guides)): ?>
                <?php foreach($guides as $g){ ?>
                    <div class="card mb-3 shadow-sm" style="border:1px solid #ddd;">
                        <div class="d-flex align-items-center p-2">
                            <img src="<?php echo !empty($g['image']) ? '../GUIDE/uploads/guides/'.$g['image'] : 'assets/default_guide.png'; ?>" 
                                 style="width:60px; height:60px; object-fit:cover; border-radius:50%;" 
                                 alt="<?php echo $g['first_name'].' '.$g['last_name']; ?>">
                            <div class="ms-3 flex-grow-1">
                                <h6 class="mb-1"><?php echo $g['first_name'].' '.$g['last_name']; ?></h6>
                                <small class="text-muted">
                                    <?php echo $g['email']; ?><br>
                                    <?php echo $g['mobile']; ?>
                                </small>
                            </div>
                            <a href="guide_details.php?id=<?php echo $g['id']; ?>" class="btn btn-success btn-sm">Contact</a>
                        </div>
                    </div>
                <?php } ?>
            <?php else: ?>
                <p class="text-muted">No guides available for this spot/district.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</div>

                <!-- Horizontal Hotel Cards -->
                <h3 class="mb-3">Nearby Hotels</h3>
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

                <!-- Emergency Services - Horizontal Scroll -->
                <h3 class="mt-5 mb-3">Emergency Services</h3>
                <div class="d-flex overflow-auto pb-3" style="gap:15px;">
                    <?php foreach($eservices as $e){ ?>
                        <div class="card h-100" style="min-width:300px;">
                            <?php if($e['image']){ ?>
                                <img src="../ADMIN/uploads/emergency/<?php echo $e['image']; ?>" 
                                     class="card-img-top" alt="<?php echo $e['name']; ?>" 
                                     style="height:200px; object-fit:cover;">
                            <?php } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $e['name']; ?></h5>
                                <p class="card-text"><?php echo $e['description']; ?></p>
                                <p><strong>Contact:</strong> <?php echo $e['contact']; ?></p>
                                <p><strong>Type:</strong> <?php echo $e['type']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>


<?php include 'components/footer.php'; ?>
