# Laboratory Activity: Course Enrollment System Testing Guide

## Overview
This document provides comprehensive testing instructions for the course enrollment system implemented as part of the Laboratory Activity. The system allows students to enroll in courses using AJAX functionality without page reloads.

## System Components Implemented

### ✅ Database Components
- **Enrollments Table**: Created with proper foreign key relationships
- **Sample Courses**: 8 courses populated in the database
- **Sample Users**: 10 test users (2 admins, 3 teachers, 5 students)

### ✅ Models
- **EnrollmentModel**: Handles enrollment operations
- **CourseModel**: Manages course data and availability

### ✅ Controllers
- **Course Controller**: Handles AJAX enrollment/unenrollment requests
- **Auth Controller**: Updated to load enrollment data for students

### ✅ Views
- **Student Dashboard**: Enhanced with enrollment sections
- **AJAX Functionality**: jQuery-based enrollment system

### ✅ Routes
- **Enrollment Routes**: POST endpoints for enrollment operations

## Testing Checklist

### 1. Database Setup Verification

#### ✅ Verify Database Tables
1. Check that `enrollments` table exists with proper structure:
   - `id` (primary key)
   - `user_id` (foreign key to users)
   - `course_id` (foreign key to courses)
   - `enrollment_date` (datetime)
   - `created_at`, `updated_at` (timestamps)

2. Verify sample data is populated:
   - 8 courses in `courses` table
   - 10 users in `users` table

### 2. Student Login and Dashboard Testing

#### ✅ Test Student Access
1. Login as a student user:
   - **Email**: `student@example.com`
   - **Password**: `student123`

2. Verify dashboard loads with enrollment sections:
   - "📚 My Enrolled Courses" section
   - "🎯 Available Courses" section
   - Quick actions section

#### ✅ Test Initial State
1. Verify "My Enrolled Courses" shows:
   - Empty state message (if no enrollments)
   - Or existing enrolled courses

2. Verify "Available Courses" shows:
   - All 8 sample courses
   - Each course has an "Enroll" button
   - Course information (name, code, description, units)

### 3. AJAX Enrollment Testing

#### ✅ Test Successful Enrollment
1. Click "Enroll" button on any available course
2. Verify the following happens **without page reload**:
   - Button changes to "Enrolling..." and becomes disabled
   - Success message appears at the top
   - Course card fades out and disappears
   - Course appears in "My Enrolled Courses" section
   - Course is removed from "Available Courses" section

#### ✅ Test Multiple Enrollments
1. Enroll in 2-3 different courses
2. Verify each enrollment works independently
3. Check that enrolled courses appear in correct section
4. Verify available courses list updates correctly

#### ✅ Test Enrollment Validation
1. Try to enroll in the same course twice (should be prevented)
2. Verify error message appears
3. Check that duplicate enrollment is not created

### 4. AJAX Unenrollment Testing

#### ✅ Test Successful Unenrollment
1. Click "Unenroll" button on an enrolled course
2. Verify confirmation dialog appears
3. Confirm the unenrollment
4. Verify the following happens **without page reload**:
   - Success message appears
   - Course card fades out from enrolled section
   - Course reappears in available courses section

#### ✅ Test Unenrollment Validation
1. Try to unenroll from a course you're not enrolled in
2. Verify appropriate error message

### 5. Error Handling Testing

#### ✅ Test Network Errors
1. Disconnect internet temporarily
2. Try to enroll in a course
3. Verify error message appears
4. Verify button is re-enabled

#### ✅ Test Server Errors
1. Test with invalid course IDs
2. Test with non-student users
3. Verify appropriate error messages

### 6. User Role Testing

#### ✅ Test Non-Student Access
1. Login as admin (`admin@example.com` / `admin123`)
2. Navigate to dashboard
3. Verify enrollment sections are not visible
4. Try to access enrollment endpoints directly (should be denied)

1. Login as teacher (`teacher@example.com` / `teacher123`)
2. Navigate to dashboard
3. Verify enrollment sections are not visible

#### ✅ Test Unauthenticated Access
1. Logout from any account
2. Try to access enrollment endpoints
3. Verify authentication is required

### 7. UI/UX Testing

#### ✅ Test Responsive Design
1. Test on different screen sizes
2. Verify course cards stack properly
3. Check button accessibility

#### ✅ Test Alert Messages
1. Verify success messages appear and auto-dismiss
2. Verify error messages are clear and helpful
3. Test alert dismissal functionality

#### ✅ Test Loading States
1. Verify buttons show loading state during requests
2. Check that buttons are disabled during processing
3. Verify proper re-enabling after completion

### 8. Data Integrity Testing

#### ✅ Test Database Consistency
1. Enroll in courses and verify database records
2. Unenroll and verify records are removed
3. Check foreign key constraints work properly

#### ✅ Test Session Management
1. Verify enrollment persists across page refreshes
2. Test logout/login cycle maintains enrollment state

## Expected Results

### ✅ Success Indicators
- Students can enroll/unenroll without page reloads
- Real-time UI updates work correctly
- Proper error handling and user feedback
- Role-based access control works
- Database integrity maintained
- Responsive design works on all devices

### ❌ Failure Indicators
- Page reloads during enrollment
- Duplicate enrollments created
- UI doesn't update after actions
- Non-students can access enrollment
- Database inconsistencies
- JavaScript errors in console

## Test Scenarios

### Scenario 1: Complete Student Workflow
1. Login as student
2. View available courses
3. Enroll in 3 different courses
4. Verify all enrollments appear correctly
5. Unenroll from 1 course
6. Verify course moves back to available
7. Logout and login again
8. Verify enrollment state persists

### Scenario 2: Error Handling
1. Login as student
2. Try to enroll in same course twice
3. Verify error message
4. Try to unenroll from non-enrolled course
5. Verify appropriate error
6. Test with network issues

### Scenario 3: Role-Based Access
1. Test with admin user (should not see enrollment)
2. Test with teacher user (should not see enrollment)
3. Test with unauthenticated user (should be redirected)

## Troubleshooting

### Common Issues
1. **AJAX not working**: Check jQuery is loaded and console for errors
2. **Database errors**: Verify foreign key constraints and table structure
3. **Permission errors**: Check role-based access control
4. **UI not updating**: Verify JavaScript event handlers

### Debug Steps
1. Check browser developer tools console
2. Verify network requests in Network tab
3. Check server logs for PHP errors
4. Verify database records directly

## Conclusion
This comprehensive testing ensures the enrollment system works correctly with proper AJAX functionality, role-based access control, and data integrity. The system provides a smooth user experience without page reloads while maintaining security and data consistency.
