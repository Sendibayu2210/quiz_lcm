<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class AuthController extends ResourceController
{

    public function __construct()
    {
        $this->validation = \Config\Services::Validation(); 
    }

    public function login()
    {
        $data = [
            'title' => 'Login - GET-HOUSE OF ENGLISH KUNINGAN',
        ];
        return view('auth/login',$data);
    }

    public function checkProcessLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');        
    
        $user = $this->usersmodel->where('email',$email)->first();        
        $status = 'success';
        $message = '';    
    
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $this->validation->setRules([
            'email' => [
                'label' => 'email atau email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Masukan email',
                    'valid_email' => 'Mohon masukan format email yang sesuai',
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan Password'
                ],
            ],
        ]);

        if(!$this->validation->run($data)){
            $response = [
                'status' => 'error',
                'message' => 'validation',
                'validation' => $this->validation->getErrors(),
            ];
            return $this->response->setJson($response);            
        }        

        if(!$user){
            $status = 'error';
            $message = 'Email belum terdaftar';
        }    
        
        if($user){
            if(!password_verify($password, $user['password'])){
                $status = 'error';
                $message = 'Password salah';
            }
        }

        if($status=='error'){
            $response=[
                'status'=>$status,
                'message'=>$message,
            ];
            return $this->response->setJson($response);
        }

        $setSession=[
            'idLogin' => $user['id'],            
            'isLoggedIn' => true,
            'roleLogin' => $user['role'],           
            'emailLogin' => $user['email'],           
            'fotoLogin' => $user['foto'],            
        ];
        session()->set($setSession);

        $session = session()->get('idLogin');
        $response=[
            'status'=>$status,
            'message'=>'Login Success',  
            'redirect' => base_url('dashboard'),
        ];
        
        return $this->response->setJson($response);
    }


    public function register()
    {
        $data = [
            'title' => 'Daftar - Digisean',
        ];
        return view('auth/register',$data);
    }

    public function processRegisterUser()
    {
        $request['name'] = $this->request->getPost('name');
        $request['email'] = $this->request->getPost('email');
        $request['password'] = $this->request->getPost('password');
        
        $dataValidation = [
            'name' => $request['name'],
            'email' => $request['email'],            
            'password' => $request['password'],
            // 'address' => $request['address'],            
            // 'birthday' => $request['birthday'],            
            // 'nohp' => $request['nohp'],            
        ];

        $validationArray = [
            'name' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan nama atau email'
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Masukan email',
                    'valid_email' => 'Masukan format email dengan benar contoh namaakun@gmail.com',
                    'is_unique' => 'Email sudah terdaftar, silahkan gunakan email lain',
                ],
            ],            
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan Password'
                ],
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan Alamat'
                ],
            ],
            'birthday' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan Tanggal Lahir'
                ],
            ],
            'nohp' => [
                'label' => 'No Handphone',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukan No Handphone'
                ],
            ],
        ];

        // hapus data array, tetap dibiarkan takutnya sewaktu waktu ingin diubah proses daftarnya
        unset($validationArray['address']);
        unset($validationArray['birthday']);
        unset($validationArray['nohp']);

        $this->validation->setRules($validationArray);

        if(!$this->validation->run($dataValidation)){
            $errors = $this->validation->getErrors();            
            $response=[
                'status' => 'error',
                'message' => 'validation',
                'validation' => $errors,
            ];
            return $this->response->setJson($response);
        }                    

        // insert data
        $dataInsert = [
            'name' => htmlspecialchars($request['name']),
            'email' => htmlspecialchars($request['email']),            
            // 'birthday' => htmlspecialchars($request['birthday']),            
            // 'address' => htmlspecialchars($request['address']),            
            // 'nohp' => htmlspecialchars($request['nohp']),            
            'view_password' => htmlspecialchars($request['password']),
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',                     
        ];

        $insert = $this->usersmodel->insert($dataInsert);
        if($insert){
            
            // copy foto profile
            // $sourcePath = FCPATH . 'img/fp.png';  // Gantilah dengan path file sumber
            // $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);  // Dapatkan ekstensi file
            // $randomFilename = uniqid() . '_' . time();  // Membuat nama file baru yang unik

            // // Gabungkan nama file baru dengan ekstensi
            // $newName = $randomFilename . '.' . $extension;
            // $destinationPath = FCPATH . 'assets/foto-profile/' . $newName ;            
            // if (copy($sourcePath, $destinationPath)) {
            //     $this->usersmodel->set('foto', $newName)->where('email', $request['email'])->update();
            // }  
            
            
            // register affiliate
            $registerAffiliate = $this->affiliate->registerAffiliate();
            $dataUpdate = [
                'referral_code' => $registerAffiliate['referralCode'],
                'commission' => $registerAffiliate['commission'],
                'category_commission' => $registerAffiliate['categoryCommission'],
            ];
            $update = $this->usersmodel->set($dataUpdate)->where('email', $request['email'])->update();

            $response=[
                'status' => 'success',
                'message'=> 'Pendaftaran selesai, silahkan login',                                        
            ];

        }else{            
            $response=[
                'status' => 'error',
                'message'=> 'Registrasi kamu gagal',
            ];
        }    
        return $this->response->setJson($response);

    }


    public function forgotPassword()
    {  
        $data = [
            'title' => 'Lupa Password',        
        ];        
        return view('digisean/auth/forgot-password',$data);
    }

    public function forgotPasswordCheckEmail()
    {
        $email = $this->request->getPost('email');

        $cekUser = $this->usersmodel->where("email", $email)->first();
        session()->setFlashdata("email", $email);

        if($cekUser){
            $to = $email;
            $subject = 'Konfirmasi Ubah Password'; 
            $token = $this->getRandomString();
            $data = [
                'email' => $email,
                'token' => $token,
                'category' => 'forgot-password',
            ];

            $this->tokenmodel->insert($data);
            
            $data= [
                'name' => $cekUser['name'],
                'email'=>$email,
                'token'=>$token,
            ];
            $message = view('digisean/email/forgotPassword',$data);
            $sendEmail = $this->email->sendEmail($to, $subject, $message);
                      
            if($sendEmail==true){
                // session()->setFlashdata("success", 'Verifikasi sudah dikirim lewat email, silahkan cek');
                $status='success';
                $message='Email verifikasi sudah dikirim, silahkan cek email';
            }else{
                // session()->setFlashdata("warning", 'Verifikasi sudah dikirim lewat email, silahkan cek');
                $status='error';
                $message='Email verifikasi tidak dikirim';
            }
            $response=[
                'status'=>$status,
                'message'=>$message,
            ];
            return $this->response->setJson($response);
            // return redirect()->back();
        }else{            
            $response=[
                'status'=>'error',
                'message'=>'Email tidak terdaftar',
            ];
            return $this->response->setJson($response);
            // return redirect()->back()->withInput()->with('warning', 'Email tidak ditemukan');
        }
    }

    public function changeNewPassword()
    {
        $email = null;
        $token = null;
        if(isset($_GET['email'])){
            $email= $_GET['email'];
        }
        if(isset($_GET['token'])){
            $token = $_GET['token'];
        }        
        $cekToken = $this->tokenmodel->where('email',$email)->where('token', $token)->first();    
        if(!$cekToken){
            return view('errors/error_404');            
        }        
        $data= [
            'title' => 'Ubah Password',
            'email' => $email,
            'token' => $token,
        ];
        return view('auth/formNewPassword', $data);
    }

    public function processChangeNewPassword()
    {
        $email = $this->request->getPost('email');
        $token = $this->request->getPost('token');

        $cekToken = $this->tokenmodel->where('email',$email)->where('token', $token)->first();
        if(!$cekToken){
            // return redirect()->back()->withInput()->with('warning', 'Email atau token tidak ada! klik lagi tombol di email ya');
            return $this->response->setJson([
                'status'=>'error',
                'message'=>'Email atau token tidak ada! klik lagi tombol di email ya',
            ]);
        }

        $user = $this->usersmodel->where('email', $email)->first();
        if(!$user){
            // return redirect()->back()->withInput()->with('warning', 'Email kamu tidak ditemukan');
            return $this->response->setJson([
                'status'=>'error',
                'message'=>'Email tidak ditemukan',
            ]);
        }
        $password = $this->request->getPost('password');
        $dataUpdate = [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'view_password' => htmlspecialchars($password),
        ];
        $update = $this->usersmodel->set($dataUpdate)->where('email', $email)->update();
        if($update){
            // session()->setFlashdata('success', 'Password berhasil diubah');
            return $this->response->setJson([
                'status'=>'success',
                'message'=>'Password berhasil diubah',
            ]);
        }else{
            // session()->setFlashdata('warning', 'Password gagal diubah');
            return $this->response->setJson([
                'status'=>'error',
                'message'=>'Password gagal diubah',
            ]);
        }
        // return redirect('login');
    }

    public function processLogout()
    {
        session()->destroy();
        // return redirect('login');        
        $response = [
            'status' => 'success',
            'message' => 'session telah dibersihkan',
            'session' => session()->get('emailLogin'),
        ];
        return redirect('login');
        return $this->response->setJson($response);
    }

    public function getRandomString($length='')
    {
        if($length==''){
            $length = 10;
        }
        // Daftar karakter yang akan digunakan untuk kombinasi acak
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        // Memilih karakter acak dari daftar karakter sebanyak panjang yang diinginkan
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }


}
