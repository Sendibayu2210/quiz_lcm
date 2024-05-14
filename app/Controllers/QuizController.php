<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\QuestionController;

use App\Models\QuestionsModel;
use App\Models\AnsweredUsersModel;
use App\Models\MultipleChoiceModel;
use App\Models\UserQuizzesModel;
use App\Models\PeriodeModel;
use App\Models\UsersModel;

class QuizController extends BaseController
{
    public function __construct()
    {
        $this->questioncontroller = new QuestionController();
        $this->answeredusersmodel = new AnsweredUsersModel();
        $this->questionsmodel = new QuestionsModel();
        $this->multiplechoicemodel = new MultipleChoiceModel();
        $this->userquizzesmodel = new UserQuizzesModel();
        $this->periodemodel = new PeriodeModel();
        $this->usersmodel = new UsersModel();

        $this->idLogin = session()->get('idLogin');
        $this->roleLogin = session()->get('roleLogin');
    }

    
    public function attentionBeforeQuiz($idQuizzes)
    {                
        $checkData = $this->userquizzesmodel->where('id', $idQuizzes)->find();
        $status = '-';
        if($checkData){            
            $dataProgress = $this->statusProgressAndScore($checkData);
            $status = $dataProgress[0]['status_progress'];            
        }
        $periode = $dataProgress;            

        // check jumlah soal
        $countQuestion = $this->questionsmodel->where('id_periode', $periode[0]['id_periode'])->countAllResults();
        if($countQuestion <= 0){
            $status = 'questions is null';
        }        

        $data = [
            'title' => 'Attention',
            'status' => $status,
            'periode' => $periode,
        ];        
        
        return view('quiz/quizAttention', $data);
    }

    public function historyBeforeQuiz()
    {
        // tampikan data history quiz per periode
        $id = $this->idLogin;

        $checkData = $this->userquizzesmodel
            ->select('periode.periode, user_quizzes.*')
            ->join('periode', 'periode.id=user_quizzes.id_periode')
            ->where('user_id', $id)->orderBy('user_quizzes.created_at', 'desc')->find();        

        $status = '-';

        if($checkData){            
            $dataProgress = $this->statusProgressAndScore($checkData);
            $status = $dataProgress[0]['status_progress'];            
            $periode = $dataProgress;    

        }else{
            $status = 'data not found';
            $periode = 0;
        }

        $data = [
            'title' => 'Attention',
            'status' => $status,
            'periode' => $periode,
        ];        

        return view('quiz/quizHistoryPeriode', $data);
    }

    public function quiz()
    {                              
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }

        $idPeriode = $this->request->getVar('periode');                

        // check id user di table answerd_users apakah sudah ada atau tidak
        $checkUserQuiz = $this->answeredusersmodel->where('id_user', $this->idLogin)->where('id_periode', $idPeriode)->first();
        $quizzes = $this->userquizzesmodel->where('user_id', $this->idLogin)->where('id_periode', $idPeriode)->first();        
        if(!$checkUserQuiz){
            // jika belum ada - buatkan soalnya
            $questions = $this->questioncontroller->dataQuestions('','quizcontroller','',$idPeriode);                
            
            // pengacakan multiple choice (pilihan ganda)
            foreach($questions as &$dt){
                $mc = $dt['multiple_choice'];
                $dt['multiple_choice'] = $this->linearCongruentMethod($mc);
            }            

            $randomQuestions = $this->linearCongruentMethod($questions);
            $periode = $this->periodemodel->where('id', $idPeriode)->first();
            $saveQuestionRandom=[];
            foreach($randomQuestions as $key => $rq){
    
                $dataMc = [];
                foreach($rq['multiple_choice'] as $mc){
                    $dataMc[] = $mc['id_choice'];
                }
    
                $data = [
                    'id_user' => $this->idLogin,
                    'id_question' => $rq['id'],
                    'id_multiple_choice' => implode(',', $dataMc),
                    'id_periode' => $idPeriode,
                ];

                if($key < $periode['show_question']){ // hanya menampilkan soal maksimal dari jumlah yang ditentukan
                    $saveQuestionRandom[] = $data;
                }
            }

            $createQuiz = $this->answeredusersmodel->insertBatch($saveQuestionRandom);            
            if(!$createQuiz){
                // return redirect to sorry (failed create quiz for you);
                dd('sorry,  failed create quiz');
            }            
            $this->checkUserQuizzes($idPeriode);
        }else{
            $check = $this->checkUserQuizzes($idPeriode);                        
            if($check != true){                 
                return redirect('quiz/history');
            }
            if($check==='quiz finish'){
                return redirect('quiz/history');

            }
        }
        
