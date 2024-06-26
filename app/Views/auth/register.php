<?= $this->extend('template/layout'); ?>
<?= $this->section('content'); ?>

<div id="login-register">
    <?= view('components/navbar-out'); ?>
    <div class="d-flex">
        <div class="col-lg-4 col-md-5 col-12 mh-100vh bg-primary">
            <div class="position-relative">
                <img src="/assets/image-components/bg-top-sidebar-login-register.png" alt="" class="w-100">
            </div>
            <div class="px-lg-5 pb-4 p-2" style="margin-top: -130px;"> 
                <div class="h3 fw-bold mt-5 ps-lg-0 ps-4">REGISTER</div>
                <form @submit.prevent="submitRegister" id="form-register" ref="formRegister" action="/register/check" method="post">
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Full Name" id="name" required v-model="name">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Email" id="email" required v-model="email">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-sm" placeholder="Username" id="username" required v-model="username">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-sm" placeholder="Password" id="password" required v-model="password">
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-sm" id="confirm-password" placeholder="Confirm Password"  @keyup="checkConfirmPassword"id="confirmPassword" required v-model="confirmPassword">
                            <div class="invalid-feedback confirm-password">Passwords do not match</div>
                        </div>                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-around">
                                <div class="form-group me-2 w-100">
                                    <select name="" id="" class="form-control form-control-sm" id="day" required v-model="day">
                                        <option value="">Day</option>
                                        <option v-for="i in 31" :value="i">{{i}}</option>
                                    </select>
                                </div>
                                <div class="form-group me-2 w-100">
                                    <select name="" id="" class="form-control form-control-sm" id="month" required v-model="month">
                                        <option value="">Month</option>
                                        <option v-for="(month, index) in months" :value="month.month">{{month.name}}</option>
                                    </select>
                                </div>
                                <div class="form-group w-100">
                                    <select name="" id="" class="form-control form-control-sm" id="year" required v-model="year">
                                        <option value="">Year</option>
                                        <option v-for="year in years" :key="year" :value="year">{{ year }}</option>                                    
                                    </select>
                                </div>                            
                            </div>
                            <input type="text" class="d-none" id="birthday">
                        </div>
                        <div class="forn-group mb-3">
                            <textarea  cols="30" rows="3" class="form-control" placeholder="Address" id="address" required v-model="address"></textarea>                            
                        </div>
                        
                        <div class="mt-4 text-center mb-3">
                            <div class="mb-3">
                                <div class="badge bg-success d-none message">-</div>
                            </div>
                            <button type="submit" class="btn btn-warning px-4 btn-sm w-100 text-primary fw-bold">Sign Up</button>
                        </div>
                        <div><span>Already have an account?</span> <a href="/login" class="text-warning fw-bold">Login</a></div>
                    </div>
                </form>
            </div>
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
                    years: Array.from({ length: 45 }, (_, index) => 2024 - index), // show year from 2024 - 1980
                    months: [
                        {'month': 01, 'name' : 'January'},
                        {'month': 02, 'name' : 'February'},
                        {'month': 03, 'name' : 'March'},
                        {'month': 04, 'name' : 'April'},
                        {'month': 05, 'name' : 'May'},
                        {'month': 06, 'name' : 'June'},
                        {'month': 07, 'name' : 'July'},
                        {'month': 08, 'name' : 'August'},
                        {'month': 09, 'name' : 'September'},
                        {'month': 10, 'name' : 'October'},
                        {'month': 11, 'name' : 'November'},
                        {'month': 12, 'name' : 'December'}
                    ],
                    name:null,
                    day:'',
                    month:'',
                    year:'',
                    birthday:null,
                    address:null,
                    email:null,
                    username:null,
                    password:null,
                    confirmPassword:null,          
                    titlePage:null,                  
                }
            },
            methods: {
                submitRegister(){
                    $("#form-register").submit();
                },
                checkConfirmPassword(){                    
                    $('#confirm-password').removeClass('is-invalid');                                            
                    if(this.password != this.confirmPassword){
                        $('#confirm-password').addClass('is-invalid');                        
                    }
                },
                async submitRegister()
                {
                    try{
                        this.messageSuccess = false;                        
                        let message = $('.message');
                        message.addClass('d-none')
                        $(".invalid-feedback").remove()
                        
                        if(this.year!=null && this.month!=null && this.day!=null){                            
                            this.birthday = this.year + '-' + ((this.month <= 9) ? '0' + this.month : this.month) + '-' + ((this.day <= 9) ? '0' + this.day : this.day);                        
                        }

                        let data = {
                            'name' : this.name,                            
                            'address' : this.address,
                            'email' : this.email,
                            'username' : this.username,
                            'password' : this.password,   
                            'birthday' : this.birthday,                         
                        }
                        const response = await axios.post(this.baseUrl+'register/check',data,{
                            headers:{
                                'Content-type':'multipart/form-data'
                            }
                        })
                        let res = response.data;
                        

                        if(res.status=='success'){
                            // this.$refs.formRegister.reset();
                            this.name = null;
                            this.day = '';
                            this.month = '';
                            this.year = '';
                            this.birthday = null;
                            this.address = null;
                            this.email = null;
                            this.username = null;
                            this.password = null;
                            this.confirmPassword = null;
                            
                            message.html(res.message).removeClass('d-none').removeClass('bg-danger').addClass('bg-success')
                            $("input, textarea, select").removeClass('is-invalid')
                        }else{               
                            if(res.message == 'validation'){
                                res.message = 'Please check your form';                                
                                let validationErrors = res.validation                                
                                let keys = Object.keys(validationErrors)                                                                
                                keys.forEach(function(key) {
                                    let value = validationErrors[key];
                                    $('#' + key).addClass('is-invalid').after(`<div class="invalid-feedback">${value}</div>`)
                                });
                            }
                            let iconWarning = '<i class="fas fa-warning me-1"></i>'
                            message.html(iconWarning+res.message).removeClass('d-none').removeClass('bg-success').addClass('bg-danger')
                        }
                    }catch(error){
                        console.log(error.response)
                    }
                }
            }
        }).mount('#login-register')
    </script>
<?= $this->endSection(); ?>

