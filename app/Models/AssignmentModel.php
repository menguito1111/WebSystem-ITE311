<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table = 'assignments';
    protected $primaryKey = 'assignment_id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'course_id',
        'teacher_id',
        'title',
        'instructions',
        'due_date',
        'attachment'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'course_id' => 'required|integer',
        'teacher_id' => 'required|integer',
        'title' => 'required|max_length[255]',
        'instructions' => 'permit_empty',
        'due_date' => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'attachment' => 'permit_empty|max_length[255]'
    ];

    protected $validationMessages = [
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be an integer'
        ],
        'teacher_id' => [
            'required' => 'Teacher ID is required',
            'integer' => 'Teacher ID must be an integer'
        ],
        'title' => [
            'required' => 'Assignment title is required',
            'max_length' => 'Title cannot exceed 255 characters'
        ],
        'due_date' => [
            'valid_date' => 'Due date must be a valid date format'
        ],
        'attachment' => [
            'max_length' => 'Attachment path cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getAssignmentsByCourse($courseId)
    {
        return $this->where('course_id', $courseId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getAssignmentsByTeacher($teacherId)
    {
        return $this->where('teacher_id', $teacherId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getAssignmentWithSubmissions($assignmentId)
    {
        $assignment = $this->find($assignmentId);
        if (!$assignment) return null;

        // Get submissions
        $submissionModel = new AssignmentSubmissionModel();
        $assignment['submissions'] = $submissionModel->getSubmissionsByAssignment($assignmentId);

        return $assignment;
    }
}
