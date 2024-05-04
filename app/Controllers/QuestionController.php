<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\QuestionsModel;
use App\Models\MultipleChoiceModel;
use App\Models\AnsweredUsersModel;
use App\Models\PeriodeModel;
use App\Models\UsersModel;
use App\Models\UserQuizzesModel;

class QuestionController extends BaseController
{
    public function __construct()
    {
        $this->questionsmodel = new QuestionsModel();
        $this->multiplechoicemodel = new MultipleChoiceModel();
        $this->answeredusersmodel = new AnsweredUsersModel();
        $this->periodemodel = new PeriodeModel();
        $this->usersmodel = new UsersModel();    
        $this->userquizzesmodel = new UserQuizzesModel();
    }

    public function questionsList($idPeriode)
    {                        
        $dataUsers = $this->listUser($idPeriode);   
        $periode = $this->periodemodel->where('id', $idPeriode)->first();
        $allPeriode = $this->periodemodel->where('id !=', $idPeriode)->orderBy('id', 'desc')->findAll();        

        $data = [
            'title' => 'List Questions',
            'id_periode' => $idPeriode,
            'users' => $dataUsers,
            'periode' => $periode,
            'allPeriode' => $allPeriode,
        ];
        return view('questions/questionList', $data);
    }


    private function listUser($idPeriode)
    {
        $users = $this->usersmodel->orderBy('created_at','desc')->where('role','user')->findAll();             
        if($users){
            foreach($users as &$user){
                $checkUserQuizzes = $this->userquizzesmodel->where("user_id", $user['id'])->where('id_periode', $idPeriode)->first();
                if($checkUserQuizzes){
                    $user['user_quiz'] = true;
                    $user['timing'] = $checkUserQuizzes['time_limit_minutes'];
                }else{            
                    $user['user_quiz'] = false;
                    $user['timing'] = 60;
                }
            }        
        }
        return $users;
    }

    public function addQuestions()
    {        
        $data = [
            'title' => 'Add Questions',
            'page' => 'add',
            'id' => '',
            'id_periode' => $this->request->getVar('id_periode'),
        ];
        return view('questions/questionAddEdit', $data);
    }

    public function editQuestions($id)
    {
        $data = [
            'title' => 'Edit Questions',
            'page' => 'edit',
            'id' => $id,
            'id_periode' => '',
        ];
        return view('questions/questionAddEdit', $data);
    }

    public function saveQuestions()
    {
        // === Logic ===
        // 1. validasi questionText dan multiple-choice
        // 2. tentukan id yang sama antara question text dengan multiple choice

       $questionText = $this->request->getPost('questionText');
       $multipleChoice = $this->request->getPost('multipleChoice');
       $page = $this->request->getPost('page');
       $idQuestion = $this->request->getPost('idQuestion');
       $idPeriode = $this->request->getPost('idPeriode');
    
       $status = 'error';
       if($questionText!=''){
           if(is_array($multipleChoice)){            

                $generateId = $this->generateRandomString();
                $dataSaveQuestion = [
                    'id' => $generateId,
                    'question' => $questionText,
                    'id_periode' => $idPeriode,
                ];

                if($page=='add'){
                    $saveQuestion = $this->questionsmodel->insert($dataSaveQuestion);
                }else{                    
                    unset($dataSaveQuestion['id_periode']);
                    $saveQuestion = $this->questionsmodel->set('question', $questionText)->where('id', $idQuestion)->update();
                }                

                if($saveQuestion){
                    // save multiple choice
                    $saveMultipleChoice = [];
                    $save = true;
                    foreach($multipleChoice as $choice){
                        


                        $dataSave = [
                            'id_question'=> $generateId,
                            'choice_text'=>$choice['value'],
                            'is_correct'=> $choice['correct'],
                        ];

                        if($page=='edit'){
                            if($choice['id_choice']=='-'){
                                $dataSave['id_question'] = $idQuestion;
                                $save = $this->multiplechoicemodel->insert($dataSave);
                            }else{
                                unset($dataSave['id_question']);
                                $save = $this->multiplechoicemodel->set($dataSave)->where('id', $choice['id_choice'])->update();
                            }
                            
                        }else{   // if page add                  
                            $saveMultipleChoice[] = $dataSave;
                        }
                    }

                    // insert bacth
                    if(count($saveMultipleChoice) > 0){
                        $save = $this->multiplechoicemodel->insertBatch($saveMultipleChoice);
                    }

                    if($save){
                        $status = 'success';
                        $message = 'Question successfully saved';
                    }else{
                        $message = 'Failed to save the question';
                    }
                }else{
                    $message = 'Failed to save the question';
                }
           }else{                
                $message = 'Please input multiple choices with the correct format';
           }
       }else{
            $message = 'Please input question';
       }

       return $this->response->setJson([
            'status' => $status,
            'message'=> $message, 
            'multiple' => $multipleChoice,
       ]);
    }

