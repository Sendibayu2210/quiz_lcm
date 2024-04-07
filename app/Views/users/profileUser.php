<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<?= view('components/sidebar'); ?>

<div id="main-content" class="bg-warning- p-4">

    <div><span class="bg-info text-white h5 px-4 p-2">Profile</span></div>
    <div class="mt-4" id="profile">
        <div class="card border border-2 border-primary mb-5 br-15" style="width: 40rem;">
            <div class="card-body">
                <div class="d-flex ">
                    <div class="me-5">
                        <div class="position-relative border border-3 border-primary" style="width: 100px; height:100px; border-radius:50%;">
                            <img src="<?= base_url('assets/foto-profile/'.$user['foto']); ?>" id="foto-profile" alt="..." style="width: 100%; height:100%; border-radius:50%; object-fit:cover;">
                        </div>
                        <div class="mt-3">
                            <input type="file" class="d-none" id="foto" ref="uploadFoto" @change="changeFoto">
                            <label for="foto" class="badge bg-light text-dark cursor-pointer btn-upload"><i class="fas fa-pen fa-fw me-1"></i>Upload Foto</label>
                        </div>
                    </div>
                    <div class="w-100">
                        <form @submit.prevent="updateProfile">
                            <?= csrf_field(); ?>

                            <input type="hidden" id="id-user" value="<?= $user['id']; ?>">
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1" for="">Name</label>
                                <input type="text" class="form-control form-control-sm" id="name" value="<?= $user['name']; ?>" required>
                            </div>                        
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1" for="">Email</label>
                                <input type="text" class="form-control form-control-sm" id="email" value="<?= $user['email']; ?>" readonly>
                            </div>                        
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1" for="">Username</label>
                                <input type="text" class="form-control form-control-sm" id="username" value="<?= $user['username']; ?>" readonly>
                            </div>                        
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1" for="">Birthday</label>
                                <input type="date" class="form-control form-control-sm" id="birthday" value="<?= $user['birthday']; ?>" required>
                            </div>                        
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1" for="">Address</label>
                                <textarea class="form-control form-control-sm" cols="30" rows="3" id="address" required><?= $user['address']; ?></textarea>
                            </div>  

                            <div class="mt-3 text-end">
                                <div id="message" class="mb-2"></div>
                                <button class="btn bg-primary btn-sm px-5 btn-save">Save</button>
                            </div>

                        </form>

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
                    baseUrl: $('#base-url').val(),
                    idUser: $('#id-user').val(),
                    spinner : `<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>`
                }
            },
            methods:{
                async changeFoto()
                {
                    let btnUpload = $(".btn-upload")
                    let btnUploadHtml = btnUpload.html()
                    btnUpload.html(this.spinner)
                    try{
                        let file = this.$refs.uploadFoto.files[0];                        
                        if(file!=null){                                                               
                            let params = {
                                'file': file,
                                'id': $('#id-user').val(),
                            }                                                        
                            const response = await axios.post(this.baseUrl+'users/profile/change-foto', params, {
                                headers:{
                                    'Content-type':'multipart/form-data'
                                }
                            })
                            let res = response.data;                            
                            if(res.status=='success'){
                                $("#foto-profile").prop('src', res.fotoName)
                            }
                        }                        
                    }catch(error){
                        console.log(error.response)
                    }
                    btnUpload.html(btnUploadHtml)
                },
                async updateProfile(){
                    let message = $('#message');
                    let btnSave = $('.btn-save');
                    btnSave.html(this.spinner)
                    try{
                        let params = {
                            name : $('#name').val(),
                            email : $('#email').val(),
                            birthday : $('#birthday').val(),
                            address : $('#address').val(),
                        }                        
                        const response = await axios.post(this.baseUrl+'users/profile/update', params, {
                            headers:{
                                'Content-type':'multipart/form-data',
                            }
                        })
                        let res = response.data;

                        message.html(res.message)
                        setTimeout(() => {
                            message.html('')
                        }, 3000);                        
                    }catch(error){
                        console.log(error.response)
                    }
                    btnSave.html("Save")
                }
            }
        }).mount('#profile')
    </script>
<?= $this->endSection(); ?>