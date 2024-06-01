<?= $this->include('partials/main') ?>

    <head>
        
    <?= $title_meta ?>

    <?= $this->include('partials/head-css') ?>

    </head>

    <body class="auth-body-bg">
        <div class="home-btn d-none d-sm-block">
            <a href="index.php"><i class="mdi mdi-home-variant h2 text-white"></i></a>
        </div>
        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-lg-4">
                        <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                            <div class="w-100">
                                <div class="row justify-content-center">
                                    <div class="col-lg-9">
                                        <div>
                                            <div class="text-center">
                                                <div>
                                                    <a href="index.php" class="logo"><img src="assets/images/logo-dark.png" height="150" alt="logo"></a>
                                                </div>
    
                                                <h4 class="font-size-18 mt-4">Register account</h4>
                                                <p class="text-muted">Get your free Nazox account now.</p>
                                            </div>

                                            <div class="p-2 mt-5">
                                                <form action="<?= route_to('auth-register') ?>" method="POST">

                                                    <div class="auth-form-group-custom mb-4">
                                                        <i class="ri-mail-line auti-custom-input-icon"></i>
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter email">
                                                    </div>
                            
                                                    <div class="auth-form-group-custom mb-4">
                                                        <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                                                    </div>

                                                    <div class="text-center">
                                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">
                                                            Register
                                                        </button>
                                                    </div>

                                                    <div class="mt-4 text-center">
                                                        <p class="mb-0">By registering you agree to the Nazox <a href="#" class="text-primary">Terms of Use</a></p>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mt-5 text-center">
                                                <p>Already have an account ? <a href="/" class="fw-medium text-primary"> Login</a> </p>
                                                <p>© <script>document.write(new Date().getFullYear())</script> Nazox. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="authentication-bg position-relative">
                            <div class="bg-overlay"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- JAVASCRIPT -->
        <?= $this->include('partials/vendor-scripts') ?>

        <script src="assets/js/app.js"></script>

    </body>
</html>
