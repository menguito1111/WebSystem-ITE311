<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'message' => 'You have been enrolled in Mathematics 101',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 1,
                'message' => 'You have been enrolled in Physics 201',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'user_id' => 2, // Assuming another user exists
                'message' => 'You have been enrolled in Chemistry 101',
                'is_read' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ]
        ];

        $this->db->table('notifications')->insertBatch($data);
    }
}
