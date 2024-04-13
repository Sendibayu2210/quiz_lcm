<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="">

    <div class="" id="question-list">
        <?= view('components/navbar'); ?>
        
        <div class="container" >        

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div><a href="/admin/questions/add" class="btn btn-sm bg-warning">Add Questions</a></div>
                <div>
                    <div class="d-flex p-1 border br-50">
                        <input type="text" class="border-0 outline-none ms-2" @keypress="searchQuestions" placeholder="search questions here" v-model="search">
                        <button class="btn btn-sm br-50 bg-warning" @click="btnSearchQuestions"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="p-2 px-3 small border mb-2" v-for="(item, index) in questionsList">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="question mb-3" v-html="item.question"></div>
                        </div>
                        <div class="col-lg-2 text-end">
                            <a :href="'/admin/questions/edit/'+item.id" class="badge bg-warning border-0 text-dark me-1"><i class="fas fa-pen"></i></a>
                            <button class="badge bg-danger border-0 text-white" @click="checkQuestionProgress(item.id)"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                    <ul>
                        <li class="multiple-choice" v-for="data in item.multiple_choice" v-html="data.choice_text" :class="(data.is_correct=='true') ? 'fw-bold text-primary' : ''"></li>
                    </ul>
                </div>

                <div class="text-center text-danger" v-if="messageNotFound">Data not found</div>

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
            }
        },
        mounted(){
            this.getQuestions();
        }
    }).mount('#question-list')
</script>
<?= $this->endSection(); ?>
