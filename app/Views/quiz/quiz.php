<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<?= view('components/sidebar'); ?>
<div id="main-content" class="pb-0">
    <div id="quiz">
        <div class="row mh-100vh small" >
            <div class="col-lg-9" id="content-quiz">                
                <div class="container mt-4">
                    <div class="mb-4 d-flex justify-content-between">
                        <div class="h4 text-primary fw-bold">Quiz</div>
                        <div id="menu-sidebar">
                            <i class="fas fa-bars" id="icon"></i>
                        </div>
                    </div>

                    <div class="my-4 d-flex justify-content-between">  
                        <div class="px-5 bg-danger text-white h3 fw-bold text-center border border-light border-3 py-1 br-15 card-time d-lg-none d-md-block d-sm-block timing">00 : 00 : 00</div>                        
                        <div class="mt-1 me-2 d-lg-none d-md-block d-sm-block" @click="toggleSidebarBoxNumber">
                            <i class="fa-solid fa-grip fs-3"></i>
                        </div>
                    </div>

                    <div class="card border border-2 border-primary bg-warning-light">
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
                <div class="position-relative">
                    <img src="/assets/image-components/acc-bottom-quiz.png" alt="" class="w-100">
                </div>
            </div>
            <div class="col-lg-3 bg-primary" id="sidebar-box-number">

                <div class="mt-3 me-2 d-lg-none d-md-block d-sm-block" @click="toggleSidebarBoxNumber">
                    <i class="fas fa-times fs-5"></i>
                </div>

                <div class="mt-5">
                    <div class="mx-5 bg-danger h5 fw-bold text-center border border-light border-3 py-1 br-15 card-time timing">00 : 00 : 00</div>
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
                        <button  type="submit" class="btn bg-primary" id="btn-finish">Finish</button>
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
            toggleSidebarBoxNumber(){
                $("#sidebar-box-number").toggleClass('active')
            },
            async dataUser(){
                try{                        
                    const response = await axios.get(this.baseUrl+'quiz/data-user');
                    let res = response.data;                               
                    if(res.status == 'success'){                                                                                        
                        this.timeLimit(res.data.start_time, res.data.time_limit_minutes)
                    }                                        
                }catch(error){
                    console.log(error.response)
                }   
            },
            timeLimit(startTime, timeLimit){                                
                var startTime = Date.parse(startTime); // Timestamp start time
                var limit = timeLimit * (60 * 1000); // 120 menit dalam milidetik
                var endTime = startTime + limit; // Timestamp end time

                var x = setInterval(function() {
                    var now = new Date().getTime(); // Timestamp waktu sekarang
                    var distance = endTime - now; // Selisih antara end time dan waktu sekarang

                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Tampilkan waktu mundur dalam format menit:detik
                    // console.log(hours + " jam " + minutes + " menit " + seconds + " detik");
                    let timing = `${(hours<=9) ? '0'+hours : hours} : ${(minutes<=9) ? '0'+minutes : minutes} : ${(seconds<=9) ? '0'+seconds : seconds}`;                    
                    $('.timing').html(timing).css('font-size', '20px')                    

                    // Jika waktu sudah habis, hentikan interval
                    if (distance < 0) {
                        clearInterval(x);
                        $(".timing").html("00 : 00 : 00")
                        $('#btn-finish').click();
                        console.log("Waktu habis!");
                    }
                }, 1000); // Update setiap 1 detik (1000 milidetik)
            }

        },
        mounted(){
            this.getDataQuiz();  
            this.dataUser();                        

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

            var offsetHeight = document.getElementById('content-quiz').offsetHeight;            
            $("#sidebar-box-number").css({'height':offsetHeight+60,'right':0}).addClass('position-absolute')

            setTimeout(() => {
                $(".acc-bottom").remove();
            }, 500);
        }
    }).mount('#quiz')
</script>

<?= $this->endSection(); ?>