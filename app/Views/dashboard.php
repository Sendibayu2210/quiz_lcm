<?= $this->extend('template/layout'); ?>
<?= $this->section('head'); ?>
<style>
    .fa-bars, .fa-times{
        color: #fff !important;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?= view('components/sidebar'); ?>
<div id="main-content">

    <div class="position-relative acc-top-main-content">
        <img src="/assets/image-components/acc-top-main-content.png" alt="" class="position-absolute">
    </div>
    <?= view('components/navbar'); ?>

    <div class="container px-lg-4 mt-4">
        <div class="d-flex align-items-center content-dashboard" >
            <div class="col-lg-7 col-md-12 col-12">

                <div class="text-center h2" style="font-weight: 850;">
                    <div class="text-primary border-text-light">GET-HOUSE OF ENGLISH</div>
                    <div class="text-warning border-text-light">KUNINGAN</div>
                </div>
                
                <div class="position-relative text-center d-lg-none d-md-block d-sm-block d-block mb-4">
                    <img src="/assets/image-components/acc-dashboard.png" alt="" class="w-75">
                </div>                

                <div id="visi-misi">
                    <div class="p-3 br-10 border-info border border-2 mb-3 border-desktop-none">
                        <div class="btn btn-info px-4 border border-2 border-white text-white fw-bold mb-3">Visi</div>
                        <div>
                            Terwujudnya lembaga pendidikan kursus yang menghasilkan lulusan yang memiliki kompetensi bahasa inggris yang unggul dan berwawasan global.
                        </div>
                    </div>

                    <div class="p-3 br-10 border-danger border border-2 border-desktop-none">
                        <div class="btn btn-danger px-4 border border-2 border-white text-white fw-bold mb-3">Misi</div>
                        <div>
                            Menerapkan pendekatan komunikatif, mengembangkan kompetensi bahasa inggris secara optimal pada bidang tertentu, memberikan layanan kepada warga belajar dan masyarakat melalui sertifikasi serta meningkatkan profesionalisme pendidik dan kecakapan kerja melalui pelatihan.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 d-lg-block d-md-none d-sm-none d-none">
                <div class="position-relative order-2">
                    <img src="/assets/image-components/acc-dashboard.png" alt="" class="w-75">
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>