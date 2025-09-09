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
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <!-- Dashboard Cards -->
    <div class="row g-3 px-3">
        <!-- Total Pages -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total Pages</h6>
                <p class="display-6 fw-bold">12</p>
                <i class="fa fa-file-text-o fa-2x text-success"></i>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Categories</h6>
                <p class="display-6 fw-bold">5</p>
                <i class="fa fa-list fa-2x text-primary"></i>
            </div>
        </div>

        <!-- Pending Updates -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Pending Updates</h6>
                <p class="display-6 fw-bold">0</p>
                <i class="fa fa-clock-o fa-2x text-warning"></i>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total Users</h6>
                <p class="display-6 fw-bold">320</p>
                <i class="fa fa-users fa-2x text-danger"></i>
            </div>
        </div>
    </div>

    <!-- Graphs Section -->
    <div class="row g-3 mt-4 px-3">
        <div class="col-lg-8 col-md-12">
            <div class="card shadow-sm p-3 chart-card">
                <h6>Page Visits (Graph)</h6>
                <canvas id="visitsChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card shadow-sm p-3 chart-card">
                <h6>New Users (Graph)</h6>
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
// Charts
const ctx1 = document.getElementById('visitsChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            label: 'Visits',
            data: [120, 190, 300, 250, 400, 320],
            borderColor: 'rgba(25, 135, 84, 1)',
            backgroundColor: 'rgba(25, 135, 84, 0.2)',
            tension: 0.4
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});

const ctx2 = document.getElementById('usersChart').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            label: 'New Users',
            data: [20, 35, 40, 30, 50, 45],
            backgroundColor: 'rgba(13, 110, 253, 0.7)'
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});
</script>

<style>
/* Chart card fix */
.chart-card {
    height: 300px;
}
.chart-card canvas {
    width: 100% !important;
    height: 100% !important;
}
</style>

</body>
</html>