        $data = [
            'title' => 'Quiz',
            'quizzes' => $quizzes,
        ];        
        return view('quiz/quiz', $data);
    }    

    private function checkUserQuizzes($idPeriode)
    {
        // == untuk mengecek apakah user sudah pernah melakukan quiz dan menandai waktu mulai
        $checkQuizzes = $this->userquizzesmodel->where('user_id', $this->idLogin)->where('id_periode', $idPeriode)->first();
        if(!$checkQuizzes){
            $saveStartQuiz = $this->userquizzesmodel->insert([
                'user_id' => $this->idLogin,
                'start_time' => date('Y-m-d H:i:s'),
            ]);
        }else{
            $startTime =  strtotime($checkQuizzes['start_time']);
            $endTime =  strtotime($checkQuizzes['end_time']);
            if($startTime < 0){
                $timeNow = date('Y-m-d H:i:s');
                $this->userquizzesmodel->set('start_time', $timeNow)->where('id', $checkQuizzes['id'])->update();                
            }
            // jika end time > start time
            if($endTime > $startTime){                                   
                return 'quiz finish';
            }
        }
        return true;
    }

    public function dataQuiz($id='')
    {
        if($this->idLogin == ''){
            // return redirect to 403
            dd('please login');
        }                
        $dataQuizzes = $this->userquizzesmodel->where('id',$id)->first(); 
        $quiz = $this->answeredusersmodel->where('id_user', $dataQuizzes['user_id'])->where('id_periode', $dataQuizzes['id_periode'])->findAll();
        
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
        $idQuizzes = $this->request->getPost('id-quizzes');
        $getData = $this->userquizzesmodel->where('id', $idQuizzes)->first();        
        if(strtotime($getData['end_time']) < strtotime($getData['start_time'])){
            $time = date('Y-m-d H:i:s');
            $updateCloseQuiz = $this->userquizzesmodel->set('end_time', $time)->where('id', $idQuizzes)->update();
        }
        return redirect('quiz/history');
    }

    public function scoreQuiz($id='', $idPeriode='')
    {
        if($id==''){
            if($this->roleLogin=='user'){
                $id = $this->idLogin;
            }
        }        
        // cek dulu apakah user sudah selesai mengerjakan quiz ?
        $checkFinishQuiz = $this->userquizzesmodel->where('user_id', $id)->where('id_periode', $idPeriode)->first();        
        if($checkFinishQuiz){
            $start = strtotime($checkFinishQuiz['start_time']);
            $end = strtotime($checkFinishQuiz['end_time']);    

            $answered = $this->answeredusersmodel->where('id_user', $id)->where('id_periode', $idPeriode)->findAll();
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

    public function pageScore($id)
    {    
        // validasi apakah sudah finish atau belum         
        $dataQuizzes = $this->userquizzesmodel->where('id', $id)->find();         
        $status = false;        
        if($dataQuizzes){
            // check status progress
            $progress = $this->statusProgressAndScore($dataQuizzes);
            $status = $progress['0']['status_progress'];
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if($this->roleLogin=='admin'){
            $status = 'finish'; // agar admin bisa mengecek hasil score siswa walaupun siswa belum menyelesaikan quiz
        }        
        
        $data = [
            'title' => 'Score',
            'data' => $this->scoreQuiz($dataQuizzes[0]['user_id'], $dataQuizzes[0]['id_periode']),
            'idQuizzes' => $id,
            'status' => $status,
            'idPeriode' => $dataQuizzes[0]['id_periode'],
        ];                
        
        return view('quiz/quizHistoryScore', $data);
    }

    public function pageHistoryQuizForAdmin()
    {
        $data = [
            'title' => 'History Quiz',            
        ];            
        $this->updateFinishQuiz();    
        return view('quiz/quizHistoryForAdmin', $data);
    }

    private function updateFinishQuiz()
    {
        // === LOGIC ===
        // 1. check apakah quiz sudah dimulai (start quiz) > 0
        // 2. check apakah waktu end quiz < time()
        // 3. ya => update end time,
        $dataQuizzes = $this->dataHistoryQuiz(true);    
        if(is_array($dataQuizzes)){
            $updateFinishQuiz = [];
            foreach($dataQuizzes as $dt){
                $startTime = strtotime($dt['start_time']);
                if($startTime > 0){
                    $endTime = strtotime($dt['start_time']) + (60 * $dt['time_limit_minutes']);                                
                    if($endTime < time()){
                        $dt['end_time'] = date('Y-m-d H:i:s', $endTime);
                        $updateFinishQuiz[] = $dt;
                    }            
                }
            }
            if(sizeof($updateFinishQuiz) > 0){
                $this->userquizzesmodel->updateBatch($updateFinishQuiz, 'id');
            }            
        }    
    }

    public function dataHistoryQuiz($requestFromServer=false)
    {
        $data = $this->userquizzesmodel
            ->select('user_quizzes.*, users.name, users.email, users.username, periode.periode')
            ->join('periode', 'periode.id=user_quizzes.id_periode')
            ->join('users', 'users.id=user_quizzes.user_id')->orderBy('name', 'asc')->findAll();
        
        $data = $this->statusProgressAndScore($data);           
        
        if($requestFromServer==true){
            return $data;
        }

        return $this->response->setJson([
            'status'=> 'success',
            'data' => $data,
        ]);
    }

    public function dataUserQuiz($id)
    {                   
        $data = $this->userquizzesmodel        
            ->select('user_quizzes.*, users.name, users.email, users.username')
            ->join('users', 'users.id=user_quizzes.user_id')
            ->where('user_quizzes.id', $id)            
            ->orderBy('name', 'asc')
            ->first();                        

        return $this->response->setJson([
            'status'=> 'success',
            'data' => $data,
            'id' => $id,
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
                $dataScore = $this->scoreQuiz($dt['user_id'], $dt['id_periode']);
                if($dataScore){
                    $dt['score'] = $dataScore['score'];
                    $dt['total_question'] = $dataScore['totalQuestion'];
                }                            
            }            
        }       
        return $dataArray;
    }

    // create or delete user quiz
    public function manageUserQuiz()
    {
        $id = $this->request->getPost('id');
        $idPeriode = $this->request->getPost('idPeriode');

        $data = $this->userquizzesmodel->where('user_id', $id)->where('id_periode', $idPeriode)->first();
        $status = 'error';
        $message = '';

        if($data){
            // (logic) = sudah ada, cek di table quiz sudah ada atau tidak, jika tidak ada maka hapus aja. jika ada maka beri peringatan.
            $checkProgressQuiz = $this->answeredusersmodel->where('id_user', $id)->where('id_periode', $idPeriode)->first();

            if($checkProgressQuiz){
                $status = 'confirmation';
                $message = 'user already progress';
            }else{
                $delete = $this->userquizzesmodel->where('user_id', $id)->where('id_periode', $idPeriode)->delete();
                if($delete){
                    $status = 'success';
                    $message = 'data successfully delete';
                }else{
                    $message = 'data failed delete';
                }
            }            
        }else{
            // (tambahan) = jika tidak ada data users di table users maka lakukan validasi
            // tidak ada maka di insert
            $periode = $this->periodemodel->where('id', $idPeriode)->first();
            $save = $this->userquizzesmodel->insert([
                'user_id' => $id,
                'id_periode' => $idPeriode,
                'time_limit_minutes' => $periode['quiz_timer'],
            ]);
            if($save){
                $status = 'success';
                $message = 'success add user to quiz';
            }else{
                $message = 'failed add user to quiz';
            }
        }

        return $this->response->setJson([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function createLevel()
    {
        $id = $this->request->getPost('id');
        $level = $this->request->getPost('level');

        $saveLevel = $this->userquizzesmodel->set('level', $level)->where('id', $id)->update();

        return $this->response->setJson([
            'status' => 'success',            
            'message' => 'level has been saved',
        ]);
    }
    
    public function deleteProgressQuizUser()
    {
        // === LOGIC ===
        // delete from user_quizzes
        // delete from answerd_users
        $idUser = $this->request->getPost('id');
        $idPeriode = $this->request->getPost('idPeriode');
        $this->userquizzesmodel->where('user_id', $idUser)->where('id_periode', $idPeriode)->delete();
        $this->answeredusersmodel->where('id_user', $idUser)->where('id_periode', $idPeriode)->delete();

        return $this->response->setJson([
            'status' => 'success',
            'message' => 'Progress user has been reset',
        ]);
    }

    public function setTimingQuiz()
    {
        // check di user quizzes apakah ada datanya atau tidak jika tidak ada maka harus aktifkan dulu, jika tidak ada maka update aja.
        $id = $this->request->getVar('id');
        $time = $this->request->getVar('time');

        $checkData = $this->periodemodel->where("id", $id)->first();        
        if($checkData){
            $update = $this->periodemodel->set('quiz_timer', $time)->where('id', $id)->update();
            $status = 'success';
            $message = 'successfully updated timer';
        }else{
            $status = 'error';
            $message = 'please activate the quiz for this user';
        }
        // session()->setFlashdata($status, $message);
        // return redirect()->back();

        return $this->response->setJson([
            'status' => $status,
            'message' => $message,                                    
        ]);        
    }

    public function setQuizForAllUser($idPeriode)
    {
        // === Logic ===
        // 1. get user_quizzes by periode
        // 2. get all student
        // 3. match id student === id user in quizzes
        // 4. if match then continue, else push to array
        // 5. insert batch to user quizzes

        $periode = $this->periodemodel->where('id', $idPeriode)->first();
        if($periode){
            $userQuizzes = $this->userquizzesmodel->where('id_periode', $idPeriode)->findAll();
            $users = $this->usersmodel->where('role','user')->findAll();

            if(count($userQuizzes) == count($users)){

                // jika ada di answer quizzes maka redirect to confirm page
                // jika tidak ada maka hapus aja
                $checkAnswerd = $this->answeredusersmodel->where('id_periode', $idPeriode)->first();
                if($checkAnswerd){
                    return redirect()->to('admin/students-periode/confirm-delete-quizzes/'. $idPeriode);
                }else{
                    // delete users answerd
                    $this->answeredusersmodel->where('id_periode', $idPeriode)->delete();
                    // delete user quizzes
                    $this->userquizzesmodel->where('id_periode', $idPeriode)->delete();
                    
                    session()->setFlashdata('message', 'data student has been off quiz');
                    return redirect()->back();
                }
            }            

            $saveQuizzes = [];            
            // ambil dan match ke users
            if($users){
                $dataQuizzes=[];

                if($userQuizzes){
                    foreach($userQuizzes as $dt){
                        $dataQuizzes[] = $dt['user_id'];
                    }
                }
                
                foreach($users as $dt){
                    if(in_array($dt['id'],$dataQuizzes)){
                        continue;
                    }

                    $data = [
                        'user_id'=> $dt['id'],
                        'id_periode'=>$periode['id'],
                        'time_limit_minutes'=>$periode['quiz_timer'],
                    ];
                    $saveQuizzes[] = $data;
                }

                if(count($saveQuizzes)>0){
                    $insertBatch = $this->userquizzesmodel->insertBatch($saveQuizzes);
                    if($insertBatch){                    
                        session()->setFlashdata('message', 'student has been set for quiz');
                    }else{
                        session()->setFlashdata('message', 'data failed save');
                    }
                }else{
                    session()->setFlashdata('message', 'no data added');
                }

            }else{
                session()->setFlashdata('message', 'data student not found');
            }
           
        }else{
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return redirect()->back();        
    }

    public function confirmDeleteAllQuizzes($idPeriode)
    {
        $periode = $this->periodemodel->where('id', $idPeriode)->first();
        if(!$periode){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $data = [
            'title' => 'Confirmation turn off quiz',
            'idPeriode' => $idPeriode,
            'periode' => $periode,
        ];
        return view('users/confirmDeleteAllUserQuizPeriod', $data);
    }

    public function deleteAllQuizzesPeriod()
    {
        $idPeriode = $this->request->getPost('id-periode');
        $category = $this->request->getPost('category');

        if($category=='all'){
            $this->answeredusersmodel->where('id_periode', $idPeriode)->delete();            
            $this->userquizzesmodel->where('id_periode', $idPeriode)->delete();                 
        }else{
            $answerdQuizzes = $this->answeredusersmodel->where('id_periode', $idPeriode)->groupBy('id_user')->findAll();
            $quizzes = $this->userquizzesmodel->where('id_periode', $idPeriode)->findAll();

            if($answerdQuizzes){
                $idAnswerd = [];
                foreach($answerdQuizzes as $dt){
                    $idAnswerd[] = $dt['id_user'];
                }                
                foreach($quizzes as $dt){
                    if(in_array($dt['user_id'], $idAnswerd)){ // jika id user ada di answerd = continue
                        continue;
                    }
                    $this->userquizzesmodel->where('id', $dt['id'])->delete();
                }                            
            }
        }
        session()->setFlashdata('message', 'data student has been off quiz');
        return redirect()->to('admin/students-periode/'.$idPeriode);           
    }
}
