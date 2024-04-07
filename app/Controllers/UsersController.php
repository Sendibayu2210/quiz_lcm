<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UsersModel;
use App\Controllers\UploadDownloadController;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class UsersController extends ResourceController
{
    public function __construct()
    {
        $this->usersmodel = new UsersModel();    
        $this->updown = new UploadDownloadController();
        $this->validation = \Config\Services::validation();                
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

    // public function apiGetProfile()
    // {
    //     $email = $this->request->getVar('email');

    //     $user = $this->usersmodel->select('name,email,address,birthday,nohp,gender,created_at,foto, referral_code, commission, category_commission')->where('email',$email)->first();
    //     if($user){
    //         $user['foto'] = base_url('assets/foto-profile/'). $user['foto'];
    //         $data = $user;
    //         $status='success';
    //         $message='';
    //     }else{
    //         $status='error';
    //         $message='Data tidak ditemukan';
    //         $data='';
    //     }
    //     $response = [
    //         'status' => $status,
    //         'message'=>$message,
    //         'data' => $data,
    //     ];
    //     return $this->response->setJson($response);
    // }

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

        $data = [
            'title' => 'List Users',
            'users' => $users,            
        ];
        return view('users/listUsers',$data);
    }

    public function detailUser($idUser)
    {
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
}
