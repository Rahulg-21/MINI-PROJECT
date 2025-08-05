<!-- index.php -->
<?php include 'components/head.php'; ?>
<div class="tm-container">
<?php include 'components/navbar.php'; ?>

            
            <div class="tm-row">
                <div class="tm-col-left"></div>
                <main class="tm-col-right tm-contact-main"> <!-- Content -->
                    <section class="tm-content tm-contact">
                        <h2 class="mb-4 tm-content-title">Welcome Back...!</h2>
                        <p class="mb-85">Please enter your login credentials to continue.</p>
                        <form id="contact-form" action="districts.html" onsubmit="return lvalidate()">
                            <div class="form-group mb-4">
                                <input type="email" id="email" class="form-control" placeholder="Email"/>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" id="password" class="form-control" placeholder="Password"/>
                            </div>
                            <!-- <br>
                            <p class="">Password Strength :</p>
                            <div id="typepass">
                                <div id="strengthResult">
                                </div>
                              </div>
                              <br> -->
                            <div class="text-left">
                                <button type="submit" class="btn btn-big btn-primary">Login</button>
                            </div>
                            <br>
                            <div class="text-left">
                                <a href="#" class="mb-85">Forgot Password?</a>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
            
<?php include 'components/footer.php'; ?>
</div>
<?php include 'components/closing.php'; ?>