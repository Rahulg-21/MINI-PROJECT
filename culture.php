<?php include 'components/head.php'; ?>

<body>
<?php include 'components/pre-loader.php'; ?>

<!-- Header Area -->
<header class="main_header_arae"></header>

<?php include 'components/navbar.php'; ?>

<!-- Kerala Culture Area -->
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

        <!-- Ayurveda -->
        <div class="row align-items-center culture_row">
            <div class="col-lg-6">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0E0gA0cM7Uy2dR7GP1dVNt_4PIvR0-77Y2g&s" alt="Ayurveda" class="culture_img">
            </div>
            <div class="col-lg-6">
                <h3>Ayurveda</h3>
                <p>Kerala is globally renowned for Ayurveda — the ancient Indian system of medicine. With herbal treatments, therapeutic massages, and detox programs, it offers natural healing and wellness experiences.</p>
            </div>
        </div>

        <!-- Kalaripayattu -->
        <div class="row align-items-center culture_row flex-row-reverse">
            <div class="col-lg-6">
                <img src="https://www.keralatourism.org/images/kalari/static-banner/large/Vadivu_-12022020151336.jpg" alt="Kalaripayattu" class="culture_img">
            </div>
            <div class="col-lg-6">
                <h3>Kalaripayattu</h3>
                <p>Kalaripayattu is one of the oldest martial arts in the world, combining combat techniques, weapon training, and graceful movements inspired by animals. It’s still practiced across Kerala today.</p>
            </div>
        </div>

        <!-- Kathakali -->
        <div class="row align-items-center culture_row">
            <div class="col-lg-6">
                <img src="https://i.pinimg.com/736x/df/4b/b0/df4bb036cdfcb76797ab58e05579f3d1.jpg" alt="Kathakali" class="culture_img">
            </div>
            <div class="col-lg-6">
                <h3>Kathakali</h3>
                <p>This classical dance-drama combines elaborate costumes, painted faces, and expressive gestures to narrate stories from epics like the Mahabharata and Ramayana.</p>
            </div>
        </div>

        <!-- Theyyam -->
        <div class="row align-items-center culture_row flex-row-reverse">
            <div class="col-lg-6">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCusR0k-gmWTK3nujtdA7n6_5D2xqWtjO01A&s" alt="Theyyam" class="culture_img">
            </div>
            <div class="col-lg-6">
                <h3>Theyyam</h3>
                <p>Theyyam is a unique ritual art form from North Kerala, where performers transform into deities through intricate makeup, costumes, and dance during temple festivals.</p>
            </div>
        </div>

        <!-- Boat Races -->
        <div class="row align-items-center culture_row">
            <div class="col-lg-6">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSX41GmsNCkjHYSK5n-xu70yDqH1fJmI5MdUg&s" alt="Boat Race" class="culture_img">
            </div>
            <div class="col-lg-6">
                <h3>Snake Boat Races</h3>
                <p>Held during the monsoon season, these traditional races feature massive snake boats rowed by dozens of oarsmen, accompanied by music and cheering crowds.</p>
            </div>
        </div>
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
