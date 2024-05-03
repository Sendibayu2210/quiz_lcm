<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="">

    <div class="" id="question-list">
        <?= view('components/navbar'); ?>
            
        <div class="container px-lg-4" >      
            
        <div class="mb-3"><button type="button" @click="addEditPeriode()" class="btn btn-sm bg-primary fw-bold px-3">Add Periode</button></div>
        
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
                                    <td class="text-center d-flex align-items-center">
                                        <a href="/admin/questions-periode/<?= $dt['id']; ?>" class="badge bg-primary">detail</a>
                                        <button type="button" @click="addEditPeriode('<?= $dt['id']; ?>', '<?= $dt['periode']; ?>', '<?= $dt['status']; ?>')" class="badge bg-warning mx-1 border-0"><i class="fas fa-pencil"></i></button>
                                        <form action="/admin/questions/delete" method="post">
                                            <input type="hidden" name="id" value="<?= $dt['id']; ?>">
                                            <button type="submit" class="badge bg-danger border-0"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>                                
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-none">

            <div class="mt-4 d-lg-flex justify-content-between align-items-center">
                <div class="mb-3"><a href="/admin/questions/add" class="btn btn-sm bg-primary fw-bold">Add Questions</a></div>
                <div>
                    <div class="d-flex p-1 border br-50 bg-warning-light-2">
                        <input type="text" class="border-0 outline-none ms-2 w-100 bg-transparent" @keypress="searchQuestions" placeholder="search questions here" v-model="search">
                        <button class="btn btn-sm br-50 bg-primary" @click="btnSearchQuestions"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
    
            <div class="mt-4">
                <div class="p-2 px-3 small border mb-2 bg-warning-light-2 br-10" v-for="(item, index) in questionsList">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="question mb-3" v-html="item.question"></div>
                        </div>
                        <div class="col-lg-2 text-end">
                            <a :href="'/admin/questions/edit/'+item.id" class="badge bg-primary-light border-0 me-1"><i class="fas fa-pen"></i></a>
                            <button class="badge bg-danger-light border-0 text-white" @click="checkQuestionProgress(item.id)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <ul>
                        <li class="multiple-choice" v-for="data in item.multiple_choice" v-html="data.choice_text" :class="(data.is_correct=='true') ? 'fw-bold text-primary' : ''"></li>
                    </ul>
                </div>
    
                <div class="text-center">
                    <div class="text-center bg-warning-light-2 br-10 text-danger fw-bold p-3 px-5 border-primary" v-if="messageNotFound"><i class="fas fa-warning me-1"></i> Data not found</div>
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
                        <div v-html="modalMessage"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" @click="deleteQuestion">Delete</button>
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
                titlePage: 'Manage Questions',
                baseUrl: $('#base-url').val(),
                questionsList:{},
                search:'',
                messageNotFound:false,
                modalMessage:null,
                idQuestionOpen:null,

                isActive: false                
            }
        },
        methods:{
            async getQuestions(search=''){
                try{                    
                    this.messageNotFound = false

                    const response = await axios.get(this.baseUrl+'admin/questions/data?search='+search);
                    let res = response.data;
                    if(res.status=='success'){
                        this.questionsList = res.data
                    }
                    console.log(res)
                    if(res.data.length == 0 ){
                        this.messageNotFound = true
                    }
                }catch(error){
                    console.log(error.response)
                }
            },
            searchQuestions(event){
                if (event.keyCode === 13) {
                    this.getQuestions(this.search)
                }
            },
            btnSearchQuestions(){
                this.getQuestions(this.search)
            },
            async checkQuestionProgress(id){
                try{
                    const response = await axios.post(this.baseUrl+'admin/questions/check-delete', {'id':id}, {
                        headers:{
                            'Content-type':'multipart/form-data'
                        }
                    });
                    let res = response.data;
                    if(res.status=='confirmation'){
                        this.modalMessage = res.message;
                        $('#modal-confirmation').modal('show')
                        this.idQuestionOpen = id
                    }
                    if(res.status=='success'){
                        this.getQuestions(this.search)
                    }
                }catch(error){
                    console.log(error.response)
                }
            },
            async deleteQuestion()
            {
                try{
                    const response = await axios.post(this.baseUrl+'admin/questions/delete',{'id':this.idQuestionOpen},{
                        headers:{
                            'Content-type':'multipart/form-data'
                        }
                    })
                    let res = response.data;                    
                    if(res.status=='success'){
                        this.getQuestions(this.search)
                        $('#modal-confirmation').modal('hide')
                        
                    }

                }catch(error){
                    console.log(error.response)
                }
            },

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
            }
        },
        mounted(){
            this.getQuestions();
            new DataTable('#data-table');
        }
    }).mount('#question-list')
</script>
<?= $this->endSection(); ?>
