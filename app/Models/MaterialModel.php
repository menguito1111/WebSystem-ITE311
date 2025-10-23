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
    protected $protectFields = false;
    protected $allowedFields = ['course_id', 'file_name', 'file_path', 'uploaded_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = null;
    protected $updatedField = null; // No updated_at field in materials table
    protected $deletedField = null; // No soft deletes

    // Validation
    protected $validationRules = [
        'course_id' => 'required|integer',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[255]'
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Insert a new material record
     *
     * @param array $data
     * @return int|false
     */
    public function insertMaterial($data)
    {
        // The model will automatically handle created_at timestamp
        return $this->insert($data);
    }

    /**
     * Get all materials for a specific course
     *
     * @param int $course_id
     * @return array
     */
    public function getMaterialsByCourse($course_id)
    {
        return $this->where('course_id', $course_id)
                    ->orderBy('uploaded_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get material by ID
     *
     * @param int $material_id
     * @return array|null
     */
    public function getMaterialById($material_id)
    {
        return $this->find($material_id);
    }

    /**
     * Delete material by ID
     *
     * @param int $material_id
     * @return bool
     */
    public function deleteMaterial($material_id)
    {
        return $this->delete($material_id);
    }
}
