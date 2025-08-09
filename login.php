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
                            <h3>Login your account</h3>
                            <h2>Logged in to stay in touch</h2>
                        </div>
                        <div class="common_author_form">
                            <form action="#" id="main_author_form" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter user name" name = "username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Enter password" name = "password" required/>
                                    <a href="forgot-password.php">Forgot password?</a>
                                </div>
                                <div class="common_form_submit">
                                    <input type="submit" name="Login" class="btn btn_theme btn_md"></button>
                                </div>
                                <div class="have_acount_area">
                                    <p>Dont have an account? <a href="register.php">Register now</a></p>
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