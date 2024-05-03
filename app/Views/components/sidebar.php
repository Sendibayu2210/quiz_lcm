<?php $role = session()->get('roleLogin'); ?>

<div id="barrier-back-sidebar"></div>
<div id="sidebar" class="bg-primary mh-100vh">
    
    <div class="position-relative text-center">
        <img src="/assets/image-components/logo gethouse.png" alt="" class="w-75">
    </div>
    
    <ul class="list-unstyled p-4 mt-3">
        <!-- Admin -->
        <li><a href="/dashboard"><i class="fas fa-home fa-fw me-1"></i> Home</a></li>
        <?php if($role=='admin') : ?> 
            <li><a href="/admin/users"><i class="fas fa-users fa-fw me-1"></i> Manage Users</a></li>
            <li><a href="/admin/periode"><i class="fas fa-book-open fa-fw me-1"></i> Manage Question</a></li>
            <li><a href="/admin/history"><i class="fas fa-history fa-fw me-1"></i> History Quiz</a></li>
        <?php endif; ?>
                        
        <?php if($role=='user') : ?> 
            <li><a href="/quiz/start"><i class="fas fa-laptop fa-fw me-1"></i> Quiz</a></li>
            <li><a href="/quiz/history"><i class="fas fa-history fa-fw me-1"></i>History Quiz</a></li>
        <?php endif; ?>
            
        <li><a href="/logout"><i class="fas fa-sign-out-alt fa-fw me-1"></i> Logout</a></li>

    </ul>

</div>