<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="">

    <div class="" id="question-list">
        <?= view('components/navbar'); ?>
            
        <div class="container px-lg-4" >      
        
            <div class="d-flex mb-3 menu-top">
                <a href="/admin/questions-periode/<?= $id_periode; ?>" class="btn btn-primary br-5 btn-sm px-3 me-1">questions</a>
                <a href="/admin/students-periode/<?= $id_periode; ?>" class="btn btn-warning-light border-primary border-2 br-5 btn-sm px-3 me-1">add students</a>                                
                <input type="hidden" id="id_periode" value="<?= $id_periode; ?>">            
            </div>
            
        
            <div id="card-question">
                <?php if(session()->getFlashdata('error')) : ?>
                    <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                        <?= session()->getFlashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                        <?= session()->getFlashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card bg-warning-light">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="/admin/questions/add?id_periode=<?= $id_periode; ?>" class="btn btn-sm btn-primary me-1">Add Questions</a>
                            <button data-bs-toggle="modal" data-bs-target="#exportQuestions" class="btn btn-warning-light border-primary border-2 br-5 btn-sm px-3 me-1">export to other periode</button>
                        </div>                
                        <div class="table-responsive">
                            <table class="table- w-100" id="data-table">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th width="450">Question</th>
                                        <th>Is Correct</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in questionsList" class="border-0 border-bottom border-1 border-secondary">
                                        <td class="text-center p-2">{{index+1}}</td>
                                        <td>{{item.question}}</td>
                                        <td>
                                            <div v-for="(data, i) in item.multiple_choice">
                                                <div v-if="data.is_correct=='true'">{{data.choice_text}}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <button @click="showQuestion(index)" class="badge bg-primary">detail</button>
                                                <a :href="'/admin/questions/edit/'+item.id" class="badge bg-warning mx-1 border-0"><i class="fas fa-pencil"></i></a>                                            
                                                <button type="button" @click="checkQuestionProgress(item.id)" class="badge bg-danger border-0"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                
                        </div>
                    </div>            
                </div>            
            </div>                        

            <!-- Modal show question -->
            <div class="modal fade" id="modal-show-question" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Show Question</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-2 px-3 small border mb-2 bg-warning-light-2 br-10">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="question mb-3" v-html="questionSelect.question"></div>
                                </div>
                                <div class="col-lg-2 text-end">
                                    <a :href="'/admin/questions/edit/'+questionSelect.id" class="badge bg-primary-light border-0 me-1"><i class="fas fa-pen"></i></a>
                                    <button class="badge bg-danger-light border-0 text-white" @click="checkQuestionProgress(questionSelect.id)"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <ul class="list-unstyled"> 
                                <li class="multiple-choice" v-for="(data, index) in questionSelect.multiple_choice" :class="(data.is_correct=='true') ? 'fw-bold text-primary' : ''">{{ String.fromCharCode(65 + index)}}. {{data.choice_text }}</li>
                            </ul>
                        </div>
            
                        <div class="text-center">
                            <div class="text-center bg-warning-light-2 br-10 text-danger fw-bold p-3 px-5 border-primary" v-if="messageNotFound"><i class="fas fa-warning me-1"></i> Data not found</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>                        
                    </div>
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

            <!-- Modal delete user quiz -->
            <div class="modal fade" id="exportQuestions" tabindex="-1" aria-labelledby="exportQuestionsLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exportQuestionsLabel">Export Question</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin/questions/export" method="post">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="">From Periode</label>
                                <select name="from-periode" id="" class="form-select form-select-sm" readonly>
                                    <option value="<?= $periode['id']; ?>"><?= $periode['periode']; ?></option>
                                </select>                            
                            </div>

                            <div class="form-group mb-3">
                                <label for="">To Periode</label>
                                <select name="to-periode" id="" class="form-select form-select-sm mt-2" required>
                                    <option value="">Choose</option>
                                    <?php foreach($allPeriode as $dt) : ?> 
                                        <option value="<?= $dt['id']; ?>"><?= $dt['periode']; ?></option>
                                    <?php endforeach; ?>
                                </select>                            
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-light " data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Export</button>
                        </div>
                    </form>
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
                titlePage: 'Manage Questions periode <?= $periode['periode']; ?>',
                baseUrl: $('#base-url').val(),
                questionsList:{},
                search:'',
                messageNotFound:false,
                modalMessage:null,
                idQuestionOpen:null,
                questionSelect:{},

                isActive: false,                
            }
        },
        methods:{
            async getQuestions(search=''){
                try{                    
                    this.messageNotFound = false
                    let idPeriode = $('#id_periode').val();                    
                    const response = await axios.get(this.baseUrl+'admin/questions/data?id_periode='+idPeriode+'&search='+search);
                    let res = response.data;
                    if(res.status=='success'){
                        this.questionsList = res.data
                    }                    
                    if(res.data.length == 0 ){
                        this.messageNotFound = true
                    }
                    setTimeout(() => {
                        new DataTable('#data-table');
                    }, 100);
                }catch(error){
                    console.log(error.response)
                }
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
            showQuestion(index){                
                this.questionSelect = this.questionsList[index]
                $("#modal-show-question").modal('show')
            },                          

        },
        mounted(){
            this.getQuestions();
            new DataTable('#data-table-2')
            
        }
    }).mount('#question-list')
</script>
<?= $this->endSection(); ?>
