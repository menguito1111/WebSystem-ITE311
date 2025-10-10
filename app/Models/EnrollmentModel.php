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
        'enrollment_date',
    ];

    public function enrollUser(array $data): bool
    {
        return (bool) $this->insert($data, true);
    }

    public function getUserEnrollments(int $userId): array
    {
        $db = \Config\Database::connect();
        try {
            return $db->table('enrollments e')
                ->select('c.*')
                ->join('courses c', 'c.id = e.course_id', 'inner')
                ->where('e.user_id', $userId)
                ->orderBy('c.id', 'ASC')
                ->get()
                ->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function isAlreadyEnrolled(int $userId, int $courseId): bool
    {
        return $this->where(['user_id' => $userId, 'course_id' => $courseId])->countAllResults() > 0;
    }
}


