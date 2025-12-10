<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'school_year' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'after'      => 'units',
            ],
            'semester' => [
                'type'       => 'ENUM',
                'constraint' => ['1st Semester', '2nd Semester', 'Summer'],
                'null'       => true,
                'after'      => 'school_year',
            ],
            'schedule' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'semester',
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'schedule',
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'start_date',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Active', 'Inactive'],
                'default'    => 'Active',
                'after'      => 'end_date',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', [
            'school_year',
            'semester',
            'schedule',
            'start_date',
            'end_date',
            'status',
        ]);
    }
}
