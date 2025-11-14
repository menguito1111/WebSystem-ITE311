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
        return view('admin/manage_users', [
            'title' => 'Manage Users',
            'userName' => session()->get('userName'),
            'userEmail' => session()->get('userEmail'),
            'userRole' => session()->get('userRole')
        ]);
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