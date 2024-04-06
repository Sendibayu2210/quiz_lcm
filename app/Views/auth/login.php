<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div id="login-register">

    <div class="row">
        <div class="col-lg-5 mh-100vh bg-primary">

            <div class="p-5">
                <div>
                    <div class="h1 fw-bold">LOG<span class="text-warning">IN</span></div>
                    <div><span>Don’t have an account?</span> <a href="/register" class="text-info">Create your account</a></div>
                </div>
                <div class="mt-5">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Username">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control form-control-sm" placeholder="Password">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Remember Me
                        </label>
                    </div>

                    <div class="mt-5 text-center">
                        <button class="btn btn-warning px-4 border border-light border-2 text-primary fw-bold">Login</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 bg-warning">

            <div class="p-5">
                <div><span class="h1 fw-bold p-2 bg-danger text-white mb-3">WELCOME</span></div>
                <div class="h2 fw-bold my-3 text-primary">BACK</div>
                <div class="text-danger fw-bold small">
                    We're glad to see you return to our community. Please log in <br>
                    to continue to your exam phase with us. <br>
                    Thank you for your loyalty and support!
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>