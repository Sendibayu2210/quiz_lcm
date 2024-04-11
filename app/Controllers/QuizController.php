<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\QuestionController;

use App\Models\QuestionsModel;
use App\Models\AnsweredUsersModel;
use App\Models\MultipleChoiceModel;
use App\Models\UserQuizzesModel;

class QuizController extends BaseController
{
    public function __construct()
    {
        $this->questioncontroller = new QuestionController();
        $this->answeredusersmodel = new AnsweredUsersModel();
        $this->questionsmodel = new QuestionsModel();
        $this->multiplechoicemodel = new MultipleChoiceModel();
        $this->userquizzesmodel = new UserQuizzesModel();

        $this->idLogin = session()->get('idLogin');
        $this->roleLogin = session()->get('roleLogin');
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

            $saveStartQuiz = $this->userquizzesmodel->insert([
                'user_id' => $this->idLogin,
                'start_time' => date('Y-m-d H:i:s'),
            ]);

        }
        
        $data = [
            'title' => 'Quiz',
        ];
        return view('quiz/quiz', $data);
    }    

    public function dataQuiz($id='')
    {
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }

        if($id==''){
            $id = $this->idLogin;
        }

        $quiz = $this->answeredusersmodel->where('id_user', $id)->findAll();

        if($quiz){
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
        }else{
            $userQuiz = [];
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

    public function finishQuiz()
    {
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }                
        $getData = $this->userquizzesmodel->where('user_id', $this->idLogin)->first();
        if(strtotime($getData['end_time']) < strtotime($getData['start_time'])){
            $time = date('Y-m-d H:i:s');
            $updateCloseQuiz = $this->userquizzesmodel->set('end_time', $time)->where('user_id', $this->idLogin)->update();
        }
        return redirect('quiz/score');
    }


    public function scoreQuiz($id='')
    {
        if($id==''){
            if($this->roleLogin=='user'){
                $id = $this->idLogin;
            }
        }

        // cek dulu apakah user sudah selesai mengerjakan quiz ?
        $checkFinishQuiz = $this->userquizzesmodel->where('user_id', $id)->first();
        if($checkFinishQuiz){
            $start = strtotime($checkFinishQuiz['start_time']);
            $end = strtotime($checkFinishQuiz['end_time']);        
            $answered = $this->answeredusersmodel->where('id_user', $id)->findAll();
            $totalQuestions = count($answered);                

            if($end > $start){     // jika date close quiz > start quiz       
                $totalCorrect = 0;
                foreach($answered as $dt){
                    $idMc = explode(',', $dt['id_multiple_choice']);
                    $multipleChoice = $this->multiplechoicemodel->whereIn('id', $idMc)->where('is_correct', 'true')->first();

                    if($multipleChoice['id'] == $dt['id_answered']){
                        $totalCorrect = $totalCorrect + 1;
                    }                                        
                }

                // ============ Perhitungan Nilai ================
                // Total soal dan jawaban yang benar
                // $totalQuestions = count($answered);                
                // Hitung persentase benar
                $persentaseBenar = ($totalCorrect / $totalQuestions) * 100;
                // Bobot nilai maksimal
                $bobotNilaiMaksimal = 100;
                // Hitung nilai
                $nilai = $persentaseBenar * $bobotNilaiMaksimal / 100;    


                $result = [
                    'totalQuestion' => $totalQuestions,
                    'totalCorrect' => $totalCorrect,
                    'totalWrong' => $totalQuestions - $totalCorrect,
                    'score' => number_format($nilai, 2),
                ];
            }else{                
                $result = [
                    'totalQuestion' => $totalQuestions,
                    'totalCorrect' => '-',
                    'totalWrong' => '-',
                    'score' => '-',
                ];
            }                        
        }else{
            $result = [
                'totalQuestion' => '-',
                'totalCorrect' => '-',
                'totalWrong' => '-',
                'score' => '-',
            ];
        }    


        return $result; 
    }

    public function pageScore($id='')
    {
        $data = [
            'title' => 'Score',
            'data' => $this->scoreQuiz($id),
            'idUser' => $id,
        ];
        
        return view('quiz/quizHistoryScore', $data);
    }


    public function pageHistoryQuizForAdmin()
    {
        $data = [
            'title' => 'History Quiz',            
        ];

        return view('quiz/quizHistoryForAdmin', $data);
    }

    public function dataHistoryQuiz()
    {
        $data = $this->userquizzesmodel
            ->select('user_quizzes.*, users.name, users.email, users.username')
            ->join('users', 'users.id=user_quizzes.user_id')->orderBy('name', 'asc')->findAll();
        
        $data = $this->statusProgressAndScore($data);           
        
        return $this->response->setJson([
            'status'=> 'success',
            'data' => $data,
        ]);
    }
    
    private function statusProgressAndScore($dataArray)
    {
        if(is_array($dataArray)){
            foreach($dataArray as $key => &$dt){
                $startTime = strtotime($dt['start_time']);
                $endTime = strtotime($dt['end_time']);
                
                // status progress
                $dt['status_progress'] = '';
                $dt['score'] = '-';
                $dt['total_question'] = '-';

                if($startTime > 0 && $endTime > $startTime){
                    $dt['status_progress'] = 'finish';
                }else if($startTime > 0 && $endTime < 0){
                    $dt['status_progress'] = 'progress';
                }else if($startTime < 0){
                    $dt['status_progress'] = 'not yet';
                }

                // score
                $dataScore = $this->scoreQuiz($dt['user_id']);
                if($dataScore){
                    $dt['score'] = $dataScore['score'];
                    $dt['total_question'] = $dataScore['totalQuestion'];
                }                            
            }            
        }       
        return $dataArray;
    }
}
