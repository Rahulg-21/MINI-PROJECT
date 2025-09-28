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

// Fetch hotels for this spot first, then for the district
$hotels = [];
$hotelQuery = $conn->prepare("
    SELECT * FROM hotels 
    WHERE status='Approved' AND (spot_id = ? OR district_id = ?)
    ORDER BY (spot_id = ?) DESC, created_at DESC
");
$hotelQuery->bind_param("iii", $spot_id, $district_id, $spot_id);
$hotelQuery->execute();
$hotels = $hotelQuery->get_result()->fetch_all(MYSQLI_ASSOC);
$hotelQuery->close();
?>

<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<style> 
.card:hover {
    transform: translateY(-5px);
    transition: 0.3s;
}
/* Keep only styling */
.emergency-scroll-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    position: relative;
    scroll-behavior: smooth;
    -ms-overflow-style: none;  /* hide scrollbar IE/Edge */
    scrollbar-width: none;     /* hide scrollbar Firefox */
}

.emergency-scroll-wrapper::-webkit-scrollbar {
    display: none; /* hide scrollbar Chrome */
}

.emergency-scroll {
    display: flex;
    gap: 15px;
}

.emergency-card {
    min-width: 260px;
    max-width: 260px;
    height: 340px;
    border-radius: 8px;
    overflow: hidden;
    flex: 0 0 auto;
}

.emergency-card img {
    height: 150px;
    width: 100%;
    object-fit: cover;
}
</style>

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
    <div class="col-lg-6 col-12 mb-3 d-flex">
        <div class="card p-3 flex-fill h-100 shadow-sm rounded">
           <h3 class="text-center fw-bold">Plan Your Visit</h3>

            <form action="" method="POST" class="d-flex flex-column pt-5 h-100">
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
        <h3 class="text-center fw-bold">Available Guides</h3>
        <div class="overflow-auto pt-5" style="max-height:400px;">
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
<h3 class="mb-3 text-center fw-bold">Nearby Hotels</h3>
<div class="d-flex overflow-auto pb-3" style="gap:15px;">
    <?php if (!empty($hotels)): ?>
        <?php foreach($hotels as $h): ?>
            <div class="card shadow-sm" style="min-width:250px; max-width:260px;">
                <img src="<?php echo !empty($h['image']) 
                                ? '../HOTEL/uploads/hotels/'.$h['image'] 
                                : 'assets/img/hotel/default_hotel.png'; ?>" 
                     class="card-img-top" 
                     alt="<?php echo htmlspecialchars($h['name']); ?>" 
                     style="height:160px; object-fit:cover; width:100%; border-top-left-radius:6px; border-top-right-radius:6px;">

                <div class="card-body">
                    <!-- Hotel name + verified badge -->
                    <h6 class="card-title fw-bold mb-1">
                        <?php echo htmlspecialchars($h['name']); ?>
                        <?php if ($h['status'] === 'Approved'): ?>
                            <span class="badge bg-success ms-2" title="Verified Hotel">
                                <i class="bi bi-check-circle-fill"></i>
                            </span>
                        <?php endif; ?>
                    </h6>

                    <!-- Contact info -->
                    <p class="mb-1 text-muted" style="font-size: 0.9rem;">
                        <i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars($h['mobile']); ?>
                    </p>
                    <p class="mb-1 text-muted" style="font-size: 0.9rem;">
                        <i class="bi bi-envelope-fill"></i> <?php echo htmlspecialchars($h['email']); ?>
                    </p>

                    <!-- Created date -->
                    <p class="text-muted" style="font-size: 0.8rem;">
                        <i class="bi bi-clock"></i> Added on: 
                        <?php echo date("d M Y", strtotime($h['created_at'])); ?>
                    </p>

                    <!-- Actions -->
                    <a href="hotel_details.php?id=<?php echo $h['id']; ?>" 
                       class="btn btn-success btn-sm w-100">
                        <i class="bi bi-info-circle"></i> View Details
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No hotels available for this spot/district.</p>
    <?php endif; ?>
</div>


<!-- Emergency Services - Horizontal Auto Scroll -->
<h3 class="mt-5 mb-3 text-center fw-bold">Emergency Services</h3>

<div class="emergency-scroll-wrapper">
    <div class="emergency-scroll d-flex" style="gap:15px;">
        <?php foreach($eservices as $e){ ?>
            <div class="card emergency-card shadow-sm">
                <?php if($e['image']){ ?>
                    <img src="../ADMIN/uploads/emergency/<?php echo $e['image']; ?>" 
                         class="card-img-top" alt="<?php echo $e['name']; ?>">
                <?php } ?>
                <div class="card-body text-center">
                    <h6 class="card-title fw-bold mb-2"><?php echo $e['name']; ?></h6>
                    <p class="card-text small text-muted"><?php echo $e['description']; ?></p>
                    <p class="mb-1"><i class="bi bi-telephone-fill"></i> <?php echo $e['contact']; ?></p>
                    <p class="text-muted" style="font-size:0.85rem;"><i class="bi bi-hospital"></i> <?php echo $e['type']; ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.querySelector(".emergency-scroll-wrapper");
    let scrollSpeed = 1; // pixels per frame
    let autoScroll;

    function startScroll() {
        autoScroll = setInterval(() => {
            wrapper.scrollLeft += scrollSpeed;

            // loop back to start when reaching end
            if (wrapper.scrollLeft + wrapper.clientWidth >= wrapper.scrollWidth) {
                wrapper.scrollLeft = 0;
            }
        }, 30); // adjust speed (ms interval)
    }

    function stopScroll() {
        clearInterval(autoScroll);
    }

    // Start auto-scroll
    startScroll();

    // Pause on hover / resume on leave
    wrapper.addEventListener("mouseenter", stopScroll);
    wrapper.addEventListener("mouseleave", startScroll);
});
</script>


<?php include 'components/footer.php'; ?>
