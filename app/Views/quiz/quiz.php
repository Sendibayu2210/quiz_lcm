<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div class="row mh-100vh" id="quiz">
    <div class="col-lg-9 bg-warning-">
        <div class="container mt-5">
            <div class="mb-4">
                <span class="bg-info h1 fw-bold text-white px-4">Quiz</span>
            </div>

            <div class="card border border-3 border-primary">
                <div class="card-body">
                    <div class="text-primary" v-html="showQuestion.question"></div>
                    <div class="mt-4 "> 
                        <div class="bg-light border cursor-pointer p-2 mb-2 d-flex card-multiple-choice" v-for="(item, index) in showQuestion.multiple_choice">
                            <button class="btn bg-warning text-danger fw-bold btn-sm me-3">A</button>
                            <span v-html="item.choice_text"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button class="btn bg-primary text-white me-2 px-3 border border-light border-3 fw-bold">Previous</button>
                <button class="btn bg-primary text-white px-4 border border-light border-3 fw-bold">Next</button>
            </div>
        </div>
    </div>
    <div class="col-lg-3 bg-primary">
        <div class="mt-5">
            <div class="mx-5 bg-danger h1 fw-bold text-center border border-light border-3 py-1">00:00</div>
        </div>
        <div class="mt-3 mb-3 text-center">
        <div class="badge bg-light border border-info border-2 text-info p-2 m-1 cursor-pointer box-number" v-for="(item,index) in questions" :id="'box-number-'+index" :class="(index==0) ? 'bg-info text-white' : '' " @click="detailQuestion(index)">
                {{ (index<=8) ? '0'+(index+1) : (index+1) }}
            </div>
        </div>

        <div class="my-3 text-center">
            <button class="btn bg-warning px-5 fw-bold text-primary border border-light border-3">Finish</button>
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
                        console.log(this.questions)
                        console.log(this.showQuestion)
                    }

                }catch(error){
                    console.log(error.response)
                }
            },
            detailQuestion(index)
            {
                $(".box-number").removeClass('bg-info bg-light text-white').addClass("bg-light text-info")
                $("#box-number-"+index).removeClass('bg-light').addClass('bg-info text-white')
                this.showQuestion = this.questions[index]  
                console.log(this.showQuestion)  
            }
        },
        mounted(){
            this.getDataQuiz();
        }
    }).mount('#quiz')
</script>

<?= $this->endSection(); ?>