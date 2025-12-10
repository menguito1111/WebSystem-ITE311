<?php

namespace App\Controllers;

class Admin extends BaseController
{
    /**
     * Admin Dashboard
     * Redirects to unified dashboard with admin-specific functionality
     */
    public function dashboard()
    {
        // Redirect to unified dashboard - it will automatically show admin content
        return redirect()->to('/dashboard');
    }

    public function manageUsers()
    {
        // Role-based access control is handled by the RoleAuth filter
        $userModel = new \App\Models\UserModel();
        // Include soft-deleted users so admin can see deleted records
        $users = $userModel->withDeleted()->findAll();

        return view('admin/manage_users', [
            'title' => 'Manage Users',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'users' => $users
        ]);
    }

    /**
     * Create a new user.
     * Returns JSON used by the Manage Users view.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function createUser()
    {
        $userModel = new \App\Models\UserModel();

        // Validate input
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]|regex_match[/^[a-zA-Z\s\-\']+$/]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'role' => 'required|in_list[admin,teacher,student,librarian]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        // Set default password
        $defaultPassword = 'password123';

        // Prepare user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($defaultPassword, PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'status' => 'active'
        ];

        try {
            $userId = $userModel->insert($userData);
            if ($userId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User created successfully. Default password: ' . $defaultPassword
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to create user']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Create failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Show edit user form.
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function editUser($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return redirect()->to('/admin/manage-users')->with('error', 'Invalid user ID');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/manage-users')->with('error', 'User not found');
        }

        return view('admin/edit_user', [
            'title' => 'Edit User',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'user' => $user
        ]);
    }

    /**
     * Update user.
     * Returns redirect with flash message.
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function updateUser($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return redirect()->to('/admin/manage-users')->with('error', 'Invalid user ID');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/manage-users')->with('error', 'User not found');
        }

        // Validate input
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $id . ']',
            'role' => 'required|in_list[admin,teacher,student,librarian]'
        ];

        // Only validate password if provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Prepare user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role')
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $userData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        try {
            $updated = $userModel->update($id, $userData);
            if ($updated) {
                return redirect()->to('/admin/manage-users')->with('success', 'User updated successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update user');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Soft-delete a user (mark as deleted via `deleted_at`).
     * Returns JSON used by the Manage Users view.
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function deleteUser($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid user id']);
        }

        // Prevent deleting currently logged-in admin
        if (session()->get('userId') == $id) {
            return $this->response->setJSON(['success' => false, 'message' => 'You cannot delete your own account']);
        }

        $userModel = new \App\Models\UserModel();

        // Attempt soft-delete (Model->delete will set deleted_at when soft deletes enabled)
        try {
            $deleted = $userModel->delete($id);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Delete failed: ' . $e->getMessage()]);
        }

        if ($deleted) {
            return $this->response->setJSON(['success' => true, 'message' => 'User marked as deleted']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete user']);
    }

    public function reports()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('admin/reports', [
            'title' => 'Reports',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]);
    }

    /**
     * Change user status (activate/deactivate).
     * Returns JSON.
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function changeUserStatus($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid user id']);
        }

        // Prevent deactivating main admin (assume ID 1)
        if ($id == 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot deactivate main admin account']);
        }

        // Prevent deactivating yourself
        if (session()->get('userId') == $id) {
            return $this->response->setJSON(['success' => false, 'message' => 'You cannot deactivate your own account']);
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }

        $newStatus = ($user['status'] ?? 'active') === 'active' ? 'inactive' : 'active';

        try {
            $updated = $userModel->update($id, ['status' => $newStatus]);
            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User ' . ($newStatus === 'active' ? 'activated' : 'deactivated') . ' successfully',
                    'newStatus' => $newStatus
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update user status']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Status change failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Change user role instantly.
     * Returns JSON.
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function changeUserRole($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid user id']);
        }

        // Prevent changing main admin role (assume ID 1)
        if ($id == 1) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cannot change main admin role']);
        }

        $newRole = $this->request->getPost('role');
        if (!in_array($newRole, ['admin', 'teacher', 'student', 'librarian'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid role']);
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return $this->response->setJSON(['success' => false, 'message' => 'User not found']);
        }

        try {
            $updated = $userModel->update($id, ['role' => $newRole]);
            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User role updated successfully',
                    'newRole' => ucfirst($newRole)
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update user role']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Role change failed: ' . $e->getMessage()]);
        }
    }

    public function courseManagement()
    {
        // Role-based access control is handled by the RoleAuth filter
        $courseModel = new \App\Models\CourseModel();
        $userModel = new \App\Models\UserModel();

        $courses = $courseModel->getCoursesForAdmin();
        $totalCourses = $courseModel->getTotalCourses();
        $activeCourses = $courseModel->getActiveCourses();
        $teachers = $userModel->where('role', 'teacher')->findAll();

        return view('admin/course_management', [
            'title' => 'Course Management',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole'),
            'courses' => $courses,
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'teachers' => $teachers
        ]);
    }

    public function createCourse()
    {
        $courseModel = new \App\Models\CourseModel();

        // Validate input
        $rules = [
            'course_code' => 'required|min_length[3]|max_length[50]|is_unique[courses.course_code]',
            'course_name' => 'required|min_length[3]|max_length[150]',
            'description' => 'permit_empty',
            'school_year' => 'permit_empty|max_length[20]',
            'semester' => 'permit_empty|in_list[1st Semester,2nd Semester,Summer]',
            'schedule' => 'permit_empty|max_length[100]',
            'start_date' => 'permit_empty',
            'end_date' => 'permit_empty',
            'teacher_id' => 'permit_empty|integer',
            'status' => 'required|in_list[Active,Inactive]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        // Additional validation: Check if end date is after start date
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        if (!empty($startDate) && !empty($endDate)) {
            $startDateTime = new \DateTime($startDate);
            $endDateTime = new \DateTime($endDate);

            if ($endDateTime <= $startDateTime) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'End date must be after the start date.'
                ]);
            }
        }

        // Prepare course data
        $courseData = [
            'course_code' => $this->request->getPost('course_code'),
            'course_name' => $this->request->getPost('course_name'),
            'description' => $this->request->getPost('description'),
            'school_year' => $this->request->getPost('school_year'),
            'semester' => $this->request->getPost('semester'),
            'schedule' => $this->request->getPost('schedule'),
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date' => $this->request->getPost('end_date') ?: null,
            'teacher_id' => $this->request->getPost('teacher_id') ?: null,
            'status' => $this->request->getPost('status')
        ];

        try {
            $courseId = $courseModel->insert($courseData);
            if ($courseId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Course created successfully'
                ]);
            } else {
                // Get any database errors
                $errors = $courseModel->errors();
                $errorMsg = !empty($errors) ? implode(', ', $errors) : 'Unknown database error';
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to create course: ' . $errorMsg]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to create course: ' . $e->getMessage()]);
        }
    }

    public function updateCourse($id = null)
    {
        $id = (int) $id;
        if ($id <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid course ID']);
        }

        $courseModel = new \App\Models\CourseModel();

        // Validate input
        $rules = [
            'course_name' => 'required|min_length[3]|max_length[150]',
            'description' => 'permit_empty',
            'school_year' => 'permit_empty|max_length[20]',
            'semester' => 'permit_empty|in_list[1st Semester,2nd Semester,Summer]',
            'schedule' => 'permit_empty|max_length[100]',
            'start_date' => 'permit_empty',
            'end_date' => 'permit_empty',
            'teacher_id' => 'permit_empty|integer',
            'status' => 'required|in_list[Active,Inactive]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        // Additional validation: Check if end date is after start date
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        if (!empty($startDate) && !empty($endDate)) {
            $startDateTime = new \DateTime($startDate);
            $endDateTime = new \DateTime($endDate);

            if ($endDateTime <= $startDateTime) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'End date must be after the start date.'
                ]);
            }
        }

        // Prepare course data
        $courseData = [
            'course_name' => $this->request->getPost('course_name'),
            'description' => $this->request->getPost('description'),
            'school_year' => $this->request->getPost('school_year'),
            'semester' => $this->request->getPost('semester'),
            'schedule' => $this->request->getPost('schedule'),
            'start_date' => $this->request->getPost('start_date') ?: null,
            'end_date' => $this->request->getPost('end_date') ?: null,
            'teacher_id' => $this->request->getPost('teacher_id') ?: null,
            'status' => $this->request->getPost('status')
        ];

        try {
            $updated = $courseModel->update($id, $courseData);
            if ($updated) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Course updated successfully'
                ]);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to update course']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    public function settings()
    {
        // Role-based access control is handled by the RoleAuth filter
        return view('admin/settings', [
            'title' => 'Settings',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]);
    }
}
