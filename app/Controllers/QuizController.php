<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Controllers\QuestionController;

class QuizController extends BaseController
{
    public function __construct()
    {
        $this->questioncontroller = new QuestionController();
    }

    public function quiz()
    {              
        $data = [
            'title' => 'Quiz',
        ];
        return view('quiz/quiz', $data);
    }


    public function dataQuiz()
    {
        $questions = $this->questioncontroller->dataQuestions('','quizcontroller');    
        $randomQuestions = $this->linearCongruentMethod($questions);        
        return $this->response->setJson([
            'status' => 'success',
            'data' =>$randomQuestions,
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
    
    // === Generate / Random bilangan prima ===
    private function isPrime($number) {
        if ($number <= 1) {
            return false;
        }
        for ($i = 2; $i <= sqrt($number); $i++) {
            if ($number % $i == 0) {
                return false;
            }
        }
        return true;
    }
    
    private function generateRandomPrimeBelow($limit) {
        $primes = [];
        for ($i = 2; $i < $limit; $i++) {
            if ($this->isPrime($i)) {
                $primes[] = $i;
            }
        }
        if (count($primes) == 0) {
            return null; // Tidak ada bilangan prima di bawah batasan
        }
        $randomIndex = array_rand($primes);
        return $primes[$randomIndex];
    }
}
