<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
        'email',
        'password',
        'role',
        'year_level',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = false; // timestamps handled by DB defaults in migration

    // Enable soft deletes so calling delete() will set `deleted_at` instead of removing record
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at';
}
