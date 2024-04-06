<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div id="login-register">

    <div class="row">
        <div class="col-lg-5 mh-100vh bg-primary">

            <div class="p-5">
                <div>
                    <div class="h1 fw-bold">REGISTER</div>
                </div>
                <div class="mt-4">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Full Name">
                    </div>
                    <div class="d-flex justify-content-around mb-3">
                        <div class="form-group me-2 w-100">
                            <select name="" id="" class="form-control form-control-sm">
                                <option value="">Date</option>
                            </select>
                        </div>
                        <div class="form-group me-2 w-100">
                            <select name="" id="" class="form-control form-control-sm">
                                <option value="">Month</option>
                            </select>
                        </div>
                        <div class="form-group w-100">
                            <select name="" id="" class="form-control form-control-sm">
                                <option value="">Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="forn-group mb-3">
                        <textarea name="" id="" cols="30" rows="3" class="form-control" placeholder="Address"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Email">
                    </div>
                    <div class="form-group mb-3">
                        <input type="text" class="form-control form-control-sm" placeholder="Username">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control form-control-sm" placeholder="Password">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control form-control-sm" placeholder="Confirm Password">
                    </div>

                    <div><span>Already have an account?</span> <a href="/login" class="text-info">Login</a></div>

                    <div class="mt-5 text-center">
                        <button class="btn btn-warning px-4 border border-light border-2 text-primary fw-bold">Sign Up</button>
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