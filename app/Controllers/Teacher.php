<?php

namespace App\Controllers;

class Teacher extends BaseController
{
    /**
     * Teacher Dashboard
     * Redirects to unified dashboard with teacher-specific functionality
     */
    public function dashboard()
    {
        // Redirect to unified dashboard - it will automatically show teacher content
        return redirect()->to('/dashboard');
    }

    public function classes()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('teacher/classes', array_merge($this->data, [
            'title' => 'My Classes',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }

    public function materials()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('teacher/materials', array_merge($this->data, [
            'title' => 'Materials',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }

    public function grades()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('teacher/grades', array_merge($this->data, [
            'title' => 'Grade Students',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }

    public function createCourse()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('teacher/create_course', array_merge($this->data, [
            'title' => 'Create Course',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }

    public function storeCourse()
    {
        // Role-based access control is handled by the RoleAuth filter

        // Validate input
        $rules = [
            'course_name' => 'required|min_length[3]|max_length[150]',
            'course_code' => 'required|min_length[3]|max_length[50]|is_unique[courses.course_code]',
            'description' => 'permit_empty',
            'units' => 'permit_empty|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $courseModel = new \App\Models\CourseModel();

        $data = [
            'course_name' => $this->request->getPost('course_name'),
            'course_code' => $this->request->getPost('course_code'),
            'description' => $this->request->getPost('description'),
            'units' => $this->request->getPost('units') ?: 3,
            'teacher_id' => session()->get('userId') // Assign current teacher
        ];

        if ($courseModel->insert($data)) {
            return redirect()->to('/dashboard')->with('success', 'Course created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create course. Please try again.');
        }
    }

    public function getCourses()
    {
        // Role-based access control is handled by the RoleAuth filter
        $courseModel = new \App\Models\CourseModel();
        $materialModel = new \App\Models\MaterialModel();
        $enrollmentModel = new \App\Models\EnrollmentModel();

        // Get only courses taught by the current teacher
        $teacherId = session()->get('userId');
        $courses = $courseModel->getCoursesByTeacher($teacherId);

        // Get materials and enrollment count for each course
        foreach ($courses as &$course) {
            $course['materials'] = $materialModel->getMaterialsByCourse($course['course_id']);
            $course['enrollment_count'] = $enrollmentModel->getCourseEnrollmentCount($course['course_id']);
        }

        return view('teacher/courses_list', array_merge($this->data, [
            'title' => 'My Courses',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'courses' => $courses
        ]));
    }

    public function manageCourse($courseId)
    {
        // Role-based access control is handled by the RoleAuth filter
        $courseModel = new \App\Models\CourseModel();
        $materialModel = new \App\Models\MaterialModel();
        $enrollmentModel = new \App\Models\EnrollmentModel();

        // Get course details
        $course = $courseModel->getCourseById($courseId);
        if (!$course) {
            return redirect()->to('/dashboard')->with('error', 'Course not found');
        }

        // Check if the current teacher owns this course
        $teacherId = session()->get('userId');
        if ($course['teacher_id'] != $teacherId) {
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to manage this course');
        }

        // Get materials for this course
        $materials = $materialModel->getMaterialsByCourse($courseId);

        // Get enrolled students for this course
        $enrolledStudents = $enrollmentModel->getCourseEnrollments($courseId);

        return view('teacher/manage_course', array_merge($this->data, [
            'title' => 'Manage Course: ' . $course['course_name'],
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'course' => $course,
            'materials' => $materials,
            'enrolledStudents' => $enrolledStudents
        ]));
    }

    /**
     * Return JSON list of enrolled students for a course
     * Used by the teacher/grades view to load students via AJAX
     *
     * @param int $courseId
     * @return \CodeIgniter\HTTP\Response
     */
    public function courseEnrollments($courseId)
    {
        // Ensure numeric id
        $courseId = (int) $courseId;

        $enrollmentModel = new \App\Models\EnrollmentModel();

        $enrollments = $enrollmentModel->getCourseEnrollments($courseId);

        // Map to a simplified structure expected by the frontend
        $result = [];
        foreach ($enrollments as $e) {
            $result[] = [
                'student_id' => $e['user_id'] ?? null,
                'student_name' => $e['name'] ?? ($e['student_name'] ?? ''),
                'student_email' => $e['email'] ?? ($e['student_email'] ?? ''),
                'grade' => $e['grade'] ?? null
            ];
        }

        return $this->response->setJSON($result);
    }
}
