<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        // Clear existing announcements first
        $this->db->table('announcements')->truncate();
        
        // Create sample announcements
        $announcements = [
            [
                'title' => 'Welcome to the Online Student Portal',
                'content' => 'We are excited to welcome you to our new Online Student Portal! This platform provides a comprehensive solution for managing your academic journey, connecting with teachers, and accessing course materials. Please explore all the features available and don\'t hesitate to reach out if you need assistance.',
                'created_at' => '2025-10-16 23:16:00',
                'updated_at' => '2025-10-16 23:16:00',
            ],
            [
                'title' => 'Fall Semester Registration Now Open',
                'content' => 'Registration for the Fall semester is now open! Students can enroll in courses through the portal until August 15th. Please review the course catalog and meet with your academic advisor to plan your schedule. Early registration ensures you get your preferred courses and time slots.',
                'created_at' => '2025-10-13 23:16:00',
                'updated_at' => '2025-10-13 23:16:00',
            ],
            [
                'title' => 'New Learning Management System Features',
                'content' => 'We have implemented several new features in our Learning Management System including improved mobile responsiveness, enhanced discussion forums, and better integration with external tools. These updates will provide a more seamless learning experience for all users.',
                'created_at' => '2025-10-10 14:30:00',
                'updated_at' => '2025-10-10 14:30:00',
            ],
            [
                'title' => 'Academic Calendar Updates',
                'content' => 'Please note that there have been some changes to the academic calendar for the upcoming semester. Key dates include: Midterm exams (March 15-20), Spring break (March 25-29), and Final exams (May 10-15). Please check your course schedules for specific exam times.',
                'created_at' => '2025-10-08 09:45:00',
                'updated_at' => '2025-10-08 09:45:00',
            ],
            [
                'title' => 'Library Services Available Online',
                'content' => 'Our digital library services are now fully operational. Students can access e-books, research databases, and online journals from anywhere. Library staff are available for virtual consultations and research assistance. Contact the library help desk for more information.',
                'created_at' => '2025-10-05 16:20:00',
                'updated_at' => '2025-10-05 16:20:00',
            ]
        ];

        // Insert sample announcements into the 'announcements' table
        $this->db->table('announcements')->insertBatch($announcements);
        
        echo "Created " . count($announcements) . " sample announcements:\n";
        foreach ($announcements as $index => $announcement) {
            echo "- " . ($index + 1) . ". " . $announcement['title'] . "\n";
        }
    }
}
