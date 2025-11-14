<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'title',
        'content',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false; // timestamps handled by DB defaults in migration
}
