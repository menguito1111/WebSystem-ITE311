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
        $assignmentSubmissionModel = new \App\Models\AssignmentSubmissionModel();

        $userId = session()->get('userId');
        $assignmentsWithStatus = $assignmentSubmissionModel->getAssignmentsWithSubmissionStatus($userId);

        return view('student/assignments', array_merge($this->data, [
            'title' => 'My Assignments',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'assignments' => $assignmentsWithStatus
        ]));
    }

    public function submitAssignment($assignmentId)
    {
        // Load form helper for set_value() function
        helper('form');

        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($assignmentId);

        if (!$assignment) {
            return redirect()->to('/student/assignments')->with('error', 'Assignment not found');
        }

        // Check if student is enrolled in the course
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $isEnrolled = $enrollmentModel->where('user_id', session()->get('userId'))
                                      ->where('course_id', $assignment['course_id'])
                                      ->first();

        if (!$isEnrolled) {
            return redirect()->to('/student/assignments')->with('error', 'Access denied');
        }

        // Check if already submitted
        $submissionModel = new \App\Models\AssignmentSubmissionModel();
        $existingSubmission = $submissionModel->getSubmissionByUserAndAssignment($assignmentId, session()->get('userId'));

        if ($existingSubmission) {
            // If already submitted, redirect to submission page instead of creating new
            return redirect()->to('/student/view-submission/' . $assignmentId)->with('info', 'You have already submitted this assignment');
        }

        // Check due date
        $currentDate = date('Y-m-d H:i:s');
        if ($assignment['due_date'] && $currentDate > $assignment['due_date']) {
            return redirect()->to('/student/assignments')->with('error', 'Assignment submission deadline has passed');
        }

        return view('student/submit_assignment', array_merge($this->data, [
            'title' => 'Submit Assignment: ' . $assignment['title'],
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'assignment' => $assignment
        ]));
    }

    public function storeSubmission()
    {
        $assignmentId = $this->request->getPost('assignment_id');

        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($assignmentId);

        if (!$assignment) {
            return redirect()->back()->with('error', 'Assignment not found');
        }

        // Check enrollment
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $isEnrolled = $enrollmentModel->where('user_id', session()->get('userId'))
                                      ->where('course_id', $assignment['course_id'])
                                      ->first();

        if (!$isEnrolled) {
            return redirect()->back()->with('error', 'Access denied');
        }

        // Check due date
        $currentDate = date('Y-m-d H:i:s');
        if ($assignment['due_date'] && $currentDate > $assignment['due_date']) {
            return redirect()->back()->with('error', 'Assignment submission deadline has passed');
        }

        // Check if already submitted
        $submissionModel = new \App\Models\AssignmentSubmissionModel();
        $existingSubmission = $submissionModel->getSubmissionByUserAndAssignment($assignmentId, session()->get('userId'));

        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted this assignment');
        }

        $file = $this->request->getPost('submission_file');
        $text = $this->request->getPost('submission_text');

        // Validate that at least one is provided
        if (empty($text) && empty($_FILES['submission_file']['name'])) {
            return redirect()->back()->withInput()->with('error', 'Please provide either a file upload or text submission');
        }

        $rules = [];
        $filePath = null;

        // Add file validation if file is uploaded
        if (!empty($_FILES['submission_file']['name'])) {
            $rules['submission_file'] = 'uploaded[submission_file]|max_size[submission_file,5120]|mime_in[submission_file,pdf,doc,docx,txt,png,jpg,jpeg,gif]|ext_in[submission_file,pdf,doc,docx,txt,png,jpg,jpeg,gif]';
        }

        if (!empty($rules) && !$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle file upload
        if (!empty($_FILES['submission_file']['name'])) {
            $fileUpload = $this->request->getFile('submission_file');
            if ($fileUpload->isValid()) {
                $newName = $fileUpload->getRandomName();
                $fileUpload->move(WRITEPATH . 'uploads/submissions', $newName);
                $filePath = 'uploads/submissions/' . $newName;
            }
        }

        $data = [
            'assignment_id' => $assignmentId,
            'user_id' => session()->get('userId'),
            'file_path' => $filePath,
            'text' => $text ?: null,
            'submitted_at' => $currentDate
        ];

        if ($submissionModel->insert($data)) {
            return redirect()->to('/student/assignments')->with('success', 'Assignment submitted successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to submit assignment');
        }
    }

    public function viewSubmission($assignmentId)
    {
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignment = $assignmentModel->find($assignmentId);

        if (!$assignment) {
            return redirect()->to('/student/assignments')->with('error', 'Assignment not found');
        }

        // Check enrollment
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $isEnrolled = $enrollmentModel->where('user_id', session()->get('userId'))
                                      ->where('course_id', $assignment['course_id'])
                                      ->first();

        if (!$isEnrolled) {
            return redirect()->to('/student/assignments')->with('error', 'Access denied');
        }

        $submissionModel = new \App\Models\AssignmentSubmissionModel();
        $submission = $submissionModel->getSubmissionByUserAndAssignment($assignmentId, session()->get('userId'));

        if (!$submission) {
            return redirect()->to('/student/submit-assignment/' . $assignmentId);
        }

        return view('student/view_submission', array_merge($this->data, [
            'title' => 'My Submission: ' . $assignment['title'],
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'assignment' => $assignment,
            'submission' => $submission
        ]));
    }
}
