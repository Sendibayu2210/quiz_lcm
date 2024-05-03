<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="">

    <div class="" id="question-list">
        <?= view('components/navbar'); ?>
            
        <div class="container px-lg-4" >      
        
            <div class="d-flex mb-3 menu-top">
                <a href="/admin/questions-periode/<?= $id_periode; ?>" class="btn btn-primary br-5 btn-sm px-3 me-1" @click="menuTop('question', $event)">questions</a>
                <a href="/admin/students-periode/<?= $id_periode; ?>" class="btn btn-warning-light border-primary border-2 br-5 btn-sm px-3 me-1" @click="menuTop('add-student', $event)">add students</a>                
                <input type="hidden" id="id_periode" value="<?= $id_periode; ?>">            
            </div>
            
        
            <div id="card-question">
                <div class="card bg-warning-light">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="/admin/questions/add?id_periode=<?= $id_periode; ?>" class="btn btn-sm bg-primary fw-bold me-1">Add Questions</a>
                            <button class="btn btn-warning-light border-primary border-2 br-5 btn-sm px-3 me-1">export to other periode</button>
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

            <div id="card-student" class="bg-warning-light p-3 br-10 border-primary border-2 mt-4 d-none">
                <!-- <div style="margin-top: -25px;" class="mb-4"><span class="bg-primary p-2 px-5 br-10 border-light border-3 border">List Users</span></div> -->
                <?php if(count($users) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table- br-10 w-100 small table-border table-striped table-hover" id="data-table-2">
                            <thead>
                                <tr>
                                    <th width="50px" class="text-center">No</th>
                                    <th>Name</th>                                
                                    <th>Email</th>                               
                                    <th>Username</th>                              
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
                    console.log(res)
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
            menuTop(category, event){
                console.log(category)

                let menu = $('.menu-top');
                menu.find('button').removeClass('btn-primary').addClass('btn-warning-light border-primary border-2')
                $(event.target).addClass('btn-primary').removeClass('btn-warning-light border-primary border-2')

                if(category=='add-student'){                    
                    console.log('st')
                    $('#card-student').removeClass('d-none')
                    $('#card-question').addClass('d-none')
                }

                if(category=='question'){
                    console.log('qu')
                    $('#card-question').removeClass('d-none')
                    $('#card-student').addClass('d-none')
                }


            },

        },
        mounted(){
            this.getQuestions();
            new DataTable('#data-table-2')
            
        }
    }).mount('#question-list')
</script>
<?= $this->endSection(); ?>
