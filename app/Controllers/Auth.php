<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
public function register()
{
    helper(['form']);
    $session = session();
    $model = new UserModel();
    
    if ($this->request->getMethod() === 'POST') {
        log_message('info', 'Registration POST request received');
        log_message('info', 'POST data: ' . print_r($this->request->getPost(), true));
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'matches[password]',
            'role' => 'required|in_list[student,teacher]'  // *** ADD THIS LINE ***
        ];
        
        if ($this->validate($rules)) {
            log_message('info', 'Validation passed');
            
            try {
                $name = trim($this->request->getPost('name'));
                $email = $this->request->getPost('email');
                $role = $this->request->getPost('role'); // *** ADD THIS LINE ***
                
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $this->request->getPost('password'),
                    'role' => $role  // *** CHANGE THIS FROM 'student' TO $role ***
                ];
                
                log_message('info', 'Attempting to insert user data: ' . print_r($data, true));
                
                $insertResult = $model->insert($data);
                
                if ($insertResult) {
                    log_message('info', 'User inserted successfully with ID: ' . $insertResult);
                    // *** UPDATE SUCCESS MESSAGE TO INCLUDE ROLE ***
                    $session->setFlashdata('register_success', 'Registration successful as ' . ucfirst($role) . '. Please login.');
                    return redirect()->to(base_url('login'));
                } else {
                    $errors = $model->errors();
                    $errorMessage = 'Registration failed. ';
                    
                    log_message('error', 'Model insert failed. Errors: ' . print_r($errors, true));
                    log_message('error', 'Model validation errors: ' . print_r($model->getValidationMessages(), true));
                    
                    if (!empty($errors)) {
                        $errorMessage .= implode(', ', $errors);
                    } else {
                        $errorMessage .= 'Please try again.';
                    }
                    $session->setFlashdata('register_error', $errorMessage);
                }
            } catch (\Exception $e) {
                log_message('error', 'Registration exception: ' . $e->getMessage());
                log_message('error', 'Stack trace: ' . $e->getTraceAsString());
                $session->setFlashdata('register_error', 'Registration failed. Please try again. Error: ' . $e->getMessage());
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            log_message('error', 'Validation failed: ' . print_r($validationErrors, true));
            
            $errorMessage = 'Validation failed: ' . implode(', ', $validationErrors);
            $session->setFlashdata('register_error', $errorMessage);
        }
    }
    
    return view('auth/register', [
        'validation' => $this->validator
    ]);
}
public function registerChoice()
{
    // Show the registration type selection page
    return view('auth/register_choice');
}

public function registerStudent()
{
    return $this->handleRoleRegistration('student');
}

public function registerTeacher()
{
    return $this->handleRoleRegistration('teacher');
}

