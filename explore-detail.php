<?php include 'components/head.php'; ?>

<body>
<?php include 'components/pre-loader.php'; ?>
    <!-- Header Area -->
    <header class="main_header_arae"> </header>

    <?php include 'components/navbar.php'; ?>


<br><br><br>
    <!-- News Area -->
    <section id="news_details_main_arae" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="news_detail_wrapper">
                        <div class="news_details_content_area">
    <img src="https://www.holidify.com/images/cmsuploads/square/6580072031_bd440e0838_b_20180205133850.jpg" alt="Sree Padmanabhaswamy Temple">
    <h2>Sree Padmanabhaswamy Temple</h2>
    <p>
        Sree Padmanabhaswamy Temple, located in Thiruvananthapuram, is one of the most famous and sacred Hindu temples in India.
        Dedicated to Lord Vishnu, who is enshrined here in the “Anantha Shayana” (eternal yogic sleep) posture on the serpent Adi Sesha,
        the temple is renowned for its intricate Dravidian-style architecture, high walls, and golden gopuram.
    </p>
    <p>
        The temple is counted among the 108 Divya Desams — holy abodes of Lord Vishnu mentioned in Vaishnava tradition.
        Entry is restricted to Hindu devotees only, and strict dress codes are enforced.
        Apart from its spiritual significance, the temple gained worldwide attention for the vast treasures discovered in its underground vaults.
    </p>
    
    <h3>Interesting Facts about Sree Padmanabhaswamy Temple</h3>
    <ul>
        <li><i class="fas fa-circle"></i> The temple's idol is over 18 feet long, made with 12,000 salagramams (sacred stones) from the Gandaki River in Nepal.</li>
        <li><i class="fas fa-circle"></i> The golden gopuram (tower) stands 100 feet high and is adorned with intricate carvings.</li>
        <li><i class="fas fa-circle"></i> It is considered the richest temple in the world due to the immense treasures found in its vaults.</li>
        <li><i class="fas fa-circle"></i> The annual Alpasi and Painkuni festivals are celebrated with great devotion and grandeur.</li>
    </ul>

    <h3>Visiting Information</h3>
    <p>
        The temple is located in the East Fort area of Thiruvananthapuram and is easily accessible by road, rail, and air.
        Non-Hindus are not allowed inside the sanctum, but can admire the temple’s exterior beauty.
        Dress code: Men must wear mundu (traditional dhoti) without a shirt, and women must wear sarees or traditional attire.
    </p>
</div>

                                             
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="news_details_rightbar">
                    <div class="news_details_right_item">
    <h3>Hotels</h3>
    <div class="hotel_scroll">
        <?php
        $hotels = [
            ["name" => "Hotel RAM", "img" => "assets/img/destination/batti.jpg", "link" => "https://hotelram.com"],
            ["name" => "Hotel RAM", "img" => "assets/img/destination/batti.jpg", "link" => "https://hotelram.com"],
            ["name" => "Hotel RAJA RAM", "img" => "assets/img/destination/batti.jpg", "link" => "https://hotelrajaram.com"],
            ["name" => "Hotel SREE RAM", "img" => "assets/img/destination/batti.jpg", "link" => "https://hotelsreeram.com"]
        ];

        foreach ($hotels as $hotel) {
            echo '
            <div class="recent_news_item">
                <div class="recent_news_img">
                    <a href="'.$hotel["link"].'" target="_blank">
                        <img src="'.$hotel["img"].'" alt="'.$hotel["name"].'">
                    </a>
                </div>
                <div class="recent_news_text">
                    <h5><a href="'.$hotel["link"].'" target="_blank">'.$hotel["name"].'</a></h5>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

    <div class="news_details_right_item">
    <h3>Get real time news</h3>
    <div class="news_tags_area">
        <form action="subscribe.php" method="POST">
            <div class="form-group mb-3">
                <label for="travelTag" class="form-label">Enter a place or tag</label>
                <input type="text" id="travelTag" name="tag" class="form-control" placeholder="e.g. Thiruvananthapuram" required>
            </div>
            <div class="form-group mb-3">
                <label for="travelDate" class="form-label">Planned travel date</label>
                <input type="date" id="travelDate" name="date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Subscribe for Updates</button>
        </form>
    </div>
   </div>

                      
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php include 'components/footer.php'; ?>