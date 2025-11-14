<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Course extends BaseController
{
    protected $enrollmentModel;
    protected $courseModel;

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
        $this->courseModel = new CourseModel();
    }

    /**
     * Handle course enrollment via AJAX
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function enroll()
    {
        // Check if user is logged in
        if (!session()->get('isAuthenticated')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to enroll in courses.'
            ]);
        }

        // Check if user is a student
        if (session()->get('userRole') !== 'student') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only students can enroll in courses.'
            ]);
        }

        // Get course_id from POST request
        $course_id = $this->request->getPost('course_id');
        
        if (empty($course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course ID is required.'
            ]);
        }

        // Validate course_id is numeric
        if (!is_numeric($course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid course ID.'
            ]);
        }

        $user_id = session()->get('userId');

        // Check if course exists
        $course = $this->courseModel->getCourseById($course_id);
        if (!$course) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course not found.'
            ]);
        }

        // Check if user is already enrolled
        if ($this->enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are already enrolled in this course.'
            ]);
        }

        // Prepare enrollment data
        $enrollmentData = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrollment_date' => date('Y-m-d H:i:s')
        ];

        // Insert enrollment record
        $enrollmentId = $this->enrollmentModel->enrollUser($enrollmentData);

        if ($enrollmentId) {
            // Create notification
            $notificationModel = new \App\Models\NotificationModel();
            $notificationModel->insert([
                'user_id' => $user_id,
                'message' => "You have been enrolled in " . $course['course_name'],
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully enrolled in ' . $course['course_name'] . '!',
                'enrollment_id' => $enrollmentId,
                'course' => [
                    'id' => $course['course_id'],
                    'name' => $course['course_name'],
                    'code' => $course['course_code'],
                    'description' => $course['description']
                ]
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to enroll in course. Please try again.'
            ]);
        }
    }

    /**
     * Get user's enrolled courses
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getEnrolledCourses()
    {
        // Check if user is logged in
        if (!session()->get('isAuthenticated')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to view enrolled courses.'
            ]);
        }

        $user_id = session()->get('userId');
        $enrolledCourses = $this->enrollmentModel->getUserEnrollments($user_id);

        return $this->response->setJSON([
            'success' => true,
            'courses' => $enrolledCourses
        ]);
    }

    /**
     * Get available courses for enrollment
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function getAvailableCourses()
    {
        // Check if user is logged in
        if (!session()->get('isAuthenticated')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to view available courses.'
            ]);
        }

        // Check if user is a student
        if (session()->get('userRole') !== 'student') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only students can view available courses.'
            ]);
        }

        $user_id = session()->get('userId');
        $availableCourses = $this->courseModel->getAvailableCourses($user_id);

        return $this->response->setJSON([
            'success' => true,
            'courses' => $availableCourses
        ]);
    }

    /**
     * Unenroll from a course
     * 
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function unenroll()
    {
        // Check if user is logged in
        if (!session()->get('isAuthenticated')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login to unenroll from courses.'
            ]);
        }

        // Check if user is a student
        if (session()->get('userRole') !== 'student') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Only students can unenroll from courses.'
            ]);
        }

        $course_id = $this->request->getPost('course_id');
        $user_id = session()->get('userId');

        if (empty($course_id) || !is_numeric($course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid course ID.'
            ]);
        }

        // Check if user is enrolled
        if (!$this->enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are not enrolled in this course.'
            ]);
        }

        // Get course details before unenrolling
        $course = $this->courseModel->getCourseById($course_id);

        // Remove enrollment
        if ($this->enrollmentModel->unenrollUser($user_id, $course_id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully unenrolled from ' . $course['course_name'] . '.',
                'course_id' => $course_id
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to unenroll from course. Please try again.'
            ]);
        }
    }
}
