<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        // If table does not exist, create it
        if (!$db->tableExists('courses')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'title' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);

            $this->forge->addKey('id', true);
            $this->forge->createTable('courses', true);
            return;
        }

        // If table already exists, ensure required columns exist
        $fields = $db->getFieldNames('courses');
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
        if (!in_array('created_at', $fields, true)) {
            $columnsToAdd['created_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description',
            ];
        }
        if (!in_array('updated_at', $fields, true)) {
            $columnsToAdd['updated_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ];
        }
        if (!empty($columnsToAdd)) {
            $this->forge->addColumn('courses', $columnsToAdd);
        }
    }

    public function down()
    {
        $this->forge->dropTable('courses', true);
    }
}


