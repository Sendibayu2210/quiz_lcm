<?php $role = session()->get('roleLogin'); ?>

<div id="sidebar" class="bg-primary mh-100vh">

    <div class="p-4 text-center fw-bold">
        <div>GET HOUSE OF ENGLISH</div>
        <div>KUNINGAN</div>
    </div>
    <ul class="list-unstyled p-4 ">
        <!-- Admin -->
        <li><a href="/dashboard"><i class="fas fa-home fa-fw me-1"></i> Home</a></li>
        <?php if($role=='admin') : ?> 
            <li><a href="/admin/users"><i class="fas fa-users fa-fw me-1"></i> Manage Users</a></li>
            <li><a href="/admin/questions"><i class="fas fa-book-open fa-fw me-1"></i> Manage Question</a></li>
            <li><a href="/admin/history"><i class="fas fa-history fa-fw me-1"></i> History Quiz</a></li>
        <?php endif; ?>
                        
        <?php if($role=='user') : ?> 
            <li><a href="/quiz/attention"><i class="fas fa-laptop fa-fw me-1"></i> Quiz</a></li>
            <li><a href="/quiz/score"><i class="fas fa-history fa-fw me-1"></i>History Quiz</a></li>
        <?php endif; ?>
            
        <li><a href="/logout"><i class="fas fa-sign-out-alt fa-fw me-1"></i> Logout</a></li>

    </ul>

</div>