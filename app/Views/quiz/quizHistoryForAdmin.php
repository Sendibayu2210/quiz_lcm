<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>
<?= view('components/sidebar'); ?>

<div id="main-content">
    <div class="container mt-4" id="history-quiz">
        <div class="h5 mb-3">History </div>
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
                        <td>
                            <a :href="'/quiz/score/'+item.user_id" class="badge bg-primary">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                baseUrl: $('#base-url').val(),
                dataUsers:{}
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
                }
        },
        mounted(){
            this.listUsersQuiz();
        }
    }).mount('#history-quiz')
</script>
<?= $this->endSection(); ?>