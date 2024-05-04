<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsersModel;
use App\Models\UserQuizzesModel;
use App\Models\PeriodeModel;
use App\Controllers\UploadDownloadController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class UsersController extends ResourceController
{
    public function __construct()
    {
        $this->usersmodel = new UsersModel();    
        $this->userquizzesmodel = new UserQuizzesModel();
        $this->periodemodel = new PeriodeModel();
        $this->updown = new UploadDownloadController();
        $this->validation = \Config\Services::validation();
        $this->roleLogin = session()->get('roleLogin');
        $this->idLogin = session()->get('idLogin');
    }
    
    public function profileUser()
    {            
        // $point = $this->appliedmodel->countPoint();        
        $point = $this->countPoint();
        $diamond = $this->countDiamond();        
        $dataUser = $this->dataUser();
        $inclusion = $this->financecon->totalAsset();            

        $rating = $this->reviews->totalRating();              
        $data = [ 
            'title' => 'Profile',
            'dataUser' => $dataUser,
            'totalAsset' => $inclusion,
            'cardNumber' => $this->usersmodel->cardNumber(),
            'totalDiamond' => $diamond,
            'totalPoint' => $point,
            'rating'=>$rating,
        ];        
        // return view('digisean/users/profile', $data);  // jobbean platform freelance
        return view('video-watch/profile/profile',$data); // jobbean video watch
    }    

    private function dataUser()
    {        
        $user = $this->usersmodel->where('id', $this->idLogin)->first();
        if($user){
            unset($user['password']);
            unset($user['view_password']);            
        }else{
            $user = [];
        }        
        return $user;
    }

    public function editProfileUser()
    {
        $user = $this->usersmodel->where('id', $this->idLogin)->first();
        $data = [
            'title' => 'Edit Profile',
            'dataUser' => $user,
        ];
        return view('digisean/users/editProfile', $data);
    }


    public function updateDataUser()
    {    
        $request = $this->request->getPost();          
        $dataValidation = [
            'name' => $this->request->getPost('name'),            
            'address' => $this->request->getPost('address'),
            'birthday' => $this->request->getPost('birthday'),            
        ];

        $this->validation->setRules([
            'name' => [
                'label' => 'name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your name'
                ],
            ],          
            'address' => [
                'label' => 'address',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your address'
                ],
            ],
            'birthday' => [
                'label' => 'birthday',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please enter your birthday'
                ],
            ],           
        ]);

        if($this->validation->run($dataValidation)){
            $dataUpdate = [
                'name' => htmlspecialchars($request['name']),                
                'address' => htmlspecialchars($request['address']),
                'birthday' => htmlspecialchars($request['birthday']),                
            ];
            $email = $request['email'];
            $update = $this->usersmodel->set($dataUpdate)->where('email', $email)->update();
            
            if($update){                
                $status='success';
                $message='Profile has been updated';
            }else{
                $status='error';
                $message='Failed to update';
            }
            $errors='';    
                    
        }else{            
            $status='error';
            $errors = $this->validation->getErrors();
            $message='validation';            
        }

        $response=[
            'status'=>$status,
            'message'=>$message,
            'validation'=>$errors,
        ];

        return $this->response->setJson($response);
    }


    // Student Per Periode 
    public function studentPeriode($idPeriode)
    {
        $users = $this->usersmodel->orderBy('created_at','desc')->where('role','user')->findAll();             
        if($users){
            foreach($users as &$user){
                $checkUserQuizzes = $this->userquizzesmodel->where("user_id", $user['id'])->where('id_periode', $idPeriode)->first();
                if($checkUserQuizzes){
                    $user['user_quiz'] = true;
                    $user['timing'] = $checkUserQuizzes['time_limit_minutes'];                                        
                    $user['id_quizzes'] = $checkUserQuizzes['id'];
                }else{            
                    $user['user_quiz'] = false;
                    $user['timing'] = 60;                    
                    $user['id_quizzes'] = '-';
                }
            }        
        }        
        $periode = $this->periodemodel->where('id', $idPeriode)->first();
        $data = [
            'title' => 'List Users',
            'users' => $users,          
            'id_periode'  => $idPeriode,
            'periode' => $periode,
        ];
        return view('users/listUsersPeriode',$data);
    }

   

    // ================ SECTION ADMIN =====================
    public function listUsers()
    {
        $search = $this->request->getVar('search');        
        $users = $this->usersmodel;
            if($search != '') : 
                $users->like('name',$search)                
                ->orLike('email', $search)
                ->orLike('role', $search);
            endif;
        $users= $users->orderBy('created_at','desc')->paginate(100);      
        
        foreach($users as &$user){
            $checkUserQuizzes = $this->userquizzesmodel->where("user_id", $user['id'])->first();
            if($checkUserQuizzes){
                $user['user_quiz'] = true;
                $user['timing'] = $checkUserQuizzes['time_limit_minutes'];
            }else{            
                $user['user_quiz'] = false;
                $user['timing'] = 60;
            }
        }        

        $data = [
            'title' => 'List Users',
            'users' => $users,            
        ];
        return view('users/listUsers',$data);
    }    

    public function detailUser($idUser='')
    {
        if($idUser==''){
            $idUser = $this->idLogin;
        }
        $user = $this->usersmodel->where('id', $idUser)->first();
        if(!$user){
            return view('errors/error_404');
        }          

        $data = [
            'title' => 'Detail User',
            'user' => $user,                        
        ];                
        return view('users/profileUser',$data);
    }

    public function changeFotoProfile()
    {        
        $id = $this->request->getPost('id');        
        $file = $this->request->getFile('file');              

        if($file->getName()!=''){
            $user = $this->usersmodel->where('id',$id)->first();
            $this->idLogin = $user['id'];     

            $validationFile = ['file'=>$file];
            $this->validation->setRules([
                'file' => [
                    'label' => 'Upload File',
                    'rules' => 'uploaded[file]|max_size[file,1024]|mime_in[file,image/jpg,image/jpeg,image/png,image]',
                    'errors' => [
                        'uploaded' => 'Please choice your image',
                        'max_size' => 'Maximal file size 1 MB',
                        'mime_in' => 'File type not supported by this system',
                    ]                    
                ],
            ]);

            if(!$this->validation->run($validationFile)){                  
                return $this->response->setJson([
                    'status' => 'error',
                    'message' => 'validation',
                    'validation' => $this->validation->getErrors(),
                ]);
            }
            
            $fileName = null;
            $filePath = FCPATH . 'assets/foto-profile';
            $uploadFile = $this->updown->uploadFile($file, $filePath);           
            if($uploadFile['status']){
                $fileName = $uploadFile['fileName'];
                $this->usersmodel->set('foto', $fileName)->where('id',$this->idLogin)->update();                                           

                if($user['foto']!=''){
                    $filePath = $filePath.'/'.$user['foto'];
                    $deleteFile = $this->updown->deleteFile($filePath);
                }
                $response = [
                    'status'=>'success',
                    'messgae'=>'Foto profile diperbaharui',
                    'fotoName' => base_url('assets/foto-profile/'.$fileName),
                ];
                if($this->roleLogin=='admin' && $user['role']=='user'){
                    // tidak ada perubahan
                }else{
                    session()->set('fotoLogin', $response['fotoName']);
                }
            }else{
                $response = [
                    'status'=>'error',
                    'messgae'=>'Foto profile tidak dapat diperbaharui',
                    'fotoName' => base_url('assets/foto-profile/'.$fileName),
                ];
            }
        
        }else{
            $response = [
                'status'=>'error',
                'messgae'=>'Tidak ada file dipilih',
            ];  
        }       
        return $this->response->setJson($response);
    }

    public function changePassword()
    {
        $id = $this->request->getPost('id');
        $password = $this->request->getPost('password');
        if($this->roleLogin=='admin'){

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $changePassword = $this->usersmodel->set('password', $passwordHash)->where('id', $id)->update();
            $status = 'success';
            $message = 'password has been changed';
        }else{
            $status = 'error';
            $message = 'access denied';
        }

        return $this->response->setJson([
            'status' => $status,            
            'message' => $message,                
        ]);
    }
}
