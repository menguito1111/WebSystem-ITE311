<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCoursesAddTitleDescription extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // Guard: if table doesn't exist, skip (initial create migration will handle it)
        if (!$db->tableExists('courses')) {
            return;
        }

        $fields = $db->getFieldNames('courses');

        // Collect missing columns to add
        $columnsToAdd = [];
        if (!in_array('title', $fields, true)) {
            $columnsToAdd['title'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'after' => 'id',
            ];
        }
        if (!in_array('description', $fields, true)) {
            $columnsToAdd['description'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'title',
            ];
        }

        if (!empty($columnsToAdd)) {
            $this->forge->addColumn('courses', $columnsToAdd);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('courses')) {
            return;
        }

        $fields = $db->getFieldNames('courses');

        if (in_array('description', $fields, true)) {
            $this->forge->dropColumn('courses', 'description');
        }
        if (in_array('title', $fields, true)) {
            $this->forge->dropColumn('courses', 'title');
        }
    }
}


