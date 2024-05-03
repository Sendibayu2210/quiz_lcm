<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content">
    <div class="" id="history-quiz">
        <?= view('components/navbar'); ?>
        
        <div class="px-lg-4 pt-4 d-flex justify-content-center">            
            <input type="hidden" id="id-quizzes"  value="<?= $idQuizzes; ?>">
            <input type="hidden" id="id-periode"  value="<?= $idPeriode; ?>">

            <?php if($status=='finish') : ?> 
            <div class="row container">
                <div class="col-lg-8 small order-lg-1 order-2"> 
                    <div class="alert border bg-warning-light br-10 mb-2" v-for="(item, index) in historyQuestion">
                        <div v-html="(index+1) + '. ' + item.question"></div>
                        <ul class="list-unstyled mt-1">
                            <li v-for="(mc, idx) in item.multiple_choice" :class="(item.id_choice_selected===mc.id_choice) ? 'text-primary fw-bold' : ''">{{ String.fromCharCode(65 + idx) }}. {{mc.choice_text}}</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 mx-auto order-lg-2 order-1 mb-3">
                    <div class="card mx-auto br-15 border-primary border-0 bg-warning-light">
                        <div class="card-body mb-5">
                            <div class="mx-auto border text-center border-primary p-2 br-10 bg-warning-light shadow text-primary" style="width: 130px; margin-top: -35px;">
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
                    <div class="card mt-3 br-15 border-primary bg-warning-light">
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
                <div class="text-center text-danger fw-bold bg-warning-light w-100 py-5 br-10 border-primary border-2">
                    <div class="mb-2 h5"><i class="fas fa-warning"></i></div>
                    <div>Sorry, your quiz cannot be completed!!</div>
                    <a href="/quiz" class="mt-4 btn btn-primary px-4 btn-sm">Back to Quiz</a>
                </div>
            <?php endif; ?>
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
                titlePage:'History & Score',
                baseUrl : $('#base-url').val(),
                historyQuestion:{},
                dataUserQuiz:{},
            }
        },
        methods:{
            async getDataQuiz()
            {
                let idQuizzes = $('#id-quizzes').val();
                let paramsId = (idQuizzes!='') ? ('/'+idQuizzes) : '';                        
                this.dataUser(idQuizzes)

                try{    
                    const response = await axios.get(this.baseUrl+'quiz/data'+paramsId);
                    let res = response.data;     
                    console.log(res)                     
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
                        if(res.data!=null){
                            this.dataUserQuiz = res.data                         
                        }
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