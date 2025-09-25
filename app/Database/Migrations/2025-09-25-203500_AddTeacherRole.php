<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeacherRole extends Migration
{
    public function up()
    {
        // Modify the existing ENUM to include 'teacher'
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM("student","admin","teacher")',
                'default' => 'student',
            ]
        ]);
    }

    public function down()
    {
        // Revert back to original ENUM
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM("student","admin")',
                'default' => 'student',
            ]
        ]);
    }
}
