<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveDepartmentAndProgramFromUsers extends Migration
{
    public function up()
    {
        // Remove foreign key constraints first if they exist
        $this->db->query("SET FOREIGN_KEY_CHECKS=0;");
        
        // Drop foreign keys if they exist
        $this->forge->dropForeignKey('users', 'users_department_id_foreign');
        $this->forge->dropForeignKey('users', 'users_program_id_foreign');
        
        // Remove columns from users table
        $this->forge->dropColumn('users', ['department_id', 'program_id']);
        
        $this->db->query("SET FOREIGN_KEY_CHECKS=1;");
        
        // Drop departments and programs tables
        $this->forge->dropTable('programs', true);
        $this->forge->dropTable('departments', true);
    }

    public function down()
    {
        // Recreate departments table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
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
        $this->forge->createTable('departments', true);

        // Recreate programs table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'department_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
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
        $this->forge->addForeignKey('department_id', 'departments', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('programs', true);

        // Add columns back to users table
        $this->forge->addColumn('users', [
            'department_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'role',
            ],
            'program_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'department_id',
            ],
        ]);
    }
}

