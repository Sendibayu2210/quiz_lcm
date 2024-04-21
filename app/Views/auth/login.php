<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div id="login-register">
    <?= view('components/navbar-out'); ?>
    <div class="d-flex">
        <div class="col-lg-4 col-md-5 col-12 mh-100vh bg-primary">
            <div class="position-relative">
                <img src="/assets/image-components/bg-top-sidebar-login-register.png" alt="" class="w-100">
            </div>

            <form @submit.prevent="checkLogin" style="margin-top: -130px;">
                <div class="px-lg-5 pb-4 p-2">                                    
                    <div class="h1 fw-bold mt-5 pt-4 ps-lg-0 ps-4">Log<span class="text-warning">in</span></div>                        
                    
                    <div class="mt-4 pt-2">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-sm text-dark" id="email" placeholder="Username or Email" v-model="email">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" v-model="password">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="show-password" @click="showPassword">
                            <label class="form-check-label" for="show-password">
                                Show password
                            </label>
                        </div>

                        <div class="mt-5 text-center">
                            <div class="mb-3">
                                <div class="badge bg-success d-none message w-100">-</div>
                            </div>                            
                            <button class="btn btn-warning w-100 text-primary fw-bold btn-sm">LOGIN</button>                            
                        </div>
                        <div class="mt-4"><span>Don’t have an account?</span> <a href="/register" class="text-warning fw-bold">Create your account</a></div>
                    </div>
                </div>
            </form>

        </div>

        <div class="col-lg-8 col-md-7 col-12 bg-warning d-lg-block d-md-block d-sm-none d-none">
            <div class="position-relative">
                <img src="assets/image-components/acc-login-register-top.png" alt="" class="ms-4 position-relative" style="margin-top: -10px;">
            </div>
            <div class="p-5">
                <div><span class="px-3 bg-danger text-white mb-3 br-10" style="font-size: 60px; letter-spacing: 10px; font-weight: 850;">WELCOME</span></div>
                <div class="h2 fw-bold- text-primary" style="font-size:45px; font-weight: 850;">BACK</div>
                <div class="mt-3 text-danger fw-bold">
                    We're glad to see you return to our community. Please log in <br>
                    to continue to your exam phase with us. <br>
                    Thank you for your loyalty and support!
                </div>
                <img src="/assets/image-components/accecories-login-register.png" alt="" class="accecoris-login-register">
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
                    baseUrl: $("#base-url").val(),
                    email:null,
                    password:null,
                }
            },
            methods:{
                async checkLogin(){
                    try{
                        let message = $('.message');
                        message.addClass('d-none')
                        $(".invalid-feedback").remove()
                        $('input').removeClass('is-invalid')

                        let params={
                            'email':this.email,
                            'password':this.password
                        }
                        const response = await axios.post(this.baseUrl+'login/check',params,{
                            headers:{
                                'Content-type':'multipart/form-data',
                            }
                        })
                        let res = response.data
                        console.log(res)

                        if(res.status=='success'){
                            message.html(res.message).removeClass('d-none').removeClass('bg-danger').addClass('bg-success')

                            setTimeout(() => {
                                document.location.href = '/dashboard'
                            }, 300);
                            
                        }else{
                            if(res.message=='validation'){
                                let validationErrors = res.validation                                
                                let keys = Object.keys(validationErrors)                                                                
                                keys.forEach(function(key) {
                                    let value = validationErrors[key];
                                    $('#' + key).addClass('is-invalid').after(`<div class="invalid-feedback">${value}</div>`)
                                });

                                res.message = 'Please check your form';   
                            }

                            let iconWarning = '<i class="fas fa-warning me-1"></i>'
                            message.html(iconWarning+res.message).removeClass('d-none').removeClass('bg-success').addClass('bg-danger')

                        }

                    }catch(error){
                        console.log(error)
                    }
                },
                showPassword(){
                    let inputPassword = $('#password');                    
                    let type = inputPassword.prop('type');
                    if(type=='password'){
                        inputPassword.prop('type', 'text')
                    }else{
                        inputPassword.prop('type', 'password')
                    }
                }
            }
        }).mount('#login-register')
    </script>
<?= $this->endSection(); ?>

