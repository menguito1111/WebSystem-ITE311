<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEnrollmentStatus extends Migration
{
    public function up()
    {
        // Add status column to enrollments table
        $fields = [
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
                'after'      => 'enrollment_date',
            ],
        ];

        $this->forge->addColumn('enrollments', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('enrollments', 'status');
    }
}

