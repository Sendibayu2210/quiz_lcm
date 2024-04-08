<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

    <?= view('components/sidebar'); ?>
    <div id="main-content">

        <div class="container">
            <div class="">             
                
                <div class="d-lg-flex mb-3 justify-content-between">
                    <div class="mb-3 h5">Manage Users</div>
                    <div>
                        <form action="<?= base_url('admin/users'); ?>" method="get">
                            <div class="form-group d-flex border br-50 p-1">
                                <input type="text" name="search" class="form-control. border-0 w-100 outline-none form-control-sm" placeholder="Search users here"
                                value="<?= (isset($_GET['search']) && $_GET['search']!='') ? $_GET['search'] : ''; ?>">
                                <button class="btn btn-sm btn-warning br-50"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                            
                <div class="table-responsive">
                    <table class="table w-100 small table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50px" class="text-center">No</th>
                                <th>Name</th>                                
                                <th>Email</th>                               
                                <th>Username</th>
                                <th>Birthday</th>                                
                                <th>Role</th>                                                              
                                <th>Action</th>                      
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $key => $dt) : ?> 
                                <tr>
                                    <td class="text-center"><?= $key+1; ?></td>                                                                                                                
                                    <td><?= $dt['name']; ?></td>                                
                                    <td><?= $dt['email']; ?></td>                                
                                    <td><?= $dt['username']; ?></td>                                
                                    <td><?= $dt['birthday']; ?></td>
                                    <td><?= $dt['role']; ?></td>                                                                                                                        
                                    <td class="text-center">
                                        <a href="<?= base_url('admin/users/'.$dt['id']); ?>" class="badge bg-light text-dark">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>    
                            <?php endforeach; ?>                            
                        </tbody>
                    </table>
                </div>                        
                                
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>