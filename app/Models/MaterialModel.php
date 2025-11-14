<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'course_id',
        'file_name',
        'file_path'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    // Validation
    protected $validationRules = [
        'course_id' => 'required|integer',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[255]'
    ];

    protected $validationMessages = [
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be an integer'
        ],
        'file_name' => [
            'required' => 'File name is required',
            'max_length' => 'File name cannot exceed 255 characters'
        ],
        'file_path' => [
            'required' => 'File path is required',
            'max_length' => 'File path cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Insert a new material record
     *
     * @param array $data Material data
     * @return bool|int Insert ID or false on failure
     */
    public function insertMaterial($data)
    {
        return $this->insert($data);
    }

    /**
     * Get all materials for a specific course
     *
     * @param int $course_id Course ID
     * @return array Array of materials
     */
    public function getMaterialsByCourse($course_id)
    {
        return $this->where('course_id', $course_id)->findAll();
    }

    /**
     * Get material by ID
     *
     * @param int $id Material ID
     * @return array|null Material data or null if not found
     */
    public function getMaterialById($id)
    {
        return $this->find($id);
    }

    /**
     * Delete material by ID
     *
     * @param int $id Material ID
     * @return bool True on success, false on failure
     */
    public function deleteMaterial($id)
    {
        return $this->delete($id);
    }
}
