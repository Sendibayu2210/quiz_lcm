<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About',
        ];
        return view('about/about', $data);
    }
}
