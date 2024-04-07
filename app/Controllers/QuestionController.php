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
        ];
        return view('questions/questionAdd', $data);
    }

    public function saveQuestions()
    {
        // === Logic ===
        // 1. validasi questionText dan multiple-choice
        // 2. tentukan id yang sama antara question text dengan multiple choice

       $questionText = $this->request->getPost('questionText');
       $multipleChoice = $this->request->getPost('multipleChoice');
    
       $status = 'error';
       if($questionText!=''){
           if(is_array($multipleChoice)){            
                $generateId = $this->generateRandomString();
                $dataSaveQuestion = [
                    'id' => $generateId,
                    'question' => $questionText,
                ];

                $saveQuestion = $this->questionsmodel->insert($dataSaveQuestion);
                if($saveQuestion){
                    // save multiple choice
                    $saveMultipleChoice = [];
                    foreach($multipleChoice as $choice){
                        
                        $dataSave = [
                            'id_question'=> $generateId,
                            'choice_text'=>$choice['value'],
                            'is_correct'=> $choice['correct'],
                        ];
                        $saveMultipleChoice[] = $dataSave;
                    }
                    // insert bacth
                    $save = $this->multiplechoicemodel->insertBatch($saveMultipleChoice);
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


}
