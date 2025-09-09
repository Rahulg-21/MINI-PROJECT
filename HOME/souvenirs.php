<?php 
include 'components/head.php'; 
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
<?php include 'components/pre-loader.php'; ?>

<!-- Header Area -->
<header class="main_header_arae"></header>

<?php include 'components/navbar.php'; ?>

<!-- Kerala Destination Wedding Spots -->
<section id="wedding_main_area" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                 <div class="section_heading_center">
                    <h2>Souvenirs of Kerala</h2>
                    <p>Take home a piece of Kerala — unique handicrafts, art, and specialties made with love.</p>
                </div>
            </div>
        </div>

        <div class="wedding_list">
            <div class="row">

                <?php
                // Fetch wedding spots from DB
                $query = "SELECT title, description, image FROM pages WHERE category = 'Souvenir'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $title = htmlspecialchars($row['title']);
                    $desc = nl2br(htmlspecialchars($row['description']));
                    $imagePath = "../ADMIN/uploads/pages/" . htmlspecialchars($row['image']);
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="news_item_boxed">
                            <div class="news_item_img">
                                <img src="<?php echo $imagePath; ?>" alt="<?php echo $title; ?>">
                            </div>
                            <div class="news_item_content">
                                <h3><?php echo $title; ?></h3>
                                <p><?php echo $desc; ?></p>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
</section>

<style>
.news_item_img img {
    width: 100%;
    max-width: 350px;
    height: 250px;
    object-fit: cover;
    border-radius: 8px;
}
</style>

<?php include 'components/footer.php'; ?>
