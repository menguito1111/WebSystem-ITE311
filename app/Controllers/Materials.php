<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class Materials extends BaseController
{
    protected $materialModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
        helper(['session', 'url', 'form']);
    }

    /**
     * Display file upload form and handle file upload
     *
     * @param int $course_id
     * @return string
     */
    public function upload($course_id)
    {
        log_message('info', 'Upload method called for course ID: ' . $course_id . ', Method: ' . $this->request->getMethod());
        
        // Check if user is admin/instructor
        $userRole = session()->get('role');
        $isLoggedIn = session()->get('isLoggedIn');
        log_message('info', 'User role: ' . ($userRole ?: 'null') . ', Is logged in: ' . ($isLoggedIn ? 'yes' : 'no'));
        
        if (!$isLoggedIn) {
            log_message('info', 'User not logged in, redirecting to login');
            return redirect()->to('/login')->with('error', 'Please login to upload materials.');
        }
        
        if ($userRole !== 'admin' && $userRole !== 'teacher') {
            log_message('info', 'Access denied - user role: ' . $userRole);
            return redirect()->to('/')->with('error', 'Access denied. Admin privileges required.');
        }

        // Get course information
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            log_message('error', 'Course not found: ' . $course_id);
            return redirect()->to('/admin/courses')->with('error', 'Course not found.');
        }

        if ($this->request->getMethod() === 'post') {
            log_message('info', 'POST request received, calling handleFileUpload');
            return $this->handleFileUpload($course_id);
        }

        // Display upload form
        $data = [
            'title' => 'Upload Material',
            'course' => $course,
            'course_id' => $course_id
        ];

        return view('materials/upload', $data);
    }

    /**
     * Handle file upload process
     *
     * @param int $course_id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    private function handleFileUpload($course_id)
    {
        log_message('info', 'Starting file upload process for course ID: ' . $course_id);
        
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('material_file');

        log_message('info', 'File received: ' . ($file ? $file->getClientName() : 'No file'));

        // Check if file was uploaded
        if (!$file || !$file->isValid()) {
            log_message('error', 'No valid file uploaded. File object: ' . ($file ? 'exists' : 'null'));
            if ($file) {
                log_message('error', 'File error: ' . $file->getError() . ' - ' . $file->getErrorString());
            }
            return redirect()->back()->withInput()->with('error', 'No valid file was uploaded.');
        }

        // Validation rules
        $rules = [
            'material_file' => 'uploaded[material_file]|max_size[material_file,10240]|ext_in[material_file,pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png]'
        ];

        log_message('info', 'Validating file with rules: ' . print_r($rules, true));
        
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            log_message('error', 'File upload validation failed: ' . print_r($errors, true));
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        
        log_message('info', 'File validation passed');

        if ($file->isValid() && !$file->hasMoved()) {
            // Create uploads directory if it doesn't exist
            $uploadPath = WRITEPATH . 'uploads/materials/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $newName = $file->getRandomName();
            $moveResult = $file->move($uploadPath, $newName);
            
            log_message('info', 'File upload attempt - File: ' . $file->getClientName() . ', Move result: ' . ($moveResult ? 'success' : 'failed'));

            if ($moveResult) {
                // Prepare data for database
                $data = [
                    'course_id' => $course_id,
                    'file_name' => $file->getClientName(),
                    'file_path' => 'uploads/materials/' . $newName
                ];

                log_message('info', 'Attempting to save material to database: ' . print_r($data, true));

                // Save to database
                log_message('info', 'Attempting database insert with data: ' . print_r($data, true));
                $insertResult = $this->materialModel->insertMaterial($data);
                log_message('info', 'Database insert result: ' . ($insertResult ? $insertResult : 'false'));
                
                if ($insertResult) {
                    log_message('info', 'Material saved successfully with ID: ' . $insertResult);
                    // Redirect based on user role
                    if (session()->get('role') === 'teacher') {
                        return redirect()->to('/dashboard')->with('success', 'Material uploaded successfully.');
                    } else {
                        return redirect()->to('/admin/courses')->with('success', 'Material uploaded successfully.');
                    }
                } else {
                    // Delete uploaded file if database insert fails
                    unlink($uploadPath . $newName);
                    $dbErrors = $this->materialModel->errors();
                    log_message('error', 'Database insert failed: ' . print_r($dbErrors, true));
                    log_message('error', 'Data being inserted: ' . print_r($data, true));
                    log_message('error', 'Model errors: ' . print_r($this->materialModel->errors(), true));
                    return redirect()->back()->with('error', 'Failed to save material information. ' . implode(', ', $dbErrors));
                }
            } else {
                log_message('error', 'File move failed');
                return redirect()->back()->with('error', 'Failed to move uploaded file.');
            }
        } else {
            $error = $file->getError();
            log_message('error', 'File upload failed - Error code: ' . $error . ', Error message: ' . $file->getErrorString());
            return redirect()->back()->with('error', 'File upload failed. Error: ' . $file->getErrorString());
        }
    }

    /**
     * Delete a material
     *
     * @param int $material_id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($material_id)
    {
        // Check if user is admin/instructor
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'teacher') {
            return redirect()->to('/')->with('error', 'Access denied. Admin privileges required.');
        }

        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Delete file from filesystem
        $filePath = WRITEPATH . $material['file_path'];
        if (file_exists($filePath)) {
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
     * Download a material file
     *
     * @param int $material_id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login to download materials.');
        }

        $material = $this->materialModel->getMaterialById($material_id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }

        // Check if user is enrolled in the course
        $userId = session()->get('user_id');
        $isEnrolled = $this->enrollmentModel->where('user_id', $userId)
                                          ->where('course_id', $material['course_id'])
                                          ->first();

        // Allow admin/instructor to download any material
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'teacher' && !$isEnrolled) {
            return redirect()->back()->with('error', 'You must be enrolled in this course to download materials.');
        }

        $filePath = WRITEPATH . $material['file_path'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found on server.');
        }

        // Force download
        return $this->response->download($filePath, null);
    }

    /**
     * Display materials for a course (student view)
     *
     * @param int $course_id
     * @return string
     */
    public function courseMaterials($course_id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please login to view materials.');
        }

        // Get course information
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            return redirect()->to('/dashboard')->with('error', 'Course not found.');
        }

        // Check if user is enrolled in the course
        $userId = session()->get('user_id');
        $isEnrolled = $this->enrollmentModel->where('user_id', $userId)
                                          ->where('course_id', $course_id)
                                          ->first();

        // Allow admin/instructor to view any course materials
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'teacher' && !$isEnrolled) {
            return redirect()->to('/dashboard')->with('error', 'You must be enrolled in this course to view materials.');
        }

        // Get materials for the course
        $materials = $this->materialModel->getMaterialsByCourse($course_id);

        $data = [
            'title' => 'Course Materials',
            'course' => $course,
            'materials' => $materials
        ];

        return view('materials/course_materials', $data);
    }
}
