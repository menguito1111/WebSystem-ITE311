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
            'name' => 'required|min_length[2]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,teacher,student]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        // Prepare user data
        $userData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role')
        ];

        try {
            $userId = $userModel->insert($userData);
            if ($userId) {
                return $this->response->setJSON(['success' => true, 'message' => 'User created successfully']);
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
            'role' => 'required|in_list[admin,teacher,student]'
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