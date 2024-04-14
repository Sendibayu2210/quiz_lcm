<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsersModel;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class AuthController extends ResourceController
{

    public function __construct()
    {
        $this->validation = \Config\Services::Validation(); 
        $this->usersmodel = new UsersModel();
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
    
        $user = $this->usersmodel->where('email',$email)->orWhere('username', $email)->first();        
        $status = 'success';
        $message = '';    
    
        $data = [
            'email' => $email,
            'password' => $password,
        ];

        $this->validation->setRules([
            'email' => [
                'label' => 'email or username',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your email or username',                    
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your Password'
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
            $message = 'Email or username is not registered yet';
        }    
        
        if($user){
            if(!password_verify($password, $user['password'])){
                $status = 'error';
                $message = 'Incorrect password';
            }
        }

        if($status=='error'){
            $response=[
                'status'=>$status,
                'message'=>$message,
            ];
            return $this->response->setJson($response);
        }


        if($user['foto']!=''){
            $foto = base_url() . 'assets/foto-profile/'. $user['foto'];
        }else{
            $foto = '';
        }

        $setSession=[
            'idLogin' => $user['id'],            
            'isLoggedIn' => true,
            'roleLogin' => $user['role'],           
            'emailLogin' => $user['email'],     
            'nameLogin' => $user['name'],
            'fotoLogin' => $foto, 
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
            'title' => 'Register - GET-HOUSE OF ENGLISH KUNINGAN',
        ];
        return view('auth/register',$data);
    }

    public function processRegisterUser()
    {
        $request['name'] = $this->request->getPost('name');
        $request['email'] = $this->request->getPost('email');
        $request['username'] = $this->request->getPost('username');
        $request['password'] = $this->request->getPost('password');
        $request['address'] = $this->request->getPost('address');
        $request['birthday'] = $this->request->getPost('birthday');
        
        
        $dataValidation = [
            'name' => $request['name'],
            'email' => $request['email'],            
            'username' => $request['username'],            
            'password' => $request['password'],
            'address' => $request['address'],            
            'birthday' => $request['birthday'],                        
        ];

        $validationArray = [
            'name' => [
                'label' => 'name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your full name'
                ],
            ],
            'username' => [
                'label' => 'username',
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Please enter your username',                    
                    'is_unique' => 'Username already registered, please use another username',
                ],
            ],            
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Please enter your email',
                    'valid_email' => 'Please enter a valid email format, for example: emailname@gmail.com',
                    'is_unique' => 'Email already registered, please use another email',
                ],
            ],            
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your password'
                ],
            ],
            'address' => [
                'label' => 'Alamat',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your address'
                ],
            ],
            'birthday' => [
                'label' => 'Tanggal Lahir',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your date of birth'
                ],
            ],           
        ];        

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
            'username' => htmlspecialchars($request['username']),            
            'email' => htmlspecialchars($request['email']),            
            'birthday' => htmlspecialchars($request['birthday']),            
            'address' => htmlspecialchars($request['address']),                                    
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',                     
        ];

        $insert = $this->usersmodel->insert($dataInsert);

        if($insert){                                               
            $response=[
                'status' => 'success',
                'message'=> 'Registered successfully, please sign in',                                        
            ];
        }else{            
            $response=[
                'status' => 'error',
                'message'=> 'Registration failed',
            ];
        }    
        return $this->response->setJson($response);

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

}
