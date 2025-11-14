<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is authenticated
        if (!session()->get('isAuthenticated')) {
            return redirect()->to('/login')->with('error', 'Please login to access this page.');
        }

        // Get user role
        $userRole = session()->get('userRole');
        $currentPath = $request->getUri()->getPath();
        
        // Get URI segments to properly identify the route
        $segments = $request->getUri()->getSegments();
        $firstSegment = isset($segments[0]) ? $segments[0] : '';

        // Role-based access control
        switch ($userRole) {
            case 'admin':
                // Admins can access any route starting with /admin
                if ($firstSegment === 'admin') {
                    return; // Allow access
                }
                // If admin tries to access non-admin routes, redirect to unified dashboard
                return redirect()->to('/dashboard')->with('error', 'Access Denied: Insufficient Permissions');
                
            case 'teacher':
                // Teachers can access routes starting with /teacher
                if ($firstSegment === 'teacher') {
                    return; // Allow access
                }
                // If teacher tries to access non-teacher routes, redirect to unified dashboard
                return redirect()->to('/dashboard')->with('error', 'Access Denied: Insufficient Permissions');
                
            case 'student':
                // Students can access routes starting with /student and /announcements
                if ($firstSegment === 'student' || $currentPath === '/announcements') {
                    return; // Allow access
                }
                // If student tries to access non-student routes, redirect to dashboard
                return redirect()->to('/dashboard')->with('error', 'Access Denied: Insufficient Permissions');
                
            default:
                // Unknown role, deny access
                return redirect()->to('/dashboard')->with('error', 'Access Denied: Insufficient Permissions');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
