<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="p-4">

    <div class="container">
        <div class="h5">Manage Questions</div>

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div><a href="/admin/questions/add" class="btn btn-sm bg-warning">Add Questions</a></div>
            <div>
                <div class="d-flex p-1 border br-50">
                    <input type="text" class="border-0 outline-none ms-2" placeholder="search questions here">
                    <button class="btn btn-sm br-50"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>

    </div>

</div>

<?= $this->endSection(); ?>
