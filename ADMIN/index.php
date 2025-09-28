<?php
// ✅ Only allow logged-in guide
session_start();
if(!isset($_SESSION['admin_id'])){
    echo "<script>alert('Login!'); window.location='login.php';</script>";
    exit;
} ?>


<?php 
include 'components/head.php'; 
include '../CONFIG/config.php'; 
?>

<body>
<?php include 'components/navbar.php'; ?>

<div class="content">
    <div class="pt-4"></div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="px-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

<?php
// ====== CARDS DATA ======

// total pages = tourist spots
$total_pages = $conn->query("SELECT COUNT(*) AS c FROM tourist_spots")->fetch_assoc()['c'];

// categories (districts) – if you don’t have a `districts` table, replace with spots categories
$categories = $conn->query("SELECT COUNT(DISTINCT district_id) AS c FROM tourist_spots")->fetch_assoc()['c'];

// pending updates = hotels pending approval
$pending_hotels = $conn->query("SELECT COUNT(*) AS c FROM hotels WHERE status='Pending'")->fetch_assoc()['c'];

// total users
$total_users = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'];

// ====== CHART DATA ======

// Place bookings by month
$place_sql = "SELECT MONTH(visit_date) as m, COUNT(*) as c 
              FROM bookings 
              GROUP BY MONTH(visit_date)";
$place_result = $conn->query($place_sql);
$place_data = array_fill(1, 12, 0);
while($row = $place_result->fetch_assoc()){
    $place_data[(int)$row['m']] = (int)$row['c'];
}

// Hotel bookings by month
$hotel_sql = "SELECT MONTH(booking_date) as m, COUNT(*) as c 
              FROM hotel_bookings 
              GROUP BY MONTH(booking_date)";
$hotel_result = $conn->query($hotel_sql);
$hotel_data = array_fill(1, 12, 0);
while($row = $hotel_result->fetch_assoc()){
    $hotel_data[(int)$row['m']] = (int)$row['c'];
}

// Guide bookings by month
$guide_sql = "SELECT MONTH(booking_date) as m, COUNT(*) as c 
              FROM guide_bookings 
              GROUP BY MONTH(booking_date)";
$guide_result = $conn->query($guide_sql);
$guide_data = array_fill(1, 12, 0);
while($row = $guide_result->fetch_assoc()){
    $guide_data[(int)$row['m']] = (int)$row['c'];
}
?>

    <!-- Dashboard Cards -->
    <div class="row g-3 px-3">
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total Pages</h6>
                <p class="display-6 fw-bold"><?= $total_pages ?></p>
                <i class="fa fa-file-text-o fa-2x text-success"></i>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Categories</h6>
                <p class="display-6 fw-bold"><?= $categories ?></p>
                <i class="fa fa-list fa-2x text-primary"></i>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Pending Hotels</h6>
                <p class="display-6 fw-bold"><?= $pending_hotels ?></p>
                <i class="fa fa-clock-o fa-2x text-warning"></i>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total Users</h6>
                <p class="display-6 fw-bold"><?= $total_users ?></p>
                <i class="fa fa-users fa-2x text-danger"></i>
            </div>
        </div>
    </div>

    <!-- Graphs Section -->
    <div class="row g-3 mt-4 px-3">
        <div class="col-lg-8 col-md-12">
            <div class="card shadow-sm p-3 chart-card">
                <h6>Place Bookings (Monthly)</h6>
                <canvas id="visitsChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card shadow-sm p-3 chart-card">
                <h6>Hotel & Guide Bookings (Monthly)</h6>
                <canvas id="usersChart"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

// Line chart: Place bookings
new Chart(document.getElementById('visitsChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Place Bookings',
            data: <?= json_encode(array_values($place_data)) ?>,
            borderColor: 'rgba(25,135,84,1)',
            backgroundColor: 'rgba(25,135,84,0.2)',
            tension: 0.4
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});

// Bar chart: Hotel & Guide bookings
new Chart(document.getElementById('usersChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [
            {
                label: 'Hotel Bookings',
                data: <?= json_encode(array_values($hotel_data)) ?>,
                backgroundColor: 'rgba(13,110,253,0.7)'
            },
            {
                label: 'Guide Bookings',
                data: <?= json_encode(array_values($guide_data)) ?>,
                backgroundColor: 'rgba(255,193,7,0.7)'
            }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false }
});
</script>

<style>
.chart-card { height: 300px; }
.chart-card canvas { width: 100% !important; height: 100% !important; }
</style>

</body>
</html>
