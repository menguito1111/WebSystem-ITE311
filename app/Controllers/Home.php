<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // This loads app/Views/template.php
        return view('template');
    }
}
