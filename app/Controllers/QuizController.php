<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class QuizController extends BaseController
{
    public function index()
    {
        //
    }

    public function quiz()
    {
        $data = [
            'title' => 'Quiz',
        ];
        return view('quiz/quiz', $data);
    }
}
