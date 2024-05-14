<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>


<?= view('components/sidebar'); ?>

<div id="main-content" class="">
    
    <?= view('components/navbar'); ?>

    <div class="px-lg-4">
        <div class="card border border-2 border-primary mb-5 br-15" style="width: 40rem;">
            <div class="card-body">
                
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <div class="position-relative border border-3 border-primary" style="width: 100px; height:100px; border-radius:50%;">
                            <img src="/assets/foto-profile/032f937f-4ed6-4fa7-99e7-6390d076f683.jpeg" alt="..." style="width: 100%; height:100%; object-fit:cover; object-position:top; border-radius:50%;">
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-1" for="">Name</label>
                            <input type="text" class="form-control" value="Enad Nadiroh">
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-1" for="">NIM</label>
                            <input type="text" class="form-control" value="20200810035">
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold mb-1" for="">Faculty</label>
                            <input type="text" class="form-control" value="Informatics Engineering">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="card border border-2 border-primary mb-5 br-15">
            <div class="card-body">                
            </div>
        </div> -->
    </div>
</div>

<?= $this->endSection(); ?>