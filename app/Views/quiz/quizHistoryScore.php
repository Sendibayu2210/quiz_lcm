<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <div class="container mt-3" id="history-quiz">

        <div class="h5 mb-5">History & Score</div>
        <input type="hidden" id="id-user"  value="<?= $idUser; ?>">

        <?php if($status=='finish') : ?> 
        <div class="row">
            <div class="col-lg-8 small"> 
                <div class="alert border mb-2" v-for="(item, index) in historyQuestion">
                    <div v-html="(index+1) + '. ' + item.question"></div>
                    <ul class="list-unstyled mt-1">
                        <li v-for="(mc, idx) in item.multiple_choice" :class="(item.id_choice_selected===mc.id_choice) ? 'text-primary fw-bold' : ''">{{ String.fromCharCode(65 + idx) }}. {{mc.choice_text}}</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 mx-auto">
                <div class="card mx-auto br-15 border-primary border-0">
                    <div class="card-body mb-5">
                        <div class="mx-auto border text-center border-primary p-2 br-10 bg-white shadow text-primary" style="width: 130px; margin-top: -35px;">
                            Score
                        </div>
                        <div class="my-4 text-center mt-5">
                            <div class="p-2 bg-primary btn px-4 text-center fw-bold fs-5"><?= $data['score']; ?></div>
                        </div>
    
                        <div class="mt-4 text-center">
                            <div class="mb-2">
                                <div class="badge bg-info-light px-5 p-2"><i class="fas fa-check me-2"></i>Right Answer <?= $data['totalCorrect']; ?></div>
                            </div>
                            <div>
                                <div class="badge bg-danger-light px-5 p-2"><i class="fas fa-times me-2"></i>Wrong Answer <?= $data['totalWrong']; ?></div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="card mt-3 br-15 border-primary">
                    <div class="card-body small">
                        <div class="mb-3 fw-bold text-primary border-bottom  pb-2">Data User</div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>Name</div>
                            <div>{{dataUserQuiz.name}}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>Email</div>
                            <div>{{dataUserQuiz.email}}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>Start Quiz</div>
                            <div>{{dataUserQuiz.start_time}}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div>End Quiz</div>
                            <div>{{dataUserQuiz.end_time}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="my-5 text-center text-danger fw-bold">
                <div>Sorry, your quiz cannot be completed!!</div>
                <a href="/quiz" class="mt-4 btn btn-primary px-4 btn-sm">Back to Quiz</a>
            </div>
        <?php endif;; ?>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    const {createApp}=Vue;
    createApp({
        data(){
            return{
                baseUrl : $('#base-url').val(),
                historyQuestion:{},
                dataUserQuiz:{},
            }
        },
        methods:{
            async getDataQuiz()
            {
                let idUser = $('#id-user').val();
                let paramsId = (idUser!='') ? ('/'+idUser) : '';
                
                this.dataUser(idUser)

                try{    
                    const response = await axios.get(this.baseUrl+'quiz/data'+paramsId);
                    let res = response.data;                          
                    if(res.status == 'success'){
                        this.historyQuestion = res.data                         
                    }                                        
                }catch(error){
                    console.log(error.response)
                }
            },
            
            async dataUser(id)
            {
                try{    
                    const response = await axios.get(this.baseUrl+'quiz/data-user/'+id);
                    let res = response.data;      
                    console.log(res)              
                    if(res.status == 'success'){
                        this.dataUserQuiz = res.data                         
                    }                                        
                }catch(error){
                    console.log(error.response)
                }   
            }
        },
        mounted(){
            this.getDataQuiz();
        }
    }).mount('#history-quiz')
</script>
<?= $this->endSection(); ?>