<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

    <?= view('components/sidebar'); ?>
    <div id="main-content">
                
        <div class="" id="list-users">
            <?= view('components/navbar'); ?>
            <div class="container px-lg-4">             
                                                    
                <div class="bg-warning-light p-3 br-10 border-primary border-2 mt-4">
                    <div style="margin-top: -25px;" class="mb-4"><span class="bg-primary p-2 px-5 br-10 border-light border-3 border">List Users</span></div>
                    <?php if(count($users) > 0) : ?>
                        <div class="table-responsive">
                            <table class="table- br-10 w-100 small table-border table-striped table-hover" id="data-table">
                                <thead>
                                    <tr>
                                        <th width="50px" class="text-center">No</th>
                                        <th>Name</th>                                
                                        <th>Email</th>                               
                                        <th>Username</th>
                                        <th class="text-start">Birthday</th>                                
                                        <th>Role</th>                                               
                                        <th>Action</th>                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $key => $dt) : ?> 
                                        <tr id="row-<?= $dt['id'] ?>" class="border-0 border-bottom border-1 border-secondary">
                                            <td class="text-center p-2"><?= $key+1; ?></td>                                                                                                                
                                            <td><?= $dt['name']; ?></td>                                
                                            <td><?= $dt['email']; ?></td>                                
                                            <td><?= $dt['username']; ?></td>                                
                                            <td class="text-start"><?= $dt['birthday']; ?></td>
                                            <td><?= $dt['role']; ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/users/'.$dt['id']); ?>" class="badge bg-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>    
                                    <?php endforeach; ?>                            
                                </tbody>
                            </table>
                        </div>    
                    <?php else: ?>                    
                        <div class="text-center fw-bold text-danger pb-3"><i class="fas fa-warning me-1"></i> Data not found</div>
                    <?php endif; ?>                    
                </div>
                                
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        this user has been progressed! <br> do you want to delete progress for this user ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-light " data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-danger" @click="deleteProgressQuiz">Delete</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script>
    const {createApp}=Vue;
    createApp({
        data(){
            return{
                baseUrl:$('#base-url').val(),
                idUserSelected:null,
                titlePage:'Manage Users',
            }
        },
        methods:{            
        },
        mounted(){
            new DataTable('#data-table')
        }
    }).mount('#list-users')
</script>
<?= $this->endSection(); ?>