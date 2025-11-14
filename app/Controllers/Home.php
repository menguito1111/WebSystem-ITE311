<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index', $this->data); // Homepage
    }

    public function about()
    {
        return view('about', $this->data); // About page
    }

    public function contact() // Contact page
    {
        return view('contact', $this->data);
    }

    public function dashboard()
    {
        $session = session();
        if (! $session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        return view('dashboard');
    }
}