    private function generateRandomString() {
        $length=3;
        $characters = '0123456789';
        $charLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }
        return $randomString;
    }

    public function dataQuestions($id='', $requestFrom='', $search='', $idPeriode='')
    {                
        if($idPeriode==''){
            $idPeriode = $this->request->getVar('id_periode');
        }

        if($requestFrom==''){
            $search = $this->request->getVar('search');    
        }    
        if($search!=''){
            $questions= $this->questionsmodel->select('id, question');
            $searchArray = explode(' ', $search);
            foreach($searchArray as $key => $dt){
                if($key==0){
                    $questions->like('question', $dt);
                    continue;
                }       
                $questions->orLike('question', $dt);
            }            
            $questions = $questions->findAll(); // tidak ada pencarian
        }else{
            $questions= $this->questionsmodel->select('id, question')->where('id_periode', $idPeriode)->findAll(); // tidak ada pencarian
        }

        if($id!=''){
            $questions= $this->questionsmodel->select('id, question')->where('id', $id)->findAll(); // tidak ada pencarian            
        }
        
        foreach($questions as &$quest){
            $multipleChoice = $this->multiplechoicemodel->select('id as id_choice, choice_text, is_correct')->where('id_question', $quest['id'])->findAll();

            if($multipleChoice){
                // jika yang login adalah user hapus is_correct

                $quest['multiple_choice'] = $multipleChoice;
            }else{
                $quest['multiple_choice'] = [];
            }
        }

        if($requestFrom!=''){
            return $questions;
        }

        return $this->response->setJson([
            'status' => 'success',
            'data' => $questions,
            'search' => $search
        ]);        

    }    

    public function deleteMultipleChoice()
    {
        $id = $this->request->getPost('id');

        // session admin

        $delete = $this->multiplechoicemodel->where('id', $id)->delete();
        if($delete){
            $status='success';
            $message='data has been deleted';
        }else{
            $status = 'error';
            $message = 'failed to delete';
        }
        return $this->response->setJson([
            'status' => $status,
            'message' => $message,            
        ]);
    }

    function checkQuestionProgressForDelete()
    {
        // check di table answeredusersmodel apakah sudah ada atau tidak
        $id = $this->request->getPost("id");            

        $checkQuestion = $this->answeredusersmodel->where('id_question', $id)->first();
        if($checkQuestion){
            // notif confirmation
            $status = 'confirmation';
            $message = 'this question has been used by students! <br> are you sure wanna remove this question ? <br><br> if you delete this question it will change student score';

        }else{
            // delete question
            $delete = $this->questionsmodel->where('id', $id)->delete();
            if($delete){
                // delete multiple choice
                $checkProgress = $this->answeredusersmodel->where('id_question', $id)->first();
                if($checkProgress){
                    $this->answeredusersmodel->where('id_question', $id)->delete();
                }

                $this->multiplechoicemodel->where('id_question', $id)->delete();
                $status = 'success';
                $message = 'question has been deleted';

            }else{
                $status = 'error';
                $message = 'question can not delete';
            }
        }

        return $this->response->setJson([
            'status'=>$status,
            'message'=>$message,            
        ]);
    }

    public function deleteQuestion()
    {
        $id = $this->request->getPost("id");   
        // check di answereduser sudah ada atau tidak jika ga ada maka delete
        $checkProgress = $this->answeredusersmodel->where('id_question', $id)->first();
        if($checkProgress){
            $this->answeredusersmodel->where('id_question', $id)->delete();
        }
        $this->questionsmodel->where('id', $id)->delete();
        $this->multiplechoicemodel->where('id_question', $id)->delete();        

        return $this->response->setJson([
            'status'=>'success',
            'message'=>'question has been deleted',            
        ]);  
    }


    // ========= PERIODE ===========
    public function periodePage()
    {
        $periode = $this->periodemodel->orderBy('id', 'desc')->findAll();
        // dd($periode);

        foreach($periode as &$dt){
            $dt['total_questions'] = $this->questionsmodel->where('id_periode', $dt['id'])->countAllResults();
            $dt['total_user_quizzes'] = $this->userquizzesmodel->where('id_periode', $dt['id'])->countAllResults();
        }        
        $data = [
            'title' => 'List Questions',
            'periode' => $periode,
        ];
        return view('questions/periodePage', $data);
    }
    public function savePeriode()
    {
        $id = $this->request->getPost('id');
        $periode = $this->request->getPost('periode');
        $status = $this->request->getPost('status');

        if($status=='' || $status==null){
            $status='nonactive';
        }
        $dataSave = [
            'periode' => htmlspecialchars($periode),
            'status' => htmlspecialchars($status),
        ];                            
        if($id==''){
            $insert = $this->periodemodel->insert($dataSave);            
        }else{
            $update = $this->periodemodel->set($dataSave)->where('id', $id)->update();
        }

        return redirect()->back();
    }

    public function deletePeriode()
    {
        // delete periode
        // delete question
        // delete user answerd
        // delete user quizzes
        $id = $this->request->getPost('id');
        $this->periodemodel->where('id', $id)->delete();
        $this->questionsmodel->where('id_periode', $id)->delete();
        $this->userquizzesmodel->where('id_periode', $id)->delete();
        $this->answeredusersmodel->where('id_periode', $id)->delete();    
        session()->setFlashdata('success', 'period has been deleted');
        return redirect()->back();
    }

    public function exportCopyQuestion()
    {
        $fromPeriode = $this->request->getPost('from-periode');
        $toPeriode = $this->request->getPost('to-periode');
        $questionsFrom = $this->questionsmodel->where('id_periode', $fromPeriode)->findAll();

        if($questionsFrom){
            $getMaxIdQuestions = ($this->questionsmodel->selectMax('id')->get()->getRow()->id) + 1;   
            $getMaxIdMc = ($this->multiplechoicemodel->selectMax('id')->get()->getRow()->id) + 1;   
                             
            $questions = $this->dataQuestions('','quizcontroller','',$fromPeriode);                            
            $dataQuestions = [];
            $dataMc = [];
            foreach($questions as &$dt){

                $idQuestion = $getMaxIdQuestions++;
                $dataQuestions[] = [
                    'id' => $idQuestion,
                    'question' => $dt['question'],
                    'id_periode' => $toPeriode,
                ];
                
                foreach($dt['multiple_choice'] as &$mc){
                    $dataMc[] = [
                        'id_question' => $idQuestion,
                        'choice_text' => $mc['choice_text'],
                        'is_correct' => $mc['is_correct'],
                    ];
                }
            }
            $insertBatchQuestions = $this->questionsmodel->insertBatch($dataQuestions);
            if($insertBatchQuestions){
                $insertBatchMc = $this->multiplechoicemodel->insertBatch($dataMc);   
                if($insertBatchMc){
                    $status = 'success';
                    $message = 'export questions successfully';
                }else{
                    $status = 'error';
                    $message = "multiple choice can't be save";
                }
            }else{
                $status = 'error';
                $message = "questions choice can't be save";
            }            
        }else{
            $status = 'error';
            $message = "questions not found";
        }

        session()->setFlashdata($status, $message);
        return redirect()->back();        
    }
}
