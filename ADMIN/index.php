<?php
include '../CONFIG/config.php'; // DB connection if needed

// Optional: fetch counts of pages, categories, etc. for dashboard stats
$total_pages = $conn->query("SELECT COUNT(*) AS count FROM pages")->fetch_assoc()['count'];
?>

<?php include 'components/head.php'; ?>

<body>
<div class="page-container">
    <div class="left-content">
        <?php  include 'components/top-bar.php'; ?>
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i> Admin Dashboard
            </li>
        </ol>

        <!-- Dashboard Welcome -->
        <div class="grid-form">
            <div class="grid-form1 text-center">
                <h2>Welcome, Admin! 👋</h2>
                <p class="lead">Manage your Kerala Tourism content from here.</p>

                <!-- Optional Stats Cards -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white p-4">
                            <h4>Total Pages</h4>
                            <p style="font-size: 1.5rem;"><?= $total_pages; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white p-4">
                            <h4>Categories</h4>
                            <p style="font-size: 1.5rem;">5</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white p-4">
                            <h4>Pending Updates</h4>
                            <p style="font-size: 1.5rem;">0</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mt-5">
            </div>
        </div>

        <div class="inner-block"></div>

        <!-- Footer -->
        <div class="copyrights">
            <p>TMS. All Rights Reserved | <a href="#">TMS</a></p>
        </div>
    </div>
</div>

<?php include 'components/navbar.php'; ?>
</body>
</html>
