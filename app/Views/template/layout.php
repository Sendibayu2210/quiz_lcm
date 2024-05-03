<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= (isset($title) && $title) ? $title : 'Get-House of English Kuningan'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v2-250420241353'); ?>">
    <script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/vue.global.js'); ?>"></script>
    <script src="<?= base_url('assets/js/axios.js'); ?>"></script>        

    <!-- datatables -->    
      <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">    
      <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
      <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <!-- end datatables -->

    <?= $this->renderSection('head'); ?>
    <?= $this->renderSection('css'); ?>
  </head>
  <body>    
  <?php $role=session()->get('roleLogin'); ?>

    <input type="hidden" id="base-url" value="<?= base_url(); ?>">
    <input type="hidden" id="page" value="<?= (isset($page) && $page) ? $page : 'Get-House of English Kuningan'; ?>">
    
    <div id="app">
        
        <div class="small">
          <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        
    <?= $this->renderSection('js'); ?>
    <!-- navbar -->
    <script>
      $(document).ready(function(){
          $("#menu-sidebar").click(function(){
            let icon = $(this).find('#icon').prop('class');
              if(icon=='fas fa-bars'){
                $('#sidebar, #barrier-back-sidebar').addClass('active')                
                $(this).find('#icon').removeClass("fa-bars").addClass('fa-times')
              }else{
                $('#sidebar, #barrier-back-sidebar').removeClass('active')
                $(this).find('#icon').removeClass("fa-times").addClass('fa-bars')
              }
          })

          $("#barrier-back-sidebar").click(function(){
            $("#menu-sidebar").click();            
          })

          $("#navbar-profile, #menu-navbar #close").click(function(){
            $('#menu-navbar').toggleClass('d-none')
          })                          
      })
    </script>    

    <?php if($role=='user' || $role=='admin') : ?>
      <script>
        $(document).ready(function(){
          $('#main-content').append(`
            <div class="position-absolute acc-bottom w-100" style="bottom:0;">
              <img src="/assets/image-components/acc-user-main-content.png" alt="" class="w-100">
            </div>`)
            $('#main-content').css('padding-bottom','250px')
        })
      </script>  
    <?php else: ?>
      <script>
        $(document).ready(function(){
          $('#main-content').css('padding-bottom','250px')
        })
      </script>
    <?php endif; ?>
  </body>
</html>