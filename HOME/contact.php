<?php include 'components/head.php'; ?>

<body>
<?php include 'components/pre-loader.php'; ?>
    <!-- Header Area -->
    <header class="main_header_arae"> </header>

    <?php include 'components/navbar.php'; ?>

<br><br><br><br>

    <!-- Contact Area -->
    <section id="contact_main_area" class="section_padding">
        <div class="container">
            <!-- Heading -->
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section_heading_center">
                        <h2>Contact Kerala Tourism</h2>
                        <p class="text-muted">We’d love to assist you with your travel plans in Kerala</p>
                    </div>
                </div>
            </div>

            <div class="contact_main_form_area_two mt-4">
                <div class="row">
                    <!-- Contact Form -->
                    <div class="col-lg-8">
                        <div class="contact_left_top_heading mb-3">
                            <h3>Leave us a message</h3>
                            <p>Our team will get back to you as soon as possible</p>
                        </div>
                        <div class="contact_form_two">
                            <form action="contact_submit.php" method="post" id="contact_form_content">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="first_name" class="form-control bg_input" placeholder="First name*" required>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="last_name" class="form-control bg_input" placeholder="Last name*" required>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="email" name="email" class="form-control bg_input" placeholder="Email address*">
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <input type="text" name="phone" class="form-control bg_input" placeholder="Mobile number*" required>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <textarea name="message" class="form-control bg_input" rows="5" placeholder="Your message*" required></textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn_theme btn_md">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="col-lg-4">
                        <div class="contact_two_left_wrapper">
                            <h3>Contact Details</h3>
                            <div class="contact_details_wrapper mt-3">
                                <div class="contact_detais_item mb-3">
                                    <h4>Tourism Helpline</h4>
                                    <h3><a href="tel:+914712320113">+91 471 2320 113</a></h3>
                                    <small class="text-muted">24x7 Kerala Tourism Info Service</small>
                                </div>
                                <div class="contact_detais_item mb-3">
                                    <h4>Email Support</h4>
                                    <h3><a href="mailto:info@keralatourism.org">info@keralatourism.org</a></h3>
                                </div>
                                <div class="contact_detais_item mb-3">
                                    <h4>Office Hours</h4>
                                    <h3>Mon – Sat : 9:00 AM – 6:00 PM</h3>
                                </div>
                                <div class="contact_detais_item">
                                    <h4>Head Office</h4>
                                    <h3>Department of Tourism,<br>
                                    Park View, Thiruvananthapuram,<br>
                                    Kerala – 695033</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>
