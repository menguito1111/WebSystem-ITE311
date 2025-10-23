<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\CourseModel;

class Admin extends Controller
{
    public function dashboard()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $role = strtolower((string) $session->get('role'));
        if ($role !== 'admin' && $role !== 'teacher') {
            // Prevent access for non-admins and non-teachers
            $session->setFlashdata('error', 'Unauthorized access to admin area.');
            return redirect()->to('dashboard');
        }

        // Example admin data: totals
        $userModel = new UserModel();
        $totalUsers = $userModel->countAllResults();
        $totalAdmins = $userModel->where('role', 'admin')->countAllResults();
        $totalTeachers = $userModel->where('role', 'teacher')->countAllResults();
        $totalStudents = $userModel->where('role', 'student')->countAllResults();

        // Total courses (if courses table exists)
        $db = \Config\Database::connect();
        $totalCourses = 0;
        try {
            $totalCourses = $db->table('courses')->countAllResults();
        } catch (\Throwable $e) {
            $totalCourses = 0;
        }

        // Recent activity: latest users as a simple placeholder
        $recentUsers = $userModel->orderBy('created_at', 'DESC')->limit(5)->find();

        // Get courses for dashboard display
        $courseModel = new CourseModel();
        $courses = $courseModel->orderBy('created_at', 'DESC')->limit(6)->find();

        $data = [
            'title' => 'Admin Dashboard',
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalTeachers' => $totalTeachers,
            'totalStudents' => $totalStudents,
            'totalCourses' => $totalCourses,
            'recentUsers' => $recentUsers,
            'courses' => $courses,
        ];

        return view('admin/dashboard', $data);
    }

    public function courses()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $role = strtolower((string) $session->get('role'));
        if ($role !== 'admin' && $role !== 'teacher') {
            $session->setFlashdata('error', 'Unauthorized access to admin area.');
            return redirect()->to('dashboard');
        }

        $courseModel = new CourseModel();
        $courses = $courseModel->findAll();

        $data = [
            'title' => 'Course Management',
            'courses' => $courses
        ];

        return view('admin/courses', $data);
    }
}


