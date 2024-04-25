<nav class="navbar navbar-expand-lg bg-transparent mb-3 shadow-sm">
  <div class="container-fluid"> 
    <a class="navbar-brand- h5 text-primary fw-bold" href="#" v-html="titlePage"></a>       
    <div id="menu-sidebar" class="">
      <i class="fas fa-bars" id="icon"></i>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">          
      <div class="d-flex w-100 justify-content-end py-2 align-items-center text-dark cursor-pointer" id="navbar-profile">
        <div class="me-2"><?= session()->get('nameLogin'); ?></div>
        <div>                
            <?php $foto = session()->get('fotoLogin'); ?>
            <?php if($foto=='') : ?>
                <div style="width: 35px; height:35px; border-radius:50%;" class="bg-primary justify-content-center d-flex align-items-center">
                    <div><?= substr(session()->get('nameLogin'), 0, 1); ?></div>
                </div>    
            <?php else: ?>
                <div style="width: 35px; height:35px; border-radius:50%;">
                    <img src="<?= $foto; ?>" alt="" style="width: 100%; height:100%; object-fit:cover; border-radius:50%;" class="">
                </div>    
            <?php endif; ?>                
        </div>
      </div>
    </div>

    <div id="menu-navbar" class="shadow border p-3 br-15 d-none">
          <div class=" border-bottom cursor-pointer badge bg-danger" id="close"><i class="fas fa-times me-1"></i> Close</div>
          <hr>
          <a href="/users/profile" class="d-block mb-3"><i class="fas fa-user me-1"></i> Profile</a>
          <a href="/about" class="d-block"><i class="fas fa-info-circle me-1"></i> About</a>
    </div>

  </div>
</nav>