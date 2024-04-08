<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\QuestionsModel;
use App\Models\MultipleChoiceModel;

class QuestionController extends BaseController
{
    public function __construct()
    {
        $this->questionsmodel = new QuestionsModel();
        $this->multiplechoicemodel = new MultipleChoiceModel();
    }

    public function questionsList()
    {
        $data = [
            'title' => 'List Questions',
        ];
        return view('questions/questionList', $data);
    }

    public function addQuestions()
    {
        $data = [
            'title' => 'Add Questions',
            'page' => 'add',
            'id' => '',
        ];
        return view('questions/questionAddEdit', $data);
    }

    public function editQuestions($id)
    {
        $data = [
            'title' => 'Edit Questions',
            'page' => 'edit',
            'id' => $id
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
    
       $status = 'error';
       if($questionText!=''){
           if(is_array($multipleChoice)){            

                $generateId = $this->generateRandomString();
                $dataSaveQuestion = [
                    'id' => $generateId,
                    'question' => $questionText,
                ];

                if($page=='add'){
                    $saveQuestion = $this->questionsmodel->insert($dataSaveQuestion);
                }else{                    
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

    public function dataQuestions($id='', $requestFrom='', $search='')
    {        
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
            $questions= $this->questionsmodel->select('id, question')->findAll(); // tidak ada pencarian
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

}
