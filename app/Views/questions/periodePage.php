<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="">

    <div class="" id="question-list">
        <?= view('components/navbar'); ?>
            
        <div class="container px-lg-4" >      
            
        <div class="mb-3"><button type="button" @click="addEditPeriode()" class="btn btn-sm bg-primary fw-bold px-3">Add Periode</button></div>

        <?php if(session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        
        <div class="card bg-warning-light border border-3 border-primary br-15">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="w-100" id="data-table">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th class="text-center">Periode</th>
                                <th class="text-center">Count Questions</th>
                                <th class="text-center">Count Student Quiz</th>
                                <th class="text-center">Status</th>
                                <th width="80">Timer</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no=1; foreach($periode as $dt) : ?> 
                                <tr class="border-0 border-bottom border-1 border-secondary">
                                    <td class="text-center p-2"><?= $no++; ?></td>
                                    <td class="text-center"><?= $dt['periode']; ?></td>
                                    <td class="text-center"><?= $dt['total_questions']; ?></td>
                                    <td class="text-center"><?= $dt['total_user_quizzes']; ?></td>
                                    <td class="text-center"><?= $dt['status']; ?></td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" @keyup="setTiming('<?= $dt['id']; ?>', $event)" value="<?= $dt['quiz_timer']; ?>">                                            
                                        </div>
                                    </td>
                                    <td class="text-center d-flex align-items-center">
                                        <a href="/admin/questions-periode/<?= $dt['id']; ?>" class="badge bg-primary">detail</a>
                                        <button type="button" @click="addEditPeriode('<?= $dt['id']; ?>', '<?= $dt['periode']; ?>', '<?= $dt['status']; ?>')" class="badge bg-warning mx-1 border-0"><i class="fas fa-pencil"></i></button>                                        
                                        <button type="button" class="badge bg-danger border-0" @click="deletePeriode('<?= $dt['id']; ?>')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>                                
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        

        <!-- Modal add periode-->
        <div class="modal fade" id="modal-add-edit-periode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Periode</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <form action="/admin/periode/save" method="post">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="">Periode Name</label>
                                <input type="hidden" id="id-periode" name="id">
                                <input type="text" class="form-control mt-2" id="input-periode" name="periode" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Status</label>     
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="status" role="switch" id="status-periode" value="active" v-model="isActive">
                                    <label class="form-check-label" for="status-periode">
                                        {{ isActive ? 'active' : 'nonactive' }}
                                    </label>
                                </div>                                                           
                            </div>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal-confirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this period? <br> This action will remove all questions and quiz history.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <form action="/admin/periode/delete" method="post">
                        <input type="hidden" name="id" v-model="idPeriodeSelected">
                        <button type="submit" class="btn btn-danger">Delete</button>                        
                    </form>
                </div>
                </div>
            </div>
        </div>   

        </div>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    const {createApp} = Vue
    createApp({
        data(){
            return{
                titlePage: 'Manage Quiz',
                baseUrl: $('#base-url').val(),                
                idPeriodeSelected: 0,
                isActive: false                
            }
        },
        methods:{                        
            addEditPeriode(id='', periode='', status=''){
                let modal = $('#modal-add-edit-periode')
                modal.modal('show')
                idPeriode = $('#id-periode');
                inputPeriode = $('#input-periode');
                idPeriode.val('')
                inputPeriode.val('')
                if(id!=''){
                    idPeriode.val(id)
                    inputPeriode.val(periode)
                }
                if(status=='nonactive'){
                    this.isActive = false
                }
                if(status=='active'){
                    this.isActive = true
                }
            },
            deletePeriode(id){
                this.idPeriodeSelected = id
                $('#modal-confirmation').modal('show')
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
            },
        },
        mounted(){            
            new DataTable('#data-table');
        }
    }).mount('#question-list')
</script>
<?= $this->endSection(); ?>
