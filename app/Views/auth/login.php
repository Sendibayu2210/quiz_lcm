<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div id="login-register">

    <div class="row">
        <div class="col-lg-5 mh-100vh bg-primary">

            <form @submit.prevent="checkLogin">
                <div class="p-lg-5 p-2">
                    <div>
                        <div class="h1 fw-bold">LOG<span class="text-warning">IN</span></div>
                        <div><span>Don’t have an account?</span> <a href="/register" class="text-info">Create your account</a></div>
                    </div>
                    <div class="mt-5">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-sm" id="email" placeholder="Username or Email" v-model="email">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-sm" id="password" placeholder="Password" v-model="password">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember Me
                            </label>
                        </div>

                        <div class="mt-5 text-center">
                            <div class="mb-3">
                                <div class="badge bg-success d-none message">-</div>
                            </div>

                            <button class="btn btn-warning px-4 border border-light border-2 text-primary fw-bold">Login</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-lg-7 bg-warning">

            <div class="p-5">
                <div><span class="h1 fw-bold p-2 bg-danger text-white mb-3">WELCOME</span></div>
                <div class="h2 fw-bold my-3 text-primary">BACK</div>
                <div class="text-danger fw-bold small">
                    We're glad to see you return to our community. Please log in <br>
                    to continue to your exam phase with us. <br>
                    Thank you for your loyalty and support!
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
                            }, 1500);
                            
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
                }
            }
        }).mount('#login-register')
    </script>
<?= $this->endSection(); ?>

