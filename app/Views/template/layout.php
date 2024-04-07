<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= (isset($title) && $title) ? $title : 'Get-House of English Kuningan'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <script src="<?= base_url('assets/js/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/vue.global.js'); ?>"></script>
    <script src="<?= base_url('assets/js/axios.js'); ?>"></script>        
    
    <?= $this->renderSection('head'); ?>
    <?= $this->renderSection('css'); ?>
  </head>
  <body>    

    <input type="hidden" id="base-url" value="<?= base_url(); ?>">
    <input type="hidden" id="page" value="<?= (isset($page) && $page) ? $page : 'Get-House of English Kuningan'; ?>">
    
    <div id="app">
        
        <div class="small">
          <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>        
    <?= $this->renderSection('js'); ?>
  </body>
</html>