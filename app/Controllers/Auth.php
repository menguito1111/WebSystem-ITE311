<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function attempt()
    {
        $request  = $this->request;
        $email    = trim((string) $request->getPost('email'));
        $password = (string) $request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session = session();
            $session->set([
                'isLoggedIn' => true,
                'userEmail'  => $email,
                'userId'     => $user['id'],
                'userName'   => $user['name'],
                'userRole'   => $user['role'],
            ]);
            return redirect()->to(base_url('dashboard'));


        }

        return redirect()->back()->with('login_error', 'Invalid credentials');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function register()
    {
        return view('register');
    }

    public function store()
    {
        $name            = trim((string) $this->request->getPost('name'));
        $email           = trim((string) $this->request->getPost('email'));
        $password        = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        if ($name === '' || $email === '' || $password === '' || $passwordConfirm === '') {
            return redirect()->back()->withInput()->with('register_error', 'All fields are required.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('register_error', 'Invalid email address.');
        }

        if ($password !== $passwordConfirm) {
            return redirect()->back()->withInput()->with('register_error', 'Passwords do not match.');
        }

        $userModel = new \App\Models\UserModel();

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('register_error', 'Email is already registered.');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $userId = $userModel->insert([
            'name'     => $name,
            'email'    => $email,
            'role'     => 'student',
            'password' => $passwordHash,
        ], true);

        if (! $userId) {
            return redirect()->back()->withInput()->with('register_error', 'Registration failed.');
        }

        return redirect()
            ->to('/login')
            ->with('register_success', 'Account created successfully. Please log in.');
    }
}
