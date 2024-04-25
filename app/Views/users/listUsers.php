<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

    <?= view('components/sidebar'); ?>
    <div id="main-content">
                
        <div class="" id="list-users">
            <?= view('components/navbar'); ?>
            <div class="container px-lg-4">             
                
                <div class="d-lg-flex mb-3 justify-content-between">                    
                    <div></div>
                    <div>
                        <form action="<?= base_url('admin/users'); ?>" method="get">
                            <div class="form-group d-flex border br-50 p-1 bg-warning-light border-primary">
                                <input type="text" name="search" class="form-control. border-0 bg-transparent w-100 outline-none form-control-sm" placeholder="Search users here"
                                value="<?= (isset($_GET['search']) && $_GET['search']!='') ? $_GET['search'] : ''; ?>">
                                <button class="btn btn-sm btn-primary br-50"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                            
                <div class="bg-warning-light p-3 br-10 border-primary border-2 mt-4">
                    <div style="margin-top: -25px;" class="mb-4"><span class="bg-primary p-2 px-5 br-10 border-light border-3 border">List Users</span></div>
                    <?php if(count($users) > 0) : ?>
                        <div class="table-responsive">
                            <table class="table- br-10 w-100 small table-border table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="50px" class="text-center">No</th>
                                        <th>Name</th>                                
                                        <th>Email</th>                               
                                        <th>Username</th>
                                        <th>Birthday</th>                                
                                        <th>Role</th>       
                                        <th class="text-center" width="70px">Set Quiz</th>                                                       
                                        <th class="text-center" width="70px">Set Timer</th> 
                                        <th>Action</th>                      
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $key => $dt) : ?> 
                                        <tr id="row-<?= $dt['id'] ?>" class="border-0 border-bottom border-1 border-secondary">
                                            <td class="text-center"><?= $key+1; ?></td>                                                                                                                
                                            <td><?= $dt['name']; ?></td>                                
                                            <td><?= $dt['email']; ?></td>                                
                                            <td><?= $dt['username']; ?></td>                                
                                            <td><?= $dt['birthday']; ?></td>
                                            <td><?= $dt['role']; ?></td>    
                                            <td>                                  
                                                <div class="d-flex justify-content-center">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input border-primary" type="checkbox" role="switch" id="set-quiz-<?= $dt['id']; ?>" value="<?= $dt['id']; ?>" @change="settingQuiz('<?= $dt['id']; ?>')" <?= ($dt['user_quiz']==true) ? 'checked' : ''; ?>> 
                                                    </div>
                                                </div>      
                                            </td>                     
                                            <td class="position-relative">
                                                <input type="number" class="form-control form-control-sm" value="<?= $dt['timing']; ?>" @keyup="setTiming('<?= $dt['id']; ?>', $event)">
                                                <div class="invalid-feedback timing bg-light border danger position-absolute" style="right: 0; z-index: 3; margin-top: -100px;"></div>
                                            </td>                                                                                               
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
            async settingQuiz(idUser)
            {
                try{
                    const response = await axios.post(this.baseUrl+'quiz/manage-user',{'id':idUser},{
                        headers:{
                            'Content-type':'multipart/form-data'
                        }
                    })
                    let res = response.data;
                    console.log(res)
                    if(res.status=='success'){

                    }
                    if(res.status == 'confirmation'){
                        $("#set-quiz-"+idUser).prop('checked', true)
                        $('#exampleModal').modal('show')
                        this.idUserSelected = idUser
                        $('#set-quiz-'+idUser).prop('checked',true)
                    }
                }catch(error){
                    console.log(error.response)
                }
            },
            async deleteProgressQuiz()
            {                                
                try{
                    const response = await axios.post(this.baseUrl+'admin/quiz/delete-progress', {'id': this.idUserSelected}, {
                        headers:{
                            'Content-type':'multipart/form-data'
                        }
                    })
                    let res = response.data;                    
                    if(res.status == 'success'){
                        $('#exampleModal').modal('hide')
                        $('#set-quiz-'+this.idUserSelected).prop('checked',false)
                        this.idUserSelected = null
                    }
                }catch(error){
                    console.log(error.response)
                }
            },
            async setTiming(id, event)
            {
                let time = event.target.value;
                let params = {
                    'id':id,
                    'time':time,
                }
                $(event.target).removeClass('is-valid is-invalid');
                $(".invalid-feedback.timing").html('');

                try{
                    const response = await axios.post(this.baseUrl + 'admin/quiz/set-timing', params, {
                        headers:{
                            'Content-type':'multipart/form-data',
                        }
                    })
                    let res = response.data;                    
                    if(res.status=='success'){                    
                        $(event.target).addClass('is-valid');
                    }else{
                        $(event.target).addClass('is-invalid');            
                        $(".invalid-feedback.timing").html(res.message);
                    }
                    setTimeout(() => {
                        $(event.target).removeClass('is-valid is-invalid');
                        $(".invalid-feedback.timing").html('');
                    }, 2000);
                }catch(error){
                    console.log(error.response)
                }
            }
        }
    }).mount('#list-users')
</script>
<?= $this->endSection(); ?>