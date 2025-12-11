<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MaterialModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Files\File;

class Materials extends BaseController
{
    protected $materialModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->enrollmentModel = new EnrollmentModel();
        helper(['form', 'url']);
    }

    /**
     * Display upload form and handle file upload
     */
    public function upload($course_id)
    {
        // Check if user is logged in and is admin/teacher
        if (!session()->get('isAuthenticated') || !in_array(session()->get('userRole'), ['admin', 'teacher'])) {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        if ($this->request->getMethod() === 'POST') {
            // Handle file upload
            $validation = \Config\Services::validation();
            $validation->setRules([
                // Restrict uploads to PDF or PowerPoint only
                'material' => 'uploaded[material]|max_size[material,10240]|ext_in[material,pdf,ppt,pptx]|mime_in[material,application/pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->with('error', $validation->getErrors()['material']);
            }

            $file = $this->request->getFile('material');
            if ($file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = WRITEPATH . 'uploads/materials/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Generate unique filename
                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                // Prepare data for database
                $data = [
                    'course_id' => $course_id,
                    'file_name' => $file->getClientName(),
                    'file_path' => 'uploads/materials/' . $newName,
                ];

                // Save to database
                if ($this->materialModel->insertMaterial($data)) {
                    return redirect()->to('/teacher/get-courses')->with('success', 'Material uploaded successfully.');
                } else {
                    // Delete file if DB insert fails
                    unlink($uploadPath . $newName);
                    return redirect()->back()->with('error', 'Failed to save material.');
                }
            }
        }

        // Display upload form
        return view('materials/upload', array_merge($this->data, [
            'course_id' => $course_id,
            'title' => 'Upload Material',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]));
    }

    /**
     * Delete a material
     */
    public function delete($material_id)
    {
        // Check if user is logged in and is admin/teacher
        if (!session()->get('isAuthenticated') || !in_array(session()->get('userRole'), ['admin', 'teacher'])) {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Delete file
        $filePath = WRITEPATH . $material['file_path'];
        if (is_file($filePath)) {
            unlink($filePath);
        }

        // Delete from database
        if ($this->materialModel->deleteMaterial($material_id)) {
            return redirect()->back()->with('success', 'Material deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete material.');
        }
    }

    /**
     * Download a material
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!session()->get('isAuthenticated')) {
            return redirect()->to('/login')->with('error', 'Please log in to download materials.');
        }

        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Check if user is enrolled in the course or is admin/teacher
        $userId = session()->get('userId');
        $userRole = session()->get('userRole');
        if (!in_array($userRole, ['admin', 'teacher']) && !$this->enrollmentModel->isAlreadyEnrolled($userId, $material['course_id'])) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }

        $filePath = WRITEPATH . $material['file_path'];
        if (!is_file($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Force download
        return $this->response->download($filePath, null)->setFileName($material['file_name']);
    }
}
