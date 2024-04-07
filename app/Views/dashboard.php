<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>


<?= view('components/sidebar'); ?>

<div id="main-content" class="p-4">
    <div class="container">

            <div class="text-center h3">
                <div>GET HOUSE OF ENGLISH</div>
                <div>KUNINGAN</div>
            </div>

            <div>
                <div class="btn btn-info px-4 border border-2 border-white text-white fw-bold mb-3">Visi</div>
                <div>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi vitae nam pariatur cupiditate quia perferendis voluptatibus assumenda animi ipsa. Molestias, similique? Perferendis maiores porro amet ratione praesentium quidem eligendi totam corrupti ea, excepturi voluptates velit minima distinctio voluptate atque aliquid, repellendus assumenda dolorem, cum hic dolores. Harum quo non aperiam.
                </div>

                <div class="btn btn-danger px-4 border border-2 border-white text-white fw-bold my-3 mt-4">Misi</div>
                <div>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi vitae nam pariatur cupiditate quia perferendis voluptatibus assumenda animi ipsa. Molestias, similique? Perferendis maiores porro amet ratione praesentium quidem eligendi totam corrupti ea, excepturi voluptates velit minima distinctio voluptate atque aliquid, repellendus assumenda dolorem, cum hic dolores. Harum quo non aperiam.
                </div>
            </div>

    </div>
</div>

<?= $this->endSection(); ?>