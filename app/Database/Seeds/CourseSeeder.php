<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing courses first
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('courses')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
        // Create sample courses
        $courses = [
            [
                'course_name' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript.',
                'course_code' => 'WEB101',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Database Management Systems',
                'description' => 'Comprehensive course on database design, SQL, and database administration.',
                'course_code' => 'DBMS201',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Object-Oriented Programming',
                'description' => 'Learn OOP concepts using PHP and Java programming languages.',
                'course_code' => 'OOP301',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Software Engineering Principles',
                'description' => 'Study software development methodologies, design patterns, and best practices.',
                'course_code' => 'SE401',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Mobile App Development',
                'description' => 'Create mobile applications using modern frameworks and tools.',
                'course_code' => 'MOB501',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Cybersecurity Fundamentals',
                'description' => 'Introduction to cybersecurity concepts, threats, and protection methods.',
                'course_code' => 'CS601',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Data Structures and Algorithms',
                'description' => 'Learn fundamental data structures and algorithmic problem-solving techniques.',
                'course_code' => 'DSA701',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'course_name' => 'Machine Learning Basics',
                'description' => 'Introduction to machine learning concepts and practical applications.',
                'course_code' => 'ML801',
                'units' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert sample courses into the 'courses' table
        $this->db->table('courses')->insertBatch($courses);
        
        echo "Created " . count($courses) . " sample courses:\n";
        echo "- Introduction to Web Development (WEB101)\n";
        echo "- Database Management Systems (DBMS201)\n";
        echo "- Object-Oriented Programming (OOP301)\n";
        echo "- Software Engineering Principles (SE401)\n";
        echo "- Mobile App Development (MOB501)\n";
        echo "- Cybersecurity Fundamentals (CS601)\n";
        echo "- Data Structures and Algorithms (DSA701)\n";
        echo "- Machine Learning Basics (ML801)\n";
    }
}
