<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddYearLevelToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'year_level' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'default' => null,
                'after' => 'role',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'year_level');
    }
}

