<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\QuestionController;

use App\Models\QuestionsModel;
use App\Models\AnsweredUsersModel;
use App\Models\MultipleChoiceModel;

class QuizController extends BaseController
{
    public function __construct()
    {
        $this->questioncontroller = new QuestionController();
        $this->answeredusersmodel = new AnsweredUsersModel();
        $this->questionsmodel = new QuestionsModel();
        $this->multiplechoicemodel = new MultipleChoiceModel();

        $this->idLogin = session()->get('idLogin');
    }

    public function attentionBeforeQuiz()
    {
        $data = [
            'title' => 'Attention',
        ];
        return view('quiz/quizAttention', $data);
    }

    public function quiz()
    {                              
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }

        // check id user di table answerd_users apakah sudah ada atau tidak
        $checkUserQuiz = $this->answeredusersmodel->where('id_user', $this->idLogin)->first();
        if(!$checkUserQuiz){
            // jika belum ada - buatkan soalnya
            $questions = $this->questioncontroller->dataQuestions('','quizcontroller');    
            $randomQuestions = $this->linearCongruentMethod($questions);                
            $saveQuestionRandom=[];
            foreach($randomQuestions as $rq){
    
                $dataMc = [];
                foreach($rq['multiple_choice'] as $mc){
                    $dataMc[] = $mc['id_choice'];
                }
    
                $data = [
                    'id_user' => $this->idLogin,
                    'id_question' => $rq['id'],
                    'id_multiple_choice' => implode(',', $dataMc),
                ];
                $saveQuestionRandom[] = $data;
            }

            $createQuiz = $this->answeredusersmodel->insertBatch($saveQuestionRandom);            

            if(!$createQuiz){
                // return redirect to sorry (failed create quiz for you);
                dd('sorry,  failed create quiz');
            }
        }
        
        $data = [
            'title' => 'Quiz',
        ];
        return view('quiz/quiz', $data);
    }    

    public function dataQuiz()
    {
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }
        $quiz = $this->answeredusersmodel->where('id_user', $this->idLogin)->findAll();

        $userQuiz = [];
        foreach($quiz as $dt){
            // get questions 
            // get multiple choice
            $idMc = explode(',', $dt['id_multiple_choice']);                        
            $question = $this->questionsmodel->where('id', $dt['id_question'])->first();
            $multipleChoice = $this->multiplechoicemodel->select('id as id_choice, choice_text')->whereIn('id', $idMc)->findAll();            
            
            $data = [
                'id' => $question['id'],
                'question' => $question['question'],
                'multiple_choice' => $multipleChoice,
                'id_question_selected' => ($dt['id_answered']!='') ? $dt['id_question'] : '',
                'id_choice_selected' => $dt['id_answered']
            ];

            $userQuiz[] = $data;            
        }                
        return $this->response->setJson([
            'status' => 'success',
            'data' =>$userQuiz,
        ]);
    }

    // Algoritma LCM - pengacakan soal
    public function linearCongruentMethod($questions) 
    {
        $totalQuestions = count($questions);
        $a = 1;               // random
        $c = 7;               // bilangan primer relative < m
        $m = $totalQuestions; // jumlah soal        

        $seed = time(); // Menggunakan waktu saat itu sebagai seed    

        // Acak Urutan Soal        
        for ($i = $totalQuestions - 1; $i > 0; $i--) {    
            $seed = ($a * $seed + $c) % $m;     // rumus Algoritma LCM
            $j = floor($seed % ($i + 1));
            $temp = $questions[$i];             // urutan ke 1 dimasukan ke variabel
            $questions[$i] = $questions[$j];    // soal array 1 diubah menjadi soal index ke-x
            $questions[$j] = $temp;             // soal index ke-x diubah menjadi temp
        }

        return $questions;
    }    

    public function saveChoiceQuiz()
    {
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }

        $request  =  $this->request->getPost();

        $whereCondition = [
            'id_user' => $this->idLogin,
            'id_question' => $request['id_question_selected'],
        ];
        $saveChoice = $this->answeredusersmodel->set('id_answered', $request['id_choice_selected'])->where($whereCondition)->update();
        if($saveChoice){
            $status = 'success';
            $message = 'saved';
        }else{
            $status = 'error';
            $message = 'failed save';
        }

        return $this->response->setJson([
            'status' => $status,
            'message' => $message,            
        ]);
    }
}
