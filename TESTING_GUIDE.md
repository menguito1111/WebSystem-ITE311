# Role-Based Authentication Testing Guide

## Overview
This document provides comprehensive testing instructions for the role-based authentication system. The application supports three user roles: **Admin**, **Teacher**, and **Student**, each with different access levels and functionality.

## Test Users Created

### Admin Users
| Email | Password | Name |
|-------|----------|------|
| admin@example.com | admin123 | Super Admin |
| sysadmin@example.com | sysadmin123 | System Administrator |

### Teacher Users
| Email | Password | Name |
|-------|----------|------|
| teacher@example.com | teacher123 | Dr. Sarah Johnson |
| michael.brown@example.com | teacher456 | Prof. Michael Brown |
| emily.davis@example.com | teacher789 | Ms. Emily Davis |

### Student Users
| Email | Password | Name |
|-------|----------|------|
| student@example.com | student123 | John Doe |
| jane.smith@example.com | student456 | Jane Smith |
| alex.wilson@example.com | student789 | Alex Wilson |
| maria.garcia@example.com | student101 | Maria Garcia |
| david.lee@example.com | student202 | David Lee |

## Testing Checklist

### 1. User Registration and Login Testing

#### ✅ Test User Registration
1. Navigate to `/register`
2. Create a new account with valid information
3. Verify the user is automatically assigned the "student" role
4. Confirm successful registration redirects to login page

#### ✅ Test Login Functionality
1. Navigate to `/login`
2. Test login with each test user account
3. Verify successful login redirects to `/dashboard`
4. Confirm session data is properly set

### 2. Dashboard Access Testing

#### ✅ Test Dashboard Redirect
1. Log in with any user role
2. Verify all users are redirected to the same dashboard URL (`/dashboard`)
3. Confirm dashboard displays different content based on user role

#### ✅ Test Role-Specific Dashboard Content

**Admin Dashboard Should Show:**
- User Management section
- System Overview section
- Total user count
- Admin-specific navigation menu items

**Teacher Dashboard Should Show:**
- My Classes section
- Teaching Materials section
- Teacher-specific navigation menu items

**Student Dashboard Should Show:**
- My Courses section
- My Grades section
- Student-specific navigation menu items

### 3. Navigation Bar Testing

#### ✅ Test Role-Based Navigation
Verify that the navigation bar shows appropriate menu items for each role:

**Admin Navigation Should Include:**
- Dashboard
- Manage Users
- Reports
- Settings
- Logout

**Teacher Navigation Should Include:**
- Dashboard
- My Classes
- Materials
- Grade Students
- Logout

**Student Navigation Should Include:**
- Dashboard
- My Courses
- My Grades
- Assignments
- Logout

### 4. Access Control Testing

#### ✅ Test Role-Based Page Access

**Admin-Only Pages (should be accessible only to admin users):**
- `/manage-users` - User Management
- `/reports` - System Reports
- `/admin/settings` - System Settings

**Teacher-Only Pages (should be accessible only to teacher users):**
- `/teacher/classes` - My Classes
- `/teacher/materials` - Teaching Materials
- `/teacher/grades` - Grade Students

**Student-Only Pages (should be accessible only to student users):**
- `/student/courses` - My Courses
- `/student/grades` - My Grades
- `/student/assignments` - My Assignments

#### ✅ Test Access Denial
1. Log in as a student user
2. Try to access admin pages (e.g., `/manage-users`)
3. Verify you are redirected to dashboard with error message
4. Repeat test with teacher accessing admin pages
5. Repeat test with admin accessing student pages

### 5. Logout Functionality Testing

#### ✅ Test Logout Process
1. Log in with any user account
2. Click the "Logout" link in the navigation
3. Verify session is destroyed
4. Confirm redirect to login page with success message
5. Try to access protected pages - should redirect to login

### 6. Session Management Testing

#### ✅ Test Session Persistence
1. Log in and navigate between pages
2. Verify session data persists across page loads
3. Confirm user information remains available

#### ✅ Test Session Security
1. Log out and verify session is completely destroyed
2. Try to access protected pages without login
3. Verify proper redirect to login page

## Detailed Test Scenarios

### Scenario 1: Complete Admin Workflow
1. Login as `admin@example.com` / `admin123`
2. Verify admin dashboard loads with admin content
3. Navigate to "Manage Users" - should work
4. Navigate to "Reports" - should work
5. Navigate to "Settings" - should work
6. Try accessing student page `/student/courses` - should be denied
7. Logout and verify session is cleared

### Scenario 2: Complete Teacher Workflow
1. Login as `teacher@example.com` / `teacher123`
2. Verify teacher dashboard loads with teacher content
3. Navigate to "My Classes" - should work
4. Navigate to "Materials" - should work
5. Navigate to "Grade Students" - should work
6. Try accessing admin page `/manage-users` - should be denied
7. Try accessing student page `/student/courses` - should be denied
8. Logout and verify session is cleared

### Scenario 3: Complete Student Workflow
1. Login as `student@example.com` / `student123`
2. Verify student dashboard loads with student content
3. Navigate to "My Courses" - should work
4. Navigate to "My Grades" - should work
5. Navigate to "Assignments" - should work
6. Try accessing admin page `/manage-users` - should be denied
7. Try accessing teacher page `/teacher/classes` - should be denied
8. Logout and verify session is cleared

### Scenario 4: Cross-Role Access Testing
1. Login as admin and verify admin access
2. Logout and login as teacher
3. Verify teacher access and admin denial
4. Logout and login as student
5. Verify student access and admin/teacher denial

## Expected Results

### ✅ Success Indicators
- All users can login successfully
- Dashboard shows role-appropriate content
- Navigation shows role-specific menu items
- Role-based access control works correctly
- Logout destroys session completely
- Error messages are user-friendly
- Redirects work as expected

### ❌ Failure Indicators
- Users can access pages they shouldn't
- Dashboard shows wrong content for role
- Navigation shows incorrect menu items
- Session persists after logout
- No error messages for access violations
- Broken redirects or infinite loops

## Troubleshooting

### Common Issues
1. **Session not persisting**: Check session configuration
2. **Access control not working**: Verify RoleFilter is properly registered
3. **Wrong dashboard content**: Check role comparison logic
4. **Navigation issues**: Verify template role checks

### Debug Steps
1. Check browser developer tools for JavaScript errors
2. Verify session data in browser storage
3. Check server logs for PHP errors
4. Test with different browsers/incognito mode

## Running the Tests

### Prerequisites
1. Ensure database is set up with user table
2. Run the UserSeeder to create test users
3. Verify all routes are properly configured
4. Check that RoleFilter is registered

### Test Execution
1. Start with basic login/logout functionality
2. Test each role individually
3. Test cross-role access restrictions
4. Verify all navigation links work correctly
5. Test edge cases and error conditions

## Conclusion
This comprehensive testing ensures that the role-based authentication system works correctly, providing appropriate access control and user experience for each role type.
