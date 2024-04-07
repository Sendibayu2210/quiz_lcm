<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>
<div id="main-content" class="p-4">

    <div class="container" id="question-list">
        <div class="h5">Manage Questions</div>

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
                        <button class="badge bg-danger border-0 text-white"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <ul>
                    <li class="multiple-choice" v-for="data in item.multiple_choice" v-html="data.choice_text" :class="(data.is_correct=='true') ? 'fw-bold text-primary' : ''"></li>
                </ul>
            </div>

            <div class="text-center text-danger" v-if="messageNotFound">Data not found</div>

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
                baseUrl: $('#base-url').val(),
                questionsList:{},
                search:'',
                messageNotFound:false,
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
            }
        },
        mounted(){
            this.getQuestions();
        }
    }).mount('#question-list')
</script>
<?= $this->endSection(); ?>
