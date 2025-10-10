<?php
namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use App\Models\EnrollmentModel;
use App\Models\CourseModel;

class Course extends Controller
{
    use ResponseTrait;

    public function create()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respond(['status' => 'error', 'message' => 'Not authenticated'], 401);
        }

        $role = strtolower((string) $session->get('role'));
        if ($role !== 'teacher' && $role !== 'admin') {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        if (!$this->request->is('post')) {
            return $this->respond(['status' => 'error', 'message' => 'Invalid method'], 405);
        }

        $title = trim((string) $this->request->getPost('title'));
        $description = (string) $this->request->getPost('description');

        if ($title === '') {
            return $this->respond(['status' => 'error', 'message' => 'Title is required'], 422);
        }

        $courseModel = new CourseModel();

        try {
            $id = $courseModel->insert([
                'title' => $title,
                'description' => $description,
            ], true);

            if ($id) {
                return $this->respond(['status' => 'ok', 'message' => 'Course created', 'course' => [
                    'id' => $id,
                    'title' => $title,
                    'description' => $description,
                ]], 200);
            }
            return $this->respond(['status' => 'error', 'message' => 'Failed to create course'], 500);
        } catch (\Throwable $e) {
            log_message('error', 'Course create failed: ' . $e->getMessage());
            return $this->respond(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function enroll()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->respond(['status' => 'error', 'message' => 'Not authenticated'], 401);
        }

        $userId = (int) $session->get('user_id');
        $courseId = (int) ($this->request->getPost('course_id') ?? 0);

        if ($courseId <= 0) {
            return $this->respond(['status' => 'error', 'message' => 'Invalid course ID'], 400);
        }

        $enrollmentModel = new EnrollmentModel();

        if ($enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->respond(['status' => 'ok', 'message' => 'Already enrolled'], 200);
        }

        $data = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s'),
        ];

        try {
            $inserted = $enrollmentModel->enrollUser($data);
            if ($inserted) {
                return $this->respond(['status' => 'ok', 'message' => 'Enrolled successfully'], 200);
            }
            return $this->respond(['status' => 'error', 'message' => 'Failed to enroll'], 500);
        } catch (\Throwable $e) {
            log_message('error', 'Enrollment failed: ' . $e->getMessage());
            return $this->respond(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
}