private function handleRoleRegistration($role)
{
    helper(['form']);
    $session = session();
    $model = new UserModel();
    
    if ($this->request->getMethod() === 'POST') {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'matches[password]'
        ];
        
        if ($this->validate($rules)) {
            try {
                $data = [
                    'name' => trim($this->request->getPost('name')),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'role' => $role  // *** ROLE IS SET BY URL PARAMETER ***
                ];
                
                $insertResult = $model->insert($data);
                
                if ($insertResult) {
                    $session->setFlashdata('register_success', 'Registration successful as ' . ucfirst($role) . '. Please login.');
                    return redirect()->to(base_url('login'));
                } else {
                    $session->setFlashdata('register_error', 'Registration failed. Please try again.');
                }
            } catch (\Exception $e) {
                $session->setFlashdata('register_error', 'Registration failed. Error: ' . $e->getMessage());
            }
        } else {
            $session->setFlashdata('register_error', 'Validation failed: ' . implode(', ', $this->validator->getErrors()));
        }
    }
    
    // Load role-specific registration form
    return view('auth/register_' . $role, [
        'validation' => $this->validator,
        'role' => $role
    ]);
}





    public function login()
    {
        helper(['form']);
        $session = session();
        
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];
            
            if ($this->validate($rules)) {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                
                try {
                    $model = new UserModel();
                    
                    // Find user by email only
                    $user = $model->where('email', $email)->first();
                    
                    if ($user && password_verify($password, $user['password'])) {
                        $userName = $user['name'] ?? $user['email'];
                        
                        // Set session data
                        $sessionData = [
                            'user_id' => $user['id'],
                            'user_name' => $userName,
                            'user_email' => $user['email'],
                            'role' => $user['role'] ?? 'student',
                            'isLoggedIn' => true
                        ];
                        
                        // Prevent session fixation
                        $session->regenerate();
                        $session->set($sessionData);
                        $session->setFlashdata('success', 'Welcome, ' . $userName . '!');

                        // *** STEP 2: ROLE-BASED REDIRECT ***
                        // Redirect users based on their role
                        $userRole = $user['role'] ?? 'student';
                        
                        switch ($userRole) {
                            case 'student':
                                return redirect()->to('/announcements');
                            case 'teacher':
                                return redirect()->to('/dashboard');
                            case 'admin':
                                return redirect()->to('/dashboard');
                            default:
                                return redirect()->to('/announcements');
                        }
                        
                    } else {
                        $session->setFlashdata('login_error', 'Invalid email or password.');
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Login exception: ' . $e->getMessage());
                    $session->setFlashdata('login_error', 'Login failed. Please try again.');
                }
            } else {
                $session->setFlashdata('login_error', 'Please check your input and try again.');
            }
        }
        
        return view('auth/login', [
            'validation' => $this->validator
        ]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('login');
    }

    // *** STEP 3: ENHANCED DASHBOARD METHOD ***
    public function dashboard()
    {
        $session = session();
        
        // Authorization check - ensure user is logged in
        if (!$session->get('isLoggedIn')) {
            $session->setFlashdata('login_error', 'Please login to access the dashboard.');
            return redirect()->to('login');
        }
        
        // Get user role and basic info
        $userRole = $session->get('role');
        $userId = $session->get('user_id');
        
        // Base data for all users
        $data = [
            'user_name' => $session->get('user_name'),
            'user_email' => $session->get('user_email'),
            'user_role' => $userRole,
            'title' => ucfirst($userRole) . ' Dashboard'
        ];
        
        // Fetch role-specific data from database
        $userModel = new UserModel();
        
        switch ($userRole) {
            case 'admin':
                // Admin-specific data
                $data['total_users'] = $userModel->countAllResults();
                $data['total_admins'] = $userModel->where('role', 'admin')->countAllResults();
                $data['total_teachers'] = $userModel->where('role', 'teacher')->countAllResults();
                $data['total_students'] = $userModel->where('role', 'student')->countAllResults();
                
                // Get courses count (with error handling if table doesn't exist)
                $db = \Config\Database::connect();
                try {
                    $data['total_courses'] = $db->table('courses')->countAllResults();
                } catch (\Throwable $e) {
                    $data['total_courses'] = 0;
                }
                
                // Recent users for admin
                $data['recent_users'] = $userModel->orderBy('created_at', 'DESC')->limit(5)->find();
                break;
                
            case 'teacher':
                // Teacher-specific data
                try {
                    $db = \Config\Database::connect();
                    // Since courses table has no teacher_id yet, show all courses
                    $myCourses = $db->table('courses')->orderBy('id', 'ASC')->get()->getResultArray();
                    $data['my_courses'] = $myCourses;

                    // Total students across all courses (simple aggregate)
                    try {
                        $data['total_students_in_courses'] = $db->table('enrollments')->countAllResults();
                    } catch (\Throwable $e) {
                        $data['total_students_in_courses'] = 0;
                    }
                } catch (\Throwable $e) {
                    $data['my_courses'] = [];
                    $data['total_students_in_courses'] = 0;
                }
                break;
                
            case 'student':
                try {
                    $db = \Config\Database::connect();
                    // Enrolled courses
                    $enrolled = $db->table('enrollments e')
                        ->select('c.*')
                        ->join('courses c', 'c.id = e.course_id', 'inner')
                        ->where('e.user_id', $userId)
                        ->orderBy('c.id', 'ASC')
                        ->get()
                        ->getResultArray();

                    // Available courses (not enrolled)
                    $enrolledIds = array_map(function($c){ return $c['id'] ?? 0; }, $enrolled);
                    if (empty($enrolledIds)) {
                        $available = $db->table('courses')->orderBy('id','ASC')->get()->getResultArray();
                    } else {
                        $available = $db->table('courses')->whereNotIn('id', $enrolledIds)->orderBy('id','ASC')->get()->getResultArray();
                    }

                    $data['enrolled_courses'] = $enrolled;
                    $data['available_courses'] = $available;
                    $data['recent_grades'] = [];
                } catch (\Throwable $e) {
                    $data['enrolled_courses'] = [];
                    $data['available_courses'] = [];
                    $data['recent_grades'] = [];
                }
                break;
        }
        
        // *** STEP 4: LOAD UNIFIED DASHBOARD VIEW ***
        return view('auth/dashboard', $data);
    }
}
?>