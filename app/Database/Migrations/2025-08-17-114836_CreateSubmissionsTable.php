<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'submission_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'quiz_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'score' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
    'type'    => 'DATETIME',
    'null'    => true,
    'default' => null,
],
'updated_at' => [
    'type'    => 'DATETIME',
    'null'    => true,
    'default' => null,
],
'deleted_at' => [
    'type'    => 'DATETIME',
    'null'    => true,
    'default' => null,
],

        ]);

        // Primary Key
        $this->forge->addKey('submission_id', true);

        // Indexes for faster lookups
        $this->forge->addKey('quiz_id');
        $this->forge->addKey('user_id');

        // Foreign Keys (must match existing PKs!)
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'quiz_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('submissions', true);
    }

    public function down()
    {
        $this->forge->dropTable('submissions', true);
    }
}
