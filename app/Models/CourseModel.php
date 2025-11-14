<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'course_name',
        'description',
        'course_code',
        'units',
        'teacher_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'course_name' => 'required|min_length[3]|max_length[150]',
        'description' => 'permit_empty',
        'course_code' => 'required|min_length[3]|max_length[50]|is_unique[courses.course_code]',
        'units' => 'permit_empty|integer|greater_than[0]'
    ];

    protected $validationMessages = [
        'course_name' => [
            'required' => 'Course name is required',
            'min_length' => 'Course name must be at least 3 characters long',
            'max_length' => 'Course name cannot exceed 150 characters'
        ],
        'course_code' => [
            'required' => 'Course code is required',
            'min_length' => 'Course code must be at least 3 characters long',
            'max_length' => 'Course code cannot exceed 50 characters',
            'is_unique' => 'Course code must be unique'
        ],
        'units' => [
            'integer' => 'Units must be an integer',
            'greater_than' => 'Units must be greater than 0'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get all courses
     * 
     * @return array Array of courses
     */
    public function getAllCourses()
    {
        return $this->orderBy('course_name', 'ASC')->findAll();
    }

    /**
     * Get courses not enrolled by a specific user
     * 
     * @param int $user_id User ID
     * @return array Array of available courses
     */
    public function getAvailableCourses($user_id)
    {
        $enrollmentModel = new EnrollmentModel();
        
        // Get all courses
        $allCourses = $this->getAllCourses();
        
        // Get enrolled course IDs for the user
        $enrolledCourses = $enrollmentModel->getUserEnrollments($user_id);
        $enrolledCourseIds = array_column($enrolledCourses, 'course_id');
        
        // Filter out enrolled courses
        $availableCourses = [];
        foreach ($allCourses as $course) {
            if (!in_array($course['course_id'], $enrolledCourseIds)) {
                $availableCourses[] = $course;
            }
        }
        
        return $availableCourses;
    }

    /**
     * Get course details by ID
     *
     * @param int $course_id Course ID
     * @return array|null Course data or null if not found
     */
    public function getCourseById($course_id)
    {
        return $this->find($course_id);
    }

    /**
     * Get courses by teacher ID
     *
     * @param int $teacher_id Teacher ID
     * @return array Array of courses taught by the teacher
     */
    public function getCoursesByTeacher($teacher_id)
    {
        return $this->where('teacher_id', $teacher_id)
                    ->orderBy('course_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get course enrollments for a specific teacher
     *
     * @param int $teacher_id Teacher ID
     * @return array Array of enrollments in teacher's courses
     */
    public function getTeacherCourseEnrollments($teacher_id)
    {
        return $this->select('enrollments.*, courses.course_name, users.name as student_name, users.email as student_email')
                    ->join('enrollments', 'enrollments.course_id = courses.course_id', 'left')
                    ->join('users', 'users.id = enrollments.user_id', 'left')
                    ->where('courses.teacher_id', $teacher_id)
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Get courses by course code
     * 
     * @param string $course_code Course code
     * @return array|null Course data or null if not found
     */
    public function getCourseByCode($course_code)
    {
        return $this->where('course_code', $course_code)->first();
    }
}
