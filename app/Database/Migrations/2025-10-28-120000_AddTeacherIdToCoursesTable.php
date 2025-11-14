<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTeacherIdToCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'teacher_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'units'
            ],
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('teacher_id', 'users', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        // Drop foreign key first
        $this->forge->dropForeignKey('courses', 'courses_teacher_id_foreign');

        // Drop the column
        $this->forge->dropColumn('courses', 'teacher_id');
    }
}
