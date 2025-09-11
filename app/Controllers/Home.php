<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('template', [
            'content' => view('index')  // loads app/Views/index.php
        ]);
    }

    public function about()
    {
        return view('template', [
            'content' => view('about')  // loads app/Views/about.php
        ]);
    }

    public function contact()
    {
        return view('template', [
            'content' => view('contact')  // loads app/Views/contact.php
        ]);
    }

    public function dashboard()
    {
        $session = session();
        if (! $session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        return view('template', [
            'content' => view('dashboard')  // loads app/Views/dashboard.php
        ]);
    }
}
