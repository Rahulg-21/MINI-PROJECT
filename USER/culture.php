<?php 
include 'components/head.php'; 
include '../CONFIG/config.php';

// Enable error reporting for debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

<section id="culture_main_area" class="section_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section_heading_center">
                    <h2>Culture of Kerala</h2>
                    <p>Kerala’s rich cultural heritage blends ancient traditions, performing arts, healing practices, and vibrant festivals.</p>
                </div>
            </div>
        </div>

        <?php
        $query = "SELECT title, description, image FROM pages WHERE category = 'Culture'";
        $result = mysqli_query($conn, $query);

        $reverse = false;
        while($row = mysqli_fetch_assoc($result)) {
            $title = htmlspecialchars($row['title']);
            $desc = nl2br(htmlspecialchars($row['description']));
            $imagePath = "ADMIN/uploads/pages/" . htmlspecialchars($row['image']); // prepend folder path
            
            $rowClass = $reverse ? "row align-items-center culture_row flex-row-reverse" : "row align-items-center culture_row";
            ?>
            <div class="<?php echo $rowClass; ?>">
                <div class="col-lg-6">
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo $title; ?>" class="culture_img">
                </div>
                <div class="col-lg-6">
                    <h3><?php echo $title; ?></h3>
                    <p><?php echo $desc; ?></p>
                </div>
            </div>
            <?php
            $reverse = !$reverse;
        }
        ?>
    </div>
</section>

<style>
.culture_row {
    margin-bottom: 50px;
}
.culture_img {
    width: 100%;
    height: 350px;
    object-fit: cover;
    border-radius: 8px;
}
.culture_row h3 {
    margin-bottom: 15px;
    font-size: 24px;
    font-weight: bold;
}
.culture_row p {
    font-size: 16px;
    line-height: 1.6;
}
</style>
<?php include 'components/footer.php'; ?>
