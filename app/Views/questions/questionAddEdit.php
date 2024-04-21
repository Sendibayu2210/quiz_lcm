<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>


<div id="main-content">
    <div class="" id="multiple-choice">
        <?= view('components/navbar'); ?>
        
        <div class="container px-lg-4 mt-5">
            <input type="text" value="<?= $page; ?>" id="page" class="d-none">
            <input type="text" value="<?= $id; ?>" id="id-question" class="d-none">        

            <div class="mt-4">
                <div class="form-group mb-3 position-relative bg-warning-light br-10 border-2 border-primary">
                    <span class="fw-bold bg-primary p-2 px-3 br-10 ms-3 position-absolute" style="margin-top: -15px;">Enter Question</span>
                    <textarea name="" id="" cols="30" rows="5" class="form-control form-control-sm mt-4 bg-transparent border-0" v-model="questionText"></textarea>
                </div>
                                        
                <div class="col-lg-12 mt-4">
                    <div class="text-end mb-3">
                        <button class="badge bg-primary fw-bold p-2 text-light border-0" @click="addMultipleChoice"><i class="fas fa-plus me-1"></i> Add Multiple Choice</button>
                    </div>
                    <form action="" id="form-multiple-choice">
                        <table class="w-100 small" id="table-multiple-choice">
                            <thead class="">
                                <tr class="small">
                                    <th>Input Multiple Choice</th>
                                    <th width="70px" class="text-center">Is Correct</th>
                                    <th width="70px" class="text-center">Delete</th>
                                </tr>                        
                            </thead>
                            <tbody></tbody>
                        </table>                    
                        <div id="message" class="my-2 fw-bold"></div>
                        <div class="text-start">
                            <button type="button" class="btn btn-sm bg-primary px-5 btn-save" @click="saveQuestions">Save</button>
                        </div>
                    </form>                    
                </div>            
            </div>

            <!-- component mulitple choice -->
            <table id="component-mulitple-choice" class="d-none">
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" value="-" name="id-choice[]">
                            <input type="text" class="form-control form-control-sm border-primary mb-2 bg-warning-light" name="multiple-choice-text[]">
                        </td>
                        <td class="d-flex justify-content-center align-items-center">
                            <div class="px-2 br-5 bg-warning-light">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input border-primary" type="radio" name="is-correct[]" role="switch" id="flexSwitchCheckDefault" value="true">
                                </div>
                            </div>
                        </td>
                        <td class="text-center"><button class="ms-2 btn btn-sm bg-warning-light text-danger delete-multiple-choice" data-id="-"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                </tbody>
            </table>                


            <div class="modal fade" id="modal-confirmation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered-">
                    <div class="modal-content ">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                    
                        Do you really want to delete this choice ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="deleteChoice">Delete</button>
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
    const {createApp}=Vue
    createApp({
        data(){
            return{
                baseUrl : $('#base-url').val(),
                questionText:'',
                spinner:`<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>`,
                page:'',   
                idChoice:null,    
                titlePage: '<?= $page; ?>' + ' Question',
            }
        },
        methods:{
            addMultipleChoice(){
                let component = $("#component-mulitple-choice tbody").html();                
                $('#table-multiple-choice tbody').append(component)
            },            
            async saveQuestions(){

                var idChoice = $('#table-multiple-choice input[name="id-choice[]"]').serializeArray();
                var multipleChoice = $('#table-multiple-choice input[name="multiple-choice-text[]"]').serializeArray();

                var indexCorrect = $('#table-multiple-choice input[type="radio"]').map(function(index){
                    return this.checked ? index : null;
                }).get();

                let message = $('#message');
                message.html('').removeClass("text-danger text-success")
                let iconWarning = '<i class="fas fa-warning me-1"></i>'

                let btnSave = $('.btn-save')                                
                
                // === Logic ===
                // cek question apakah != ''
                // cek apakah multiple-choice lebih dari 1
                // cek apakah is Correct != null
                // tambahkan is correct ke dalam multiple choice 

                if(this.questionText==''){
                    message.html(iconWarning+' please input your question').addClass('text-danger')
                    return
                }

                if(multipleChoice.length > 0){

                    // cek pilihan ganda yang kosong, apabali ada yang masih kosong beri informasi.
                    let checkMultipleChoice = true;
                    for(let index=0; index<multipleChoice.length; index++){                        
                        if(multipleChoice[index].value==''){
                            message.html(iconWarning+' Please input the order of multiple choices to '+ (index+1)).addClass('text-danger')
                            checkMultipleChoice = false;
                            return
                            break                            
                        }                                  
                    }                       

                    if(indexCorrect.length>0){

                        let mergedMultipleChoice = multipleChoice.map(function (item, index) {
                            if(item.value==null){
                                message.html(iconWarning+' Please input the order of multiple choices to'+ (index+1)).addClass('text-danger')
                                return
                            }
                            let correct = { 'correct': false };
                            if(index == indexCorrect[0]){
                                correct = {'correct': true};
                            }

                            let dataIdChoice = {'id_choice': idChoice[index].value}

                            let mergeObject = { ...item, ...correct, ...dataIdChoice}; // merge object
                            return mergeObject;
                        });
                        

                        try{
                            btnSave.html(this.spinner);
                                                        
                            let params  = {
                                'questionText': this.questionText,
                                'multipleChoice': mergedMultipleChoice,
                                'page': this.page,
                                'idQuestion': $('#id-question').val(),
                            }                                                        

                            const response = await axios.post(this.baseUrl+'admin/questions/save', params,{
                                headers:{
                                    'Content-type':'multipart/form-data',
                                }
                            })
                            let res = response.data;
                            console.log(res)

                            let colorText = 'text-danger'
                            if(res.status=='success'){
                                colorText = 'text-success'
                                                                
                                if(this.page=='add'){                                    
                                    this.questionText=''
                                    $("#table-multiple-choice tbody").html('');
                                    this.addMultipleChoice();                                
                                }
                            }
                            message.html(res.message).addClass(colorText)
                                                        
                        }catch(error){
                            console.log(error.response)
                        }                        

                    }else{
                        message.html(iconWarning+'Please choice answer correct').addClass('text-danger')
                    }                
                }else{                    
                    message.html(iconWarning + ' please add multiple choice').addClass('text-danger')
                }

                btnSave.html('Save')

            },
            async getQuestion(){
                try{
                    let id = $('#id-question').val()                    
                    const response = await axios.get(this.baseUrl+'admin/questions/data/'+id);
                    let res = response.data;                    
                    if(res.status=='success'){
                        if(res.data.length>0){
                            let data  = res.data[0];                        
                            this.questionText = data.question
                            data.multiple_choice.map(function(item, index){                                
                                $('#table-multiple-choice tbody').append(`
                                    <tr id="mc-${item.id_choice}">
                                        <td>
                                        <input type="hidden" value="${item.id_choice}" name="id-choice[]">
                                            <input type="text" class="form-control form-control-sm border-primary mb-2 bg-warning-light" name="multiple-choice-text[]" value="${item.choice_text}">
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <div class="px-2 br-5 bg-warning-light">
                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input border-primary" type="radio" name="is-correct[]" role="switch" id="flexSwitchCheckDefault" value="true" ${item.is_correct=='true'?'checked':''}>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"><button type="button" class="ms-2 btn btn-sm bg-warning-light text-danger delete-multiple-choice" data-id="${item.id_choice}"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                               
                                `)
                            })

                        }
                    }                    

                }catch(error){
                    console.log(error)
                }
            },

            async deleteChoice(){
                try{
                    let params = {
                        'id': this.idChoice
                    }                    
                    const response = await axios.post(this.baseUrl+'admin/multiple-choice/delete',params,{
                        headers:{
                            'Content-type':'multipart/form-data'
                        }
                    })
                    let res = response.data;
                    console.log(res)
                    if(res.status == 'success'){
                        $('#mc-'+params.id).remove();
                        $('#modal-confirmation').modal('hide')
                    }
                }catch(error){
                    console.log(error.response)
                }
            }
        },
        mounted(){
            this.page = $('#page').val();
            if(this.page=='add'){
                for(let i=0; i<4; i++){
                    this.addMultipleChoice();
                }
            }else{
                // edit
                this.getQuestion();
            }             
            
            let self = this;
            $(document).on('click','.delete-multiple-choice', function(){          
                let id = $(this).data('id');            
                self.idChoice = id
                if(id=='-'){
                    $(this).parent().parent().remove();
                }else{            
                    $('#modal-confirmation').modal('show');
                }        
            })    
            
        }
    }).mount('#multiple-choice')        
</script>
<?= $this->endSection(); ?>