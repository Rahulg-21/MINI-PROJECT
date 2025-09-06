<?php include 'components/head.php'; ?>
<body>
<?php include 'components/pre-loader.php'; ?>
<header class="main_header_arae"></header>
<?php include 'components/navbar.php'; ?>

    <!--  Common Author Area -->
    <section id="common_author_area" class="section_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="common_author_boxed">
                        <div class="common_author_heading">
                            <h3>Register account</h3>
                            <h2>Register your account</h2>
                        </div>
                        <div class="common_author_form">
                            <form action="#" id="main_author_form">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter first name*" required />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter last name*" required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control"
                                        placeholder="your email address (Optional)"required />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Mobile number*"required />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="User name*" required/>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" required />
                                </div>
                                <div class="common_form_submit">
                                    <button class="btn btn_theme btn_md" ><a href="login.php">_</a>Register</button>
                                </div>
                                <div class="have_acount_area other_author_option">
                                    <div class="line_or">
                                        <span>or</span>
                                    </div>
                                    <ul>
                                        <li><a href="#!"><img src="assets/img/icon/google.png" alt="icon"></a></li>
                                        <li><a href="#!"><img src="assets/img/icon/facebook.png" alt="icon"></a></li>
                                        <li><a href="#!"><img src="assets/img/icon/twitter.png" alt="icon"></a></li>
                                    </ul>
                                    <p>Already have an account? <a href="login.php">Log in now</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cta Area -->


 
<?php include 'components/footer.php'; ?>