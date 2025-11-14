<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Clear existing users first (handle foreign key constraints)
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
        // Create comprehensive test users with different roles
        $users = [
            // Admin Users
            [
                'name'  => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'System Administrator',
                'email' => 'sysadmin@example.com',
                'password' => password_hash('sysadmin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Teacher Users
            [
                'name'  => 'Dr. Sarah Johnson',
                'email' => 'teacher@example.com',
                'password' => password_hash('teacher123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'Prof. Michael Brown',
                'email' => 'michael.brown@example.com',
                'password' => password_hash('teacher456', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'Ms. Emily Davis',
                'email' => 'emily.davis@example.com',
                'password' => password_hash('teacher789', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            
            // Student Users
            [
                'name'  => 'John Doe',
                'email' => 'student@example.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => password_hash('student456', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'Alex Wilson',
                'email' => 'alex.wilson@example.com',
                'password' => password_hash('student789', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'Maria Garcia',
                'email' => 'maria.garcia@example.com',
                'password' => password_hash('student101', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'  => 'David Lee',
                'email' => 'david.lee@example.com',
                'password' => password_hash('student202', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert sample users into the 'users' table
        $this->db->table('users')->insertBatch($users);
        
        echo "Created " . count($users) . " test users:\n";
        echo "- 2 Admin users\n";
        echo "- 3 Teacher users\n";
        echo "- 5 Student users\n";
    }
}
