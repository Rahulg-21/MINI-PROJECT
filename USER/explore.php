<?php
include 'components/head.php';
include '../CONFIG/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get district id from URL
$district_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch district details
$district_sql = "SELECT * FROM districts WHERE id = $district_id";
$district_result = $conn->query($district_sql);
$district = $district_result->fetch_assoc();

if (!$district) {
    die("<h2>District not found!</h2>");
}

// Fetch tourist spots for the district
$spots_sql = "SELECT * FROM tourist_spots WHERE district_id = $district_id";
$spots_result = $conn->query($spots_sql);
?>

<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<section id="district-detail" class="section_padding">
    <div class="container">
        <div class="section_heading_center">
            <h2><?php echo htmlspecialchars($district['name']); ?></h2>
        </div>

        <div class="row mb-4">
            <div class="col-lg-7">
                <img src="assets/img/districts/<?php echo $district['image']; ?>" 
                     alt="<?php echo htmlspecialchars($district['name']); ?>" 
                     class="img-fluid" style="width:100%;height:auto;">
            </div>
            <div class="col-lg-5">
                <p><?php echo nl2br(htmlspecialchars($district['description'])); ?></p>
            </div>
        </div>

        <div class="section_heading_center">
            <h2>Tourist Places</h2>
        </div>

        <div class="row">
            <?php while ($spot = $spots_result->fetch_assoc()) { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news_item_boxed">
                        <div class="news_item_img">
                            <a href="explore-detail.php?id=<?php echo $spot['id']; ?>">
                                <img src="../ADMIN/uploads/pages/ <?php echo $spot['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($spot['name']); ?>" 
                                     class="img-fluid" style="width:100%;height:250px;object-fit:cover;">
                            </a>
                        </div>
                        <div class="news_item_content">
                            <h3><?php echo htmlspecialchars($spot['name']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($spot['description'], 0, 120)); ?>...</p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</section>

<?php include 'components/footer.php'; ?>
