<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentSubmissionModel extends Model
{
    protected $table = 'assignment_submissions';
    protected $primaryKey = 'assignment_submission_id';
    protected $useAutoIncrement = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'assignment_id',
        'user_id',
        'file_path',
        'text',
        'submitted_at',
        'grade',
        'feedback',
        'graded_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'assignment_id' => 'required|integer',
        'user_id' => 'required|integer',
        'file_path' => 'permit_empty|max_length[255]',
        'text' => 'permit_empty',
        'submitted_at' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'grade' => 'permit_empty|decimal',
        'feedback' => 'permit_empty',
        'graded_at' => 'permit_empty|valid_date[Y-m-d H:i:s]'
    ];

    protected $validationMessages = [
        'assignment_id' => [
            'required' => 'Assignment ID is required',
            'integer' => 'Assignment ID must be an integer'
        ],
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be an integer'
        ],
        'file_path' => [
            'max_length' => 'File path cannot exceed 255 characters'
        ],
        'submitted_at' => [
            'valid_date' => 'Submitted at must be a valid date format'
        ],
        'grade' => [
            'decimal' => 'Grade must be a decimal number'
        ],
        'graded_at' => [
            'valid_date' => 'Graded at must be a valid date format'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getSubmissionsByAssignment($assignmentId)
    {
        return $this->select('assignment_submissions.*, users.name as student_name, users.email as student_email')
                    ->join('users', 'users.id = assignment_submissions.user_id', 'left')
                    ->where('assignment_id', $assignmentId)
                    ->orderBy('submitted_at', 'DESC')
                    ->findAll();
    }

    public function getSubmissionByUserAndAssignment($assignmentId, $userId)
    {
        return $this->where('assignment_id', $assignmentId)
                    ->where('user_id', $userId)
                    ->first();
    }

    public function getUserSubmissions($userId)
    {
        return $this->select('assignment_submissions.*, assignments.title, assignments.due_date, courses.course_name')
                    ->join('assignments', 'assignments.assignment_id = assignment_submissions.assignment_id', 'left')
                    ->join('courses', 'courses.course_id = assignments.course_id', 'left')
                    ->where('assignment_submissions.user_id', $userId)
                    ->orderBy('assignment_submissions.submitted_at', 'DESC')
                    ->findAll();
    }

    public function getAssignmentsWithSubmissionStatus($userId)
    {
        // Get all enrolled courses first
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $enrollments = $enrollmentModel->getUserEnrollments($userId);

        $courseIds = array_column($enrollments, 'course_id');

        if (empty($courseIds)) {
            return [];
        }

        // Get assignments for enrolled courses
        $assignmentModel = new \App\Models\AssignmentModel();
        $assignments = $assignmentModel->select('assignments.*, courses.course_name')
                                       ->join('courses', 'courses.course_id = assignments.course_id', 'left')
                                       ->whereIn('assignments.course_id', $courseIds)
                                       ->orderBy('assignments.created_at', 'DESC')
                                       ->findAll();

        // Add submission status
        foreach ($assignments as &$assignment) {
            $submission = $this->where('assignment_id', $assignment['assignment_id'])
                               ->where('user_id', $userId)
                               ->first();

            if ($submission) {
                $assignment['submission_status'] = $submission['grade'] !== null ? 'Graded' : 'Submitted';
                $assignment['submitted_at'] = $submission['submitted_at'];
                $assignment['grade'] = $submission['grade'];
            } else {
                $assignment['submission_status'] = 'Not submitted';
                $assignment['submitted_at'] = null;
                $assignment['grade'] = null;
            }
        }

        return $assignments;
    }
}
