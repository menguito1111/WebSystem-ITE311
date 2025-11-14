<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'course_id',
        'enrollment_date'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'course_id' => 'required|integer',
        'enrollment_date' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be an integer'
        ],
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be an integer'
        ],
        'enrollment_date' => [
            'valid_date' => 'Enrollment date must be a valid date'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Enroll a user in a course
     * 
     * @param array $data Enrollment data
     * @return int|false Enrollment ID on success, false on failure
     */
    public function enrollUser($data)
    {
        // Set enrollment date if not provided
        if (!isset($data['enrollment_date'])) {
            $data['enrollment_date'] = date('Y-m-d H:i:s');
        }

        // Insert the enrollment record
        $result = $this->insert($data);
        
        if ($result) {
            return $this->insertID();
        }
        
        return false;
    }

    /**
     * Get all courses a user is enrolled in
     * 
     * @param int $user_id User ID
     * @return array Array of enrolled courses
     */
    public function getUserEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.course_name, courses.description, courses.course_code')
                    ->join('courses', 'courses.course_id = enrollments.course_id', 'left')
                    ->where('enrollments.user_id', $user_id)
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Check if a user is already enrolled in a specific course
     * 
     * @param int $user_id User ID
     * @param int $course_id Course ID
     * @return bool True if enrolled, false if not
     */
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        $enrollment = $this->where('user_id', $user_id)
                          ->where('course_id', $course_id)
                          ->first();
        
        return $enrollment !== null;
    }

    /**
     * Get enrollment count for a specific course
     * 
     * @param int $course_id Course ID
     * @return int Number of enrollments
     */
    public function getCourseEnrollmentCount($course_id)
    {
        return $this->where('course_id', $course_id)->countAllResults();
    }

    /**
     * Get all enrollments for a specific course
     * 
     * @param int $course_id Course ID
     * @return array Array of enrollments
     */
    public function getCourseEnrollments($course_id)
    {
        return $this->select('enrollments.*, users.name, users.email')
                    ->join('users', 'users.id = enrollments.user_id', 'left')
                    ->where('enrollments.course_id', $course_id)
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Remove a user's enrollment from a course
     * 
     * @param int $user_id User ID
     * @param int $course_id Course ID
     * @return bool True on success, false on failure
     */
    public function unenrollUser($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                   ->where('course_id', $course_id)
                   ->delete();
    }
}
