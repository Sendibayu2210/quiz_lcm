<nav class="navbar navbar-expand-lg bg-white mb-3 shadow-sm">
  <div class="container-fluid"> 
    <a class="navbar-brand- h5" href="#" v-html="titlePage"></a>       
    <div id="menu-sidebar" class="">
      <i class="fas fa-bars" id="icon"></i>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">          
      <a href="/profile" class="d-flex w-100 justify-content-end py-2 align-items-center text-dark">
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
      </a>
    </div>
  </div>
</nav>