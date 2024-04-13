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
                            <img src="https://i.pinimg.com/564x/cf/d0/8f/cfd08f83790f5481af05f5deaa5f01f6.jpg" alt="..." style="width: 100%; height:100%; border-radius:50%;">
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

        <div class="card border border-2 border-primary mb-5 br-15">
            <div class="card-body">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod sunt eligendi soluta quia neque aspernatur, quae dolore error eos! Reiciendis minima sit eum error totam. Cumque aliquam odio maiores impedit tenetur iure rem sapiente architecto sed ad. Blanditiis officiis aut omnis! Voluptatibus reiciendis dignissimos aut? Impedit repellat ab natus optio, hic quia voluptate cum voluptas eligendi. Impedit dolorum laudantium quas deserunt alias aperiam eligendi molestias a dolores velit commodi deleniti voluptatibus corporis in excepturi quia, consectetur accusantium repellendus libero cumque? Porro facere excepturi maxime, cum veritatis aperiam ab unde optio ullam possimus, dolorem impedit adipisci facilis reiciendis ad doloribus molestiae rem commodi expedita aliquid nobis! Aliquam quasi nostrum nobis earum facere quia culpa eius itaque quo quibusdam numquam, excepturi explicabo dolore laborum provident illum? Corporis eveniet autem voluptates adipisci animi recusandae omnis aperiam corrupti! Perspiciatis, sapiente corrupti harum, atque distinctio velit ex eum placeat fugit beatae tempora nulla accusantium suscipit exercitationem nam quae sed magni quaerat ad recusandae aliquid doloribus rerum laboriosam? Ipsum totam unde libero, fugit itaque sapiente cupiditate pariatur non, suscipit beatae amet error reprehenderit commodi officiis quos similique? Esse necessitatibus ut sapiente exercitationem sint quisquam libero eius repellendus porro, maxime quam, ipsa voluptatibus, iste nihil quae quaerat
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>