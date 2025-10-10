<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterEnrollmentsAddEnrollmentDate extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        if (!$db->tableExists('enrollments')) {
            return;
        }

        $fields = $db->getFieldNames('enrollments');

        if (!in_array('enrollment_date', $fields, true)) {
            $this->forge->addColumn('enrollments', [
                'enrollment_date' => [
                    'type' => 'DATETIME',
                    'null' => false,
                    'after' => 'course_id',
                ],
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('enrollments')) {
            return;
        }

        $fields = $db->getFieldNames('enrollments');
        if (in_array('enrollment_date', $fields, true)) {
            $this->forge->dropColumn('enrollments', 'enrollment_date');
        }
    }
}


