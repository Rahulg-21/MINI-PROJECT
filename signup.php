<!-- index.php -->
<?php include 'components/head.php'; ?>
<div class="tm-container">
<?php include 'components/navbar.php'; ?>

            <div class="tm-row">
                <div class="tm-col-left"></div>
                <main class="tm-col-right tm-contact-main"> <!-- Content -->
                    <section class="tm-content tm-contact">
                        <h2 class="mb-4 tm-content-title">Welcome...!</h2>
                        <p class="mb-85">Please enter the details to signup.</p>
                        <form id="contact-form" action="districts.html" onsubmit="return svalidate()">
                            <div class="form-group mb-4">
                                <input type="text" name="name" class="form-control" placeholder="Please enter a userame"/>
                            </div>
                            <div class="form-group mb-4">
                                <input type="email" id="semail" class="form-control" placeholder="Your email id"/>
                            </div>
                            <div class="form-group mb-4">
                                <input type="text" id="phone" class="form-control" placeholder="Your phone number"/>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" id="password1" class="form-control" placeholder="Enter a password"/>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" id="password2" class="form-control" placeholder="Re-enter password"/>
                            </div>

                            <br>
                            <p class="">Password Strength :</p>
                            <div id="typepass">
                                <div id="strengthResult">
                                </div>
                              </div>
                              <br>
                            
                            <div class="text-left">
                                <button type="submit" class="btn btn-big btn-primary">Signup</button>
                            </div>
                            <br>
                            <div class="text-left">
                                <a href="login.html" class="mb-85">I have an account..</a>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
            
<?php include 'components/footer.php'; ?>
</div>
<?php include 'components/closing.php'; ?>