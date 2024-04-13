<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<?= view('components/sidebar'); ?>
<div id="main-content">
    <div id="quiz">
        <div class="row mh-100vh small" >
            <div class="col-lg-9">                
                <div class="container mt-4">
                    <div class="mb-4">
                        <span class="h4 text-secondary fw-bold">Quiz</span>
                    </div>

                    <div class="card border border-1 border-primary">
                        <div class="card-body">
                            <div class="" v-html="(openNumber+1)+'. '+showQuestion.question" style="font-size:13px;"></div>
    
                            <div class="mt-4 "> 
                                <div class="border cursor-pointer p-2 mb-2 d-flex card-multiple-choice br-5" v-for="(item, index) in showQuestion.multiple_choice" @click="selectedChoices(showQuestion.id, item.id_choice)" :id="'card-mc-'+item.id_choice" :class="(showQuestion.id_choice_selected===item.id_choice) ? 'bg-primary text-white' :'' ">
                                    <button class="btn border btn-sm me-3 border-0 border-end" :class="(showQuestion.id_choice_selected===item.id_choice) ? 'bg-warning' : ''"> {{ String.fromCharCode(65 + index) }}</button>
                                    <span v-html="item.choice_text"></span>
                                </div>
    
                                <div class="small my-1 message-selected-choice" v-html="messageSelectedChoice"></div>
                            </div>
                        </div>
                    </div>
    
                    <div class="mt-4 text-end">
                        <button type="button" class="btn bg-primary text-white me-2 px-3 border border-light border-3 btn-sm" v-if="openNumber > 0" @click="btnPreviousNext('prev')">Previous</button>
                        <button type="button" class="btn bg-primary text-white px-4 border border-light border-3 btn-sm" v-if="lastNumberHide" @click="btnPreviousNext('next')">Next</button>
                    </div>
    
                </div>
            </div>
            <div class="col-lg-3 bg-primary">
                <div class="mt-5">
                    <div class="mx-5 bg-danger h3 fw-bold text-center border border-light border-3 py-1 br-15">00:00</div>
                </div>
                <div class="mt-3 mb-3 text-center">
                    
                <div 
                    v-for="(item, index) in questions" :id="'box-number-' + index" class="badge border border-2 p-2 m-1 cursor-pointer"
                    :class="(item.id_question_selected != '') ? 'bg-success text-white border-white' : 'box-number bg-light text-info border-info'"    
                    @click="detailQuestion(index)">
                        {{ (index<=8) ? '0'+(index+1) : (index+1) }}                    
                    </div>
                </div>
    
                <div class="my-3 text-center">
                    <button class="btn bg-warning px-5 fw-bold text-primary border border-light border-3 btn-sm" @click="confirmFinishQuiz">Finish</button>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="message-modal"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <form action="/quiz/finish" method="post">
                        <button  type="submit" class="btn bg-primary">Finish</button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const {createApp} = Vue
    createApp({
        data(){
            return{
                baseUrl : $('#base-url').val(),
                questions:{},
                showQuestion:{},
                openNumber:0,
                lastNumber:0,
                lastNumberHide:true,
                messageSelectedChoice:'',
            }
        },
        methods:{
            async getDataQuiz()
            {
                try{    
                    const response = await axios.get(this.baseUrl+'quiz/data');
                    let res = response.data;                    
                    if(res.status == 'success'){
                        this.questions = res.data                        
                        this.showQuestion = res.data[0],
                        this.openNumber = 0;
                        this.lastNumber = res.data.length                        
                    }                                        
                }catch(error){
                    console.log(error.response)
                }
            },
            detailQuestion(index)
            {                                                                                             
                $(".card-multiple-choice").removeClass('bg-primary text-white') 
                $('.card-multiple-choice button').removeClass("bg-warning")     
                this.showQuestion = this.questions[index]  
                this.openNumber = index  
                         
                this.lastNumberHide = true
                if(index === (this.lastNumber-1)){
                    this.lastNumberHide = false
                }                                                             
                
                setTimeout(() => {
                    $('#card-mc-'+this.showQuestion.id_choice_selected).addClass("bg-primary text-white").find('button').addClass('bg-warning')
                }, 50);

            },           
            selectedChoices(idQuestion, idChoice)
            {                
                let selected = {
                    'id_question_selected': idQuestion,
                    'id_choice_selected': idChoice
                }                
                let self = this
                
                this.questions.map(function(item, index){                                                            
                    if(item.id === idQuestion){
                        self.questions[index] = {...item, ...selected}                                            
                        return item
                    }
                })    
                this.saveChoice(selected)    
            },
            async saveChoice(params)
            {       
                let message = $(".message-selected-choice");
                message.html('').removeClass('text-success text-danger')
                try{
                    
                    const response = await axios.post(this.baseUrl+'quiz/save-choice', params, {
                        headers:{
                            'Content-type':'multipart/form-data'
                        }
                    })
                    let res = response.data;  
                    let textColor = 'text-success'  
                    let icon = '<i class="fas fa-check me-1"></i>'                
                    if(res.status=='error'){
                        textColor = 'text-danger'
                        icon = '<i class="fas fa-warning me-1"></i>'                
                    }
                    message.addClass(textColor)

                    this.messageSelectedChoice = icon+res.message
                    setTimeout(() => {
                        this.messageSelectedChoice = ''
                    }, 2000);
                }catch(error){
                    console.log(error.response)
                }
            },
            confirmFinishQuiz(){
                let message = $('#message-modal');
                message.html('')

                let answeredAll=true
                let countAnswerNotSelected = 0;
                this.questions.map((item, index)=>{
                    if(item.id_question_selected==''){                            
                        answeredAll=false
                        countAnswerNotSelected = countAnswerNotSelected+1
                    }
                })
                if(answeredAll==false){
                    message.html(`Still ${countAnswerNotSelected} questions are unanswered! Are you sure you want to end this quiz ?`)
                }else{
                    message.html(`Are you sure you want to end this quiz ?`)
                }
                $('#exampleModal').modal('show')                    
            },

            btnPreviousNext(filter){
                if(filter=='prev'){
                    this.openNumber = this.openNumber - 1                
                }else{
                    this.openNumber = this.openNumber + 1                
                }
                this.detailQuestion(this.openNumber)
                $('.box-number').removeClass('bg-info text-light').addClass('bg-light text-info')
                $('#box-number-'+this.openNumber).removeClass('bg-light').addClass('bg-info text-light'); 
                $('#box-number-'+this.openNumber+'.bg-success').removeClass('bg-light bg-info text-info')
            },            
        },
        mounted(){
            this.getDataQuiz();        
            let self = this
            $(document).on('click','.card-multiple-choice', function(){
                $(".card-multiple-choice").removeClass('bg-primary text-white').find('button').removeClass("bg-warning")                
                $(this).addClass("bg-primary").removeClass("bg-light").find('button').addClass('bg-warning')                
                let id = $(this).prop('id')                            
                $('#box-number-'+self.openNumber).removeClass('bg-info bg-light border-info box-number').addClass('bg-success border-light text-light')
            })
            $(document).on('click','.box-number',function(){
                $('.box-number').removeClass('bg-info text-light').addClass('bg-light text-info')
                $(this).removeClass('bg-light').addClass('bg-info text-light');                                        
            })
        }
    }).mount('#quiz')
</script>

<?= $this->endSection(); ?>