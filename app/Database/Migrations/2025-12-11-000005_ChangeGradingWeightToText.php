<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChangeGradingWeightToText extends Migration
{
    public function up()
    {
        // Change grading_weight from DECIMAL to TEXT
        $fields = [
            'grading_weight' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->modifyColumn('courses', $fields);
    }

    public function down()
    {
        // Revert back to DECIMAL
        $fields = [
            'grading_weight' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
        ];
        $this->forge->modifyColumn('courses', $fields);
    }
}

