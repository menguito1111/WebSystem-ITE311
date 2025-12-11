<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAcademicFieldsToCourses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'section_cn' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'after'      => 'course_name',
            ],
            'schedule_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'schedule',
            ],
            'schedule_time' => [
                'type' => 'TIME',
                'null' => true,
                'after' => 'schedule_date',
            ],
            'grading_period' => [
                'type'       => 'ENUM',
                'constraint' => ['Per Term', 'Per Semester'],
                'null'       => true,
                'after'      => 'end_date',
            ],
            'grading_weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'null'       => true,
                'after'      => 'grading_period',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', [
            'section_cn',
            'schedule_date',
            'schedule_time',
            'grading_period',
            'grading_weight',
        ]);
    }
}

