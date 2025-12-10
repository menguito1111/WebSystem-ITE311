<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;

class Announcement extends BaseController
{
    protected $announcementModel;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
    }

    /**
     * Display all announcements
     */
    public function index()
    {
        // Fetch all announcements ordered by created_at in descending order (newest first)
        $data['announcements'] = $this->announcementModel->orderBy('created_at', 'DESC')->findAll();

        return view('announcements', array_merge($this->data, $data));
    }

    /**
     * Show create announcement form
     */
    public function create()
    {
        // Role-based access control - only teachers and admins can create announcements
        $userRole = session()->get('userRole');
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        return view('announcements/create', array_merge($this->data, [
            'title' => 'Create Announcement'
        ]));
    }

    /**
     * Store a new announcement
     */
    public function store()
    {
        // Role-based access control - only teachers and admins can create announcements
        $userRole = session()->get('userRole');
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        // Validate input
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->announcementModel->insert($data)) {
            // Create notifications for all students
            $this->createNotificationsForStudents($data['title']);

            return redirect()->to('/dashboard')->with('success', 'Announcement created successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create announcement. Please try again.');
        }
    }

    /**
     * Show edit announcement form
     */
    public function edit($id)
    {
        // Role-based access control - only teachers and admins can edit announcements
        $userRole = session()->get('userRole');
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        $announcement = $this->announcementModel->find($id);
        if (!$announcement) {
            return redirect()->to('/announcements')->with('error', 'Announcement not found');
        }

        return view('announcements/edit', array_merge($this->data, [
            'title' => 'Edit Announcement',
            'announcement' => $announcement
        ]));
    }

    /**
     * Update an announcement
     */
    public function update($id)
    {
        // Role-based access control - only teachers and admins can update announcements
        $userRole = session()->get('userRole');
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Access denied');
        }

        $announcement = $this->announcementModel->find($id);
        if (!$announcement) {
            return redirect()->to('/announcements')->with('error', 'Announcement not found');
        }

        // Validate input
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'content' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->announcementModel->update($id, $data)) {
            return redirect()->to('/announcements')->with('success', 'Announcement updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update announcement. Please try again.');
        }
    }

    /**
     * Delete an announcement
     */
    public function delete($id)
    {
        // Role-based access control - only teachers and admins can delete announcements
        $userRole = session()->get('userRole');
        if (!in_array($userRole, ['teacher', 'admin'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
        }

        $announcement = $this->announcementModel->find($id);
        if (!$announcement) {
            return $this->response->setJSON(['success' => false, 'message' => 'Announcement not found']);
        }

        if ($this->announcementModel->delete($id)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Announcement deleted successfully!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete announcement. Please try again.']);
        }
    }

    /**
     * Search announcements
     */
    public function search()
    {
        $searchTerm = $this->request->getGet('search_term');

        if (!empty($searchTerm)) {
            $announcements = $this->announcementModel
                ->like('title', $searchTerm)
                ->orLike('content', $searchTerm)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } else {
            $announcements = $this->announcementModel->orderBy('created_at', 'DESC')->findAll();
        }

        return $this->response->setJSON([
            'success' => true,
            'announcements' => $announcements,
            'search_term' => $searchTerm
        ]);
    }

    /**
     * Create notifications for all students when a new announcement is posted
     */
    private function createNotificationsForStudents($announcementTitle)
    {
        $userModel = new \App\Models\UserModel();
        $notificationModel = new \App\Models\NotificationModel();

        // Get all active students
        $students = $userModel->where('role', 'student')->where('status', 'active')->findAll();

        $notifications = [];
        foreach ($students as $student) {
            $notifications[] = [
                'user_id' => $student['id'],
                'message' => 'New announcement: ' . $announcementTitle,
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        if (!empty($notifications)) {
            $notificationModel->insertBatch($notifications);
        }
    }
}
