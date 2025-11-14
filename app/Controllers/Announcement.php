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
}
