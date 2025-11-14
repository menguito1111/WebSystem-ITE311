<?php

namespace App\Controllers;

class Student extends BaseController
{
    /**
     * Student Dashboard
     * Redirects to unified dashboard with student-specific functionality
     */
    public function dashboard()
    {
        // Redirect to unified dashboard - it will automatically show student content
        return redirect()->to('/dashboard');
    }

    public function courses()
    {
        // Role-based access control is handled by the RoleAuth filter
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $materialModel = new \App\Models\MaterialModel();
        $courseModel = new \App\Models\CourseModel();

        $userId = session()->get('userId');
        $enrollments = $enrollmentModel->getUserEnrollments($userId);

        // Get materials for each course
        foreach ($enrollments as &$enrollment) {
            $enrollment['materials'] = $materialModel->getMaterialsByCourse($enrollment['course_id']);
        }

        return view('student/courses', array_merge($this->data, [
            'title' => 'My Courses',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'enrollments' => $enrollments
        ]));
    }
    
    public function grades()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('student/grades', array_merge($this->data, [
            'title' => 'My Grades',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }
    
    public function assignments()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('student/assignments', array_merge($this->data, [
            'title' => 'My Assignments',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }
}
