<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<?= view('components/sidebar'); ?>
<div id="main-content">
    <div class="" id="history-quiz">
        <?= view('components/navbar'); ?>        
        <div class="px-lg-4 px-3">
            <div class="table-responsive">
                <table class="table small table-bordered">
                    <thead>
                        <tr>
                            <th width="40px">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Score</th>                        
                            <th>Total Question</th>                        
                            <th>Level</th>                        
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in dataUsers">
                            <td>{{index+1}}</td>
                            <td>{{item.name}}</td>                        
                            <td>{{item.email}}</td>                        
                            <td>{{item.status_progress}}</td>                        
                            <td>{{item.score}}</td>                        
                            <td>{{item.total_question}}</td>                                                                    
                            <td>{{item.level}}</td>                                                                    
                            <td class="d-flex">
                                <a :href="'/quiz/score/'+item.user_id" class="badge bg-primary me-2">Detail</a>
                                <div class="badge bg-warning text-dark cursor-pointer" @click="creteLevel(item.id)">Level</div>                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalCreateLevel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Level</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control form-control-sm mt-2" readonly :value="userCreateLevel.name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="text" class="form-control form-control-sm mt-2" readonly :value="userCreateLevel.email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Score</label>
                            <input type="text" class="form-control form-control-sm mt-2" readonly :value="userCreateLevel.score">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Level</label>
                            <input type="text" class="form-control form-control-sm mt-2 border-primary" id="level-user" :value="userCreateLevel.level" placeholder="please enter level here">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <div class="text-success fw-bold" v-html="messageLevel"></div>
                        <div>
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary btn-save" @click="saveLevel(userCreateLevel.id)">Save</button>                        
                        </div>
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
    const {createApp} = Vue;
    createApp({
        data(){
            return{
                titlePage:'History',
                baseUrl: $('#base-url').val(),
                dataUsers:{},
                userCreateLevel:{},          
                messageLevel:null,                
            }
        },
        methods:{
            async listUsersQuiz()
            {
                try{
                    const response = await axios.get(this.baseUrl+'admin/history/data-user');
                    let res = response.data;
                    console.log(res)
                    if(res.status =='success'){
                        this.dataUsers = res.data;
                    }
                }catch(error){
                    console.log(error.response)
                }
            },
            creteLevel(id)
            {        
                this.dataUsers.map((item, index)=>{
                    if(item.id == id){
                        this.userCreateLevel = item;
                    }
                })                                        
                $('#modalCreateLevel').modal('show')
            },
            async saveLevel(id)
            {
                try{
                    let params = {
                        'id' : id,
                        'level' : $('#level-user').val(),
                    }
                    console.log(params)
                    const response = await axios.post(this.baseUrl+'admin/history/create-level-user', params ,{
                        headers:{
                            "Content-type" : 'multipart/form-data'
                        }
                    })
                    let res = response.data;

                    if(res.status =='success'){
                        this.messageLevel=res.message;
                        this.listUsersQuiz();                                         
                        $('#modalCreateLevel').modal('hide')
                        setTimeout(() => {
                            this.messageLevel=null;
                        }, 2000);                        
                    }

                }catch(error){
                    console.log(error.response)
                }
            }
        },
        mounted(){
            this.listUsersQuiz();
        }
    }).mount('#history-quiz')
</script>
<?= $this->endSection(); ?>