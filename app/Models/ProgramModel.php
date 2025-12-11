<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table = 'programs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['department_id', 'name', 'created_at', 'updated_at'];
    protected $useTimestamps = false;
}

