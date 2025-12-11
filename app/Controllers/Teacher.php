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

    /**
     * Approve a pending enrollment request
     */
    public function approveEnrollment($enrollmentId)
    {
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseModel = new \App\Models\CourseModel();
        $notificationModel = new \App\Models\NotificationModel();

        $enrollment = $enrollmentModel->find($enrollmentId);
        if (!$enrollment) {
            return redirect()->back()->with('error', 'Enrollment request not found.');
        }

        $course = $courseModel->getCourseById($enrollment['course_id']);
        if (!$course || $course['teacher_id'] != session()->get('userId')) {
            return redirect()->back()->with('error', 'You are not authorized to manage this enrollment.');
        }

        if ($enrollment['status'] === 'approved') {
            return redirect()->back()->with('info', 'Enrollment already approved.');
        }

        if ($enrollmentModel->updateStatus($enrollmentId, 'approved')) {
            // Notify student
            $notificationModel->insert([
                'user_id' => $enrollment['user_id'],
                'message' => 'Your enrollment in ' . ($course['course_name'] ?? 'the course') . ' has been approved.',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', 'Enrollment approved.');
        }

        return redirect()->back()->with('error', 'Failed to approve enrollment.');
    }

    /**
     * Reject a pending enrollment request
     */
    public function rejectEnrollment($enrollmentId)
    {
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $courseModel = new \App\Models\CourseModel();
        $notificationModel = new \App\Models\NotificationModel();

        $enrollment = $enrollmentModel->find($enrollmentId);
        if (!$enrollment) {
            return redirect()->back()->with('error', 'Enrollment request not found.');
        }

        $course = $courseModel->getCourseById($enrollment['course_id']);
        if (!$course || $course['teacher_id'] != session()->get('userId')) {
            return redirect()->back()->with('error', 'You are not authorized to manage this enrollment.');
        }

        if ($enrollment['status'] === 'rejected') {
            return redirect()->back()->with('info', 'Enrollment already rejected.');
        }

        if ($enrollmentModel->updateStatus($enrollmentId, 'rejected')) {
            // Notify student
            $notificationModel->insert([
                'user_id' => $enrollment['user_id'],
                'message' => 'Your enrollment in ' . ($course['course_name'] ?? 'the course') . ' has been rejected.',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->back()->with('success', 'Enrollment rejected.');
        }

        return redirect()->back()->with('error', 'Failed to reject enrollment.');
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
     * Update course (teacher-owned only)
     */
    public function updateCourse($courseId)
    {
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->getCourseById($courseId);

        if (!$course || $course['teacher_id'] != session()->get('userId')) {
            return redirect()->to('/dashboard')->with('error', 'You are not allowed to edit this course.');
        }

        $rules = [
            'course_name' => 'required|min_length[3]|max_length[150]',
            'description' => 'permit_empty',
            'school_year' => 'permit_empty|max_length[20]',
            'semester' => 'permit_empty|in_list[1st Semester,2nd Semester,Summer]',
            'schedule' => 'permit_empty|max_length[100]',
            'start_date' => 'permit_empty',
            'end_date' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validation failed: ' . implode(', ', $this->validator->getErrors()));
        }

        $data = [
            'course_name' => $this->request->getPost('course_name'),
            'description' => $this->request->getPost('description'),
            'school_year' => $this->request->getPost('school_year'),
            'semester' => $this->request->getPost('semester'),
            'schedule' => $this->request->getPost('schedule'),
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date' => $this->request->getPost('end_date') ?: null
        ];

        $courseModel->update($courseId, $data);

        return redirect()->to('/teacher/course/' . $courseId . '#settings')->with('success', 'Course updated successfully.');
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
                'year_level' => $e['year_level'] ?? null,
                'grade' => $e['grade'] ?? null
            ];
        }

        return $this->response->setJSON($result);
    }

    // ============ ASSIGNMENT METHODS ============

    public function assignments($courseId = null)
    {
        $assignmentModel = new \App\Models\AssignmentModel();

        if ($courseId) {
            $courseModel = new \App\Models\CourseModel();
            $course = $courseModel->getCourseById($courseId);

            if (!$course || $course['teacher_id'] != session()->get('userId')) {
                return redirect()->to('/dashboard')->with('error', 'Access denied');
            }

            $assignments = $assignmentModel->getAssignmentsByCourse($courseId);
            return view('teacher/course_assignments', array_merge($this->data, [
                'title' => 'Assignments for ' . $course['course_name'],
                'userName' => session()->get('userName'),
                'userEmail' => session()->get('userEmail'),
                'userRole' => session()->get('userRole'),
                'course' => $course,
                'assignments' => $assignments
            ]));
        } else {
            $assignments = $assignmentModel->getAssignmentsByTeacher(session()->get('userId'));
            return view('teacher/assignments', array_merge($this->data, [
                'title' => 'My Assignments',
                'userName' => session()->get('userName'),
                'userEmail' => session()->get('userEmail'),
                'userRole' => session()->get('userRole'),
                'assignments' => $assignments
            ]));
        }
    }

    public function createAssignment($courseId = null)
    {
        // Load form helper for set_value() function
        helper('form');

        $courseModel = new \App\Models\CourseModel();
        $userId = session()->get('userId');

        // Get courses taught by this teacher
        $courses = $courseModel->getCoursesByTeacher($userId);

        // If no courses found with teacher_id, check for courses with NULL teacher_id and assign them
        if (empty($courses)) {
            $allCourses = $courseModel->getAllCourses();
            foreach ($allCourses as $course) {
                // If this course has no teacher assigned, assign it to current teacher
                if ($course['teacher_id'] === null) {
                    $courseModel->update($course['course_id'], ['teacher_id' => $userId]);
                    $course['teacher_id'] = $userId;
                    $courses[] = $course;
                }
            }
        }

        if ($courseId) {
            $course = $courseModel->getCourseById($courseId);

            if (!$course || $course['teacher_id'] != $userId) {
                return redirect()->to('/dashboard')->with('error', 'Access denied');
            }
        }

        return view('teacher/create_assignment', array_merge($this->data, [
            'title' => 'Create Assignment',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'courseId' => $courseId,
            'courses' => $courses
        ]));
    }

    public function storeAssignment()
    {
        $rules = [
            'course_id' => 'required|integer',
            'title' => 'required|max_length[255]',
            'instructions' => 'permit_empty',
            'due_date' => 'permit_empty'
        ];

        // Add attachment validation only if file is uploaded
        if ($this->request->getFile('attachment')->isValid()) {
            $rules['attachment'] = 'uploaded[attachment]|max_size[attachment,2048]|mime_in[attachment,pdf,doc,docx,txt]|ext_in[attachment,pdf,doc,docx,txt]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $assignmentModel = new \App\Models\AssignmentModel();

        // Check if course belongs to teacher
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->getCourseById($this->request->getPost('course_id'));
        if (!$course) {
            return redirect()->back()->withInput()->with('error', 'Course not found');
        }
        if ($course['teacher_id'] != session()->get('userId')) {
            return redirect()->back()->withInput()->with('error', 'You do not have permission to create assignments for this course');
        }

        $attachmentPath = null;
        if ($this->request->getFile('attachment') && $this->request->getFile('attachment')->isValid()) {
            $file = $this->request->getFile('attachment');
            if ($file->hasMoved()) {
                return redirect()->back()->withInput()->with('error', 'File upload failed - file already moved');
            }
            $newName = $file->getRandomName();
            if (!$file->move(WRITEPATH . 'uploads/assignments', $newName)) {
                return redirect()->back()->withInput()->with('error', 'File upload failed - could not move file');
            }
            $attachmentPath = 'uploads/assignments/' . $newName;
        }

        $data = [
            'course_id' => (int) $this->request->getPost('course_id'),
            'teacher_id' => (int) session()->get('userId'),
            'title' => $this->request->getPost('title'),
            'instructions' => $this->request->getPost('instructions'),
            'due_date' => $this->request->getPost('due_date') ?: null,
            'attachment' => $attachmentPath
        ];

        try {
            $assignmentId = $assignmentModel->insert($data);
            if ($assignmentId) {
                return redirect()->to('/teacher/assignments')->with('success', 'Assignment created successfully!');
            } else {
                // Get any database errors
                $errors = $assignmentModel->errors();
                $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Unknown database error';
                return redirect()->back()->withInput()->with('error', 'Failed to create assignment: ' . $errorMsg);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create assignment: ' . $e->getMessage());
        }
    }

    public function viewSubmissions($assignmentId)
    {
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->getAssignmentWithSubmissions($assignmentId);

        if (!$assignment || $assignment['teacher_id'] != session()->get('userId')) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        // Get enrolled students for the course
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $enrolledStudents = $enrollmentModel->getCourseEnrollments($assignment['course_id']);

        // Merge submissions with enrolled students to show all
        $submissionsMap = [];
        foreach ($assignment['submissions'] as $sub) {
            $submissionsMap[$sub['user_id']] = $sub;
        }

        $merged = [];
        foreach ($enrolledStudents as $student) {
            $studentData = [
                'user_id' => $student['user_id'],
                'student_name' => $student['name'] ?? ($student['student_name'] ?? ''),
                'student_email' => $student['email'] ?? ($student['student_email'] ?? ''),
                'submission' => $submissionsMap[$student['user_id']] ?? null,
                'status' => isset($submissionsMap[$student['user_id']]) ? 'Submitted' : 'Not submitted'
            ];
            $merged[] = $studentData;
        }

        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->getCourseById($assignment['course_id']);

        return view('teacher/assignment_submissions', array_merge($this->data, [
            'title' => 'Submissions for ' . $assignment['title'],
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'assignment' => $assignment,
            'course' => $course,
            'submissions' => $merged
        ]));
    }

    public function gradeSubmission()
    {
        $assignmentSubmissionId = $this->request->getPost('assignment_submission_id');
        $grade = $this->request->getPost('grade');
        $feedback = $this->request->getPost('feedback');

        $submissionModel = new \App\Models\AssignmentSubmissionModel();
        $submission = $submissionModel->find($assignmentSubmissionId);

        if (!$submission) {
            return $this->response->setJSON(['success' => false, 'message' => 'Submission not found']);
        }

        // Check if assignment belongs to teacher
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($submission['assignment_id']);
        if (!$assignment || $assignment['teacher_id'] != session()->get('userId')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
        }

        $data = [
            'grade' => $grade,
            'feedback' => $feedback,
            'graded_at' => date('Y-m-d H:i:s')
        ];

        if ($submissionModel->update($assignmentSubmissionId, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Grade submitted successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to submit grade']);
        }
    }

    public function getSubmissionDetails($submissionId)
    {
        $submissionModel = new \App\Models\AssignmentSubmissionModel();
        $submission = $submissionModel->select('assignment_submissions.*, users.name as student_name')
                                      ->join('users', 'users.id = assignment_submissions.user_id', 'left')
                                      ->find($submissionId);

        if (!$submission) {
            return $this->response->setJSON(['success' => false, 'message' => 'Submission not found']);
        }

        // Check if assignment belongs to teacher
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($submission['assignment_id']);
        if (!$assignment || $assignment['teacher_id'] != session()->get('userId')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
        }

        $html = '<div class="submission-content">';
        $html .= '<h6>Submission by: <strong>' . esc($submission['student_name'] ?? 'Unknown') . '</strong></h6>';

        if ($submission['file_path']) {
            $html .= '<p><strong>File:</strong> <a href="' . base_url('uploads/submissions/' . basename($submission['file_path'])) . '" target="_blank" class="btn btn-sm btn-outline-primary">Download File</a></p>';
        }

        if ($submission['text']) {
            $html .= '<div class="mt-3">';
            $html .= '<strong>Text Submission:</strong>';
            $html .= '<div class="border p-3 mt-2 bg-light">' . nl2br(esc($submission['text'])) . '</div>';
            $html .= '</div>';
        }

        if (!$submission['file_path'] && !$submission['text']) {
            $html .= '<p class="text-muted">No content submitted.</p>';
        }

        $html .= '<p class="mt-2"><strong>Submitted on:</strong> ' . date('M j, Y g:i A', strtotime($submission['submitted_at'])) . '</p>';
        $html .= '</div>';

        return $this->response->setJSON([
            'success' => true,
            'html' => $html,
            'grade' => $submission['grade'],
            'feedback' => $submission['feedback']
        ]);
    }
}
