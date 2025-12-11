<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddScheduleDayToCourses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('courses', [
            'schedule_day' => [
                'type'       => 'ENUM',
                'constraint' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'null'       => true,
                'after'      => 'schedule_date',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('courses', ['schedule_day']);
    }
}

