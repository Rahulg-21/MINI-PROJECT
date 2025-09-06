<?php
include '../CONFIG/config.php'; // DB connection if needed

// Optional: fetch counts of pages, categories, etc. for dashboard stats
$total_pages = $conn->query("SELECT COUNT(*) AS count FROM pages")->fetch_assoc()['count'];
?>

<?php include 'components/head.php'; ?>

<body>
<div class="page-container">
    <div class="left-content">
        <?php include 'components/top-bar.php'; ?>
        
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

                <!-- Stats Cards -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 p-4 text-dark" style="background:#f8f9fa;">
                            <h5>Total Pages</h5>
                            <p style="font-size: 1.5rem; font-weight:bold;"><?= $total_pages; ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 p-4 text-dark" style="background:#f8f9fa;">
                            <h5>Categories</h5>
                            <p style="font-size: 1.5rem; font-weight:bold;">5</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 p-4 text-dark" style="background:#f8f9fa;">
                            <h5>Pending Updates</h5>
                            <p style="font-size: 1.5rem; font-weight:bold;">0</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mt-5">
                    <!-- you can add buttons like Manage Pages, Add Page etc. -->
                </div>
            </div>
        </div>

        <div class="inner-block"></div>

        <!-- Footer -->
         <div class="copyrights">
            <p>Kerala Tourism. All Rights Reserved | <a href="#">Kerala Tourism</a></p>
        </div>
    </div>
</div>

<?php include 'components/navbar.php'; ?>
</body>
</html>
