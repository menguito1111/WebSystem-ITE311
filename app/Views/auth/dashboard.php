<?= $this->extend('template') ?>
<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <?= esc(session()->getFlashdata('info')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col">
            <h2 class="h3 fw-bold mb-1">Welcome back, <?= esc($userName) ?></h2>
            <p class="text-muted mb-0">
                Role: <span class="badge bg-primary"><?= esc(ucfirst($role)) ?></span>
                <?php if (isset($userEmail)): ?>
                    | Email: <span class="text-muted"><?= esc($userEmail) ?></span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <?php if ($role === 'admin'): ?>
        <!-- Admin Content -->
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalUsers ?? 0 ?></h4>
                                <p class="card-text">Total Users</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalCourses ?? 0 ?></h4>
                                <p class="card-text">Total Courses</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalEnrollments ?? 0 ?></h4>
                                <p class="card-text">Total Enrollments</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-graduation-cap fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $teacherCount ?? 0 ?></h4>
                                <p class="card-text">Teachers</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chalkboard-teacher fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Role Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Admins</h5>
                        <h3 class="text-primary"><?= $adminCount ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Teachers</h5>
                        <h3 class="text-success"><?= $teacherCount ?? 0 ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info">Students</h5>
                        <h3 class="text-info"><?= $studentCount ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Enrollments -->
        <?php if (!empty($recentEnrollments)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Recent Enrollments</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Enrollment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentEnrollments as $enrollment): ?>
                                    <tr>
                                        <td><?= esc($enrollment['student_name'] ?? 'Unknown') ?></td>
                                        <td><?= esc($enrollment['course_name'] ?? 'Unknown Course') ?></td>
                                        <td><?= date('M d, Y H:i', strtotime($enrollment['enrollment_date'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recent Announcements Section -->
        <?php
        $announcementModel = new \App\Models\AnnouncementModel();
        $recentAnnouncements = $announcementModel->orderBy('created_at', 'DESC')->limit(3)->findAll();
        ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bullhorn me-2"></i>Recent Announcements
                        </h5>
                        <div>
                            <a href="<?= base_url('/announcements/create') ?>" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-plus me-1"></i>Create Announcement
                            </a>
                            <a href="<?= base_url('/announcements') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentAnnouncements)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recentAnnouncements as $announcement): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-primary">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            <?= esc($announcement['title']) ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= date('M d, Y H:i', strtotime($announcement['created_at'])) ?>
                                        </small>
                                    </div>
                                    <p class="mb-1 text-dark">
                                        <?= esc(substr($announcement['content'], 0, 150)) ?>
                                        <?= strlen($announcement['content']) > 150 ? '...' : '' ?>
                                    </p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No Announcements Yet</h6>
                                <p class="text-muted small">Create your first announcement to communicate with students.</p>
                                <a href="<?= base_url('/announcements/create') ?>" class="btn btn-warning">
                                    <i class="fas fa-plus me-1"></i>Create First Announcement
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text">Manage system users and their roles.</p>
                        <a href="<?= base_url('/admin/users') ?>" class="btn btn-primary">Manage Users</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Course Management</h5>
                        <p class="card-text">Create and manage courses.</p>
                        <a href="<?= base_url('/admin/courses') ?>" class="btn btn-success">Manage Courses</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-bullhorn me-2"></i>Announcements</h5>
                        <p class="card-text">Create important announcements for students.</p>
                        <a href="<?= base_url('/announcements/create') ?>" class="btn btn-warning">Create Announcement</a>
                    </div>
                </div>
            </div>

        </div>

    <?php elseif ($role === 'teacher'): ?>
        <!-- Teacher Content -->
        
        <!-- Teacher Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalMyCourses ?? 0 ?></h4>
                                <p class="card-text">My Courses</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalStudents ?? 0 ?></h4>
                                <p class="card-text">Total Students</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= count($recentEnrollments ?? []) ?></h4>
                                <p class="card-text">Recent Enrollments</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-plus fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Courses -->
        <?php if (!empty($myCourses)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">My Courses</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($myCourses as $course): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary"><?= esc($course['course_name']) ?></h6>
                                        <p class="card-text small text-muted"><?= esc($course['course_code']) ?></p>
                                        <p class="card-text small"><?= esc(substr($course['description'] ?? '', 0, 100)) ?><?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><?= $course['units'] ?? 3 ?> units</small>
                                            <a href="<?= base_url('/teacher/course/' . $course['course_id']) ?>" class="btn btn-sm btn-outline-primary">Manage</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recent Enrollments -->
        <?php if (!empty($recentEnrollments)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Recent Enrollments in My Courses</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Enrollment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentEnrollments as $enrollment): ?>
                                    <tr>
                                        <td><?= esc($enrollment['student_name'] ?? 'Unknown') ?></td>
                                        <td><?= esc($enrollment['course_name'] ?? 'Unknown Course') ?></td>
                                        <td><?= date('M d, Y H:i', strtotime($enrollment['enrollment_date'])) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Assignment Section for Teachers -->
        <?php
        $assignmentModel = new \App\Models\AssignmentModel();
        $myAssignments = $assignmentModel->getAssignmentsByTeacher(session()->get('userId'));
        $pendingGradings = 0;

        foreach ($myAssignments as $assignment) {
            $submissionModel = new \App\Models\AssignmentSubmissionModel();
            $submissions = $submissionModel->getSubmissionsByAssignment($assignment['assignment_id']);
            $pendingGradings += count(array_filter($submissions, function($sub) {
                return $sub['grade'] === null;
            }));
        }
        ?>

        <?php if (!empty($myAssignments)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-tasks me-2"></i>Assignments Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h3 class="text-success"><?= count($myAssignments) ?></h3>
                                <p class="mb-0">Total Assignments</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-warning"><?= array_sum(array_map(function($a) use ($submissionModel) {
                                    $subs = $submissionModel->getSubmissionsByAssignment($a['assignment_id']);
                                    return count($subs);
                                }, $myAssignments)) ?></h3>
                                <p class="mb-0">Student Submissions</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-danger"><?= $pendingGradings ?></h3>
                                <p class="mb-0">Pending Gradings</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <a href="<?= base_url('/teacher/assignments') ?>" class="btn btn-info me-2">
                                    <i class="fas fa-list me-1"></i>View All Assignments
                                </a>
                                <a href="<?= base_url('/teacher/create-assignment') ?>" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i>Create New Assignment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Teacher Actions -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chalkboard-teacher me-2"></i>My Classes</h5>
                        <p class="card-text">Manage your classes and student progress.</p>
                        <a href="<?= base_url('/teacher/classes') ?>" class="btn btn-primary">
                            <i class="fas fa-eye me-1"></i>View Classes
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-plus-circle me-2"></i>Create Course</h5>
                        <p class="card-text">Create new courses for students to enroll.</p>
                        <a href="<?= base_url('/teacher/create-course') ?>" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Create Course
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-tasks me-2"></i>Assignments</h5>
                        <p class="card-text">Create assignments and grade submissions.</p>
                        <a href="<?= base_url('/teacher/assignments') ?>" class="btn btn-info">
                            <i class="fas fa-edit me-1"></i>Manage Assignments
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-file-upload me-2"></i>Teaching Materials</h5>
                        <p class="card-text">Upload and manage course materials.</p>
                        <a href="<?= base_url('/teacher/get-courses') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-upload me-1"></i>Manage Materials
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Announcements Section -->
        <?php
        $announcementModel = new \App\Models\AnnouncementModel();
        $recentAnnouncements = $announcementModel->orderBy('created_at', 'DESC')->limit(3)->findAll();
        ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bullhorn me-2"></i>Recent Announcements
                        </h5>
                        <div>
                            <a href="<?= base_url('/announcements/create') ?>" class="btn btn-sm btn-warning me-2">
                                <i class="fas fa-plus me-1"></i>Create Announcement
                            </a>
                            <a href="<?= base_url('/announcements') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentAnnouncements)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recentAnnouncements as $announcement): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 text-primary">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            <?= esc($announcement['title']) ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= date('M d, Y H:i', strtotime($announcement['created_at'])) ?>
                                        </small>
                                    </div>
                                    <p class="mb-1 text-dark">
                                        <?= esc(substr($announcement['content'], 0, 150)) ?>
                                        <?= strlen($announcement['content']) > 150 ? '...' : '' ?>
                                    </p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No Announcements Yet</h6>
                                <p class="text-muted small">Create your first announcement to communicate with students.</p>
                                <a href="<?= base_url('/announcements/create') ?>" class="btn btn-warning">
                                    <i class="fas fa-plus me-1"></i>Create First Announcement
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Teacher Quick Actions -->
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-graduation-cap me-2"></i>Grade Students</h5>
                        <p class="card-text">View and grade student submissions.</p>
                        <a href="<?= base_url('/teacher/grades') ?>" class="btn btn-outline-success">
                            <i class="fas fa-edit me-1"></i>Grade Students
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-chart-line me-2"></i>Course Analytics</h5>
                        <p class="card-text">View course performance and analytics.</p>
                        <button class="btn btn-outline-info" onclick="showComingSoon('Course Analytics')">
                            <i class="fas fa-chart-bar me-1"></i>View Analytics
                        </button>
                    </div>
                </div>
            </div>
        </div>



    <?php elseif ($role === 'student'): ?>
        <!-- Student Content -->
        
        <!-- Student Statistics -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalEnrolled ?? 0 ?></h4>
                                <p class="card-text">Enrolled Courses</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $totalAvailable ?? 0 ?></h4>
                                <p class="card-text">Available Courses</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-plus-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title"><?= count($recentActivity ?? []) ?></h4>
                                <p class="card-text">Recent Activity</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-history fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <?php if (!empty($recentActivity)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($recentActivity as $activity): ?>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Enrolled in <?= esc($activity['course_name']) ?></h6>
                                    <small><?= date('M d, Y', strtotime($activity['enrollment_date'])) ?></small>
                                </div>
                                <p class="mb-1">Course Code: <?= esc($activity['course_code']) ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Notifications Section -->
        <?php
        $notificationModel = new \App\Models\NotificationModel();
        $notifications = $notificationModel->getNotificationsForUser(session()->get('userId'), 3);
        ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell me-2"></i>Recent Notifications
                        </h5>
                        <a href="<?= base_url('/announcements') ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-bullhorn me-1"></i>View Announcements
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($notifications)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($notifications as $notification): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle text-info me-3"></i>
                                        <div>
                                            <p class="mb-1 fw-medium text-dark"><?= esc($notification['message']) ?></p>
                                            <small class="text-muted">
                                                <?= date('M d, Y H:i', strtotime($notification['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary mark-read-btn"
                                            data-notification-id="<?= $notification['id'] ?>"
                                            title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    New announcements appear here automatically
                                </small>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No New Notifications</h6>
                                <p class="text-muted small">You'll see notifications here when teachers or admins post announcements.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enrolled Courses Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-3">📚 My Enrolled Courses</h4>

                <!-- Dashboard search (students) -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form id="dashboardSearchForm" class="d-flex">
                            <div class="input-group">
                                <input type="text" id="dashboardSearchInput" class="form-control" placeholder="Search courses..." name="search_term">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if (!empty($enrolledCourses)): ?>
                    <div id="dashboardEnrolledContainer" class="row">
                        <?php foreach ($enrolledCourses as $enrollment): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 dashboard-course-card">
                                    <div class="card-body">
                                        <h6 class="card-title text-primary"><?= esc($enrollment['course_name']) ?></h6>
                                        <p class="card-text small text-muted"><?= esc($enrollment['course_code']) ?></p>
                                        <p class="card-text small mb-3"><?= esc(substr($enrollment['description'] ?? '', 0, 100)) ?><?= strlen($enrollment['description'] ?? '') > 100 ? '...' : '' ?></p>
                                        
                                        <!-- Course Materials -->
                                        <?php if (!empty($enrollment['materials'])): ?>
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">📁 Course Materials</h6>
                                                <div class="list-group list-group-flush">
                                                    <?php foreach ($enrollment['materials'] as $material): ?>
                                                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                            <div>
                                                                <small class="fw-medium text-dark">
                                                                    <?= esc($material['file_name']) ?>
                                                                </small>
                                                                <br>
                                                                <small class="text-muted">
                                                                    Uploaded: <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                                                </small>
                                                            </div>
                                                            <a href="<?= base_url('/materials/download/' . $material['id']) ?>" 
                                                               class="btn btn-sm btn-outline-primary" 
                                                               title="Download Material">
                                                                Download
                                                            </a>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="mb-3">
                                                <small class="text-muted">No materials available for this course yet.</small>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                Enrolled: <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                            </small>
                                            <button class="btn btn-sm btn-outline-danger unenroll-btn" 
                                                    data-course-id="<?= $enrollment['course_id'] ?>"
                                                    data-course-name="<?= esc($enrollment['course_name']) ?>">
                                                Unenroll
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <h6 class="alert-heading">No Enrolled Courses</h6>
                        <p class="mb-0">You haven't enrolled in any courses yet. Browse available courses below to get started!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Available Courses Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="mb-3">🎯 Available Courses</h4>
                <?php if (!empty($availableCourses)): ?>
                    <div id="dashboardAvailableContainer" class="row">
                        <?php foreach ($availableCourses as $course): ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 dashboard-course-card">
                                    <div class="card-body">
                                        <h6 class="card-title text-success"><?= esc($course['course_name']) ?></h6>
                                        <p class="card-text small text-muted"><?= esc($course['course_code']) ?></p>
                                        <p class="card-text small"><?= esc(substr($course['description'] ?? '', 0, 100)) ?><?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted"><?= $course['units'] ?? 3 ?> units</small>
                                            <button class="btn btn-sm btn-success enroll-btn" 
                                                    data-course-id="<?= $course['course_id'] ?>"
                                                    data-course-name="<?= esc($course['course_name']) ?>">
                                                Enroll
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <h6 class="alert-heading">No Available Courses</h6>
                        <p class="mb-0">You are enrolled in all available courses! Great job!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Assignment Section for Students -->
        <?php
        $assignmentSubmissionModel = new \App\Models\AssignmentSubmissionModel();
        $assignmentStats = $assignmentSubmissionModel->getAssignmentsWithSubmissionStatus(session()->get('userId'));

        $pendingAssignments = array_filter($assignmentStats, function($assignment) {
            return $assignment['submission_status'] === 'Not submitted';
        });

        $submittedAssignments = array_filter($assignmentStats, function($assignment) {
            return $assignment['submission_status'] === 'Submitted';
        });

        $gradedAssignments = array_filter($assignmentStats, function($assignment) {
            return $assignment['submission_status'] === 'Graded';
        });
        ?>

        <?php if (!empty($assignmentStats)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-clipboard-check me-2"></i>My Assignments Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h3 class="text-danger"><?= count($pendingAssignments) ?></h3>
                                <p class="mb-0">Pending Submissions</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-warning"><?= count($submittedAssignments) ?></h3>
                                <p class="mb-0">Submitted & Pending Grade</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-success"><?= count($gradedAssignments) ?></h3>
                                <p class="mb-0">Grades Received</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <a href="<?= base_url('/student/assignments') ?>" class="btn btn-success me-2">
                                    <i class="fas fa-eye me-1"></i>View All Assignments
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i>My Assignments</h5>
                        <p class="card-text">View and submit your assignments.</p>
                        <a href="<?= base_url('/student/assignments') ?>" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>View Assignments
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-graduation-cap me-2"></i>My Grades</h5>
                        <p class="card-text">Check your academic performance and grades.</p>
                        <a href="<?= base_url('/student/grades') ?>" class="btn btn-outline-success">
                            <i class="fas fa-chart-line me-1"></i>View Grades
                        </a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Unknown Role -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title text-danger">Role Not Recognized</h5>
                        <p class="card-text">Please contact the administrator.</p>
                        <a href="#" class="btn btn-outline-danger">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript for enhanced functionality -->
<script>
// Function to show "Coming Soon" message
function showComingSoon(feature) {
    alert(feature + ' - Coming Soon!\n\nThis feature is currently under development. Thank you for your patience!');
}

// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Enhanced course management for teachers
<?php if ($role === 'teacher'): ?>
// Add click handlers for course management
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to action cards
    const actionCards = document.querySelectorAll('.card');
    actionCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
<?php endif; ?>

// Enhanced enrollment and notification functionality for students
<?php if ($role === 'student'): ?>
document.addEventListener('DOMContentLoaded', function() {
    // Handle mark as read buttons for notifications
    document.querySelectorAll('.mark-read-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            const listItem = this.closest('.list-group-item');

            // Disable button
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            // Make AJAX request to mark as read
            fetch('<?= base_url('/notifications/mark_read/') ?>' + notificationId, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the notification from the list with fade effect
                    listItem.style.opacity = '0';
                    setTimeout(function() {
                        listItem.remove();

                        // Check if there are any notifications left
                        const remainingNotifications = document.querySelectorAll('.list-group-item');
                        if (remainingNotifications.length === 0) {
                            // Show empty state
                            const notificationsCard = document.querySelector('.card:has(.list-group)');
                            const cardBody = notificationsCard.querySelector('.card-body');
                            cardBody.innerHTML = `
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No New Notifications</h6>
                                    <p class="text-muted small">You'll see notifications here when teachers or admins post announcements.</p>
                                </div>
                            `;
                        }
                    }, 300);
                } else {
                    // Re-enable button on error
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    alert('Failed to mark notification as read. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Re-enable button on error
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-check"></i>';
                alert('An error occurred. Please try again.');
            });
        });
    });

    // Handle enrollment buttons
    const enrollButtons = document.querySelectorAll('.enroll-btn');
    enrollButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const courseId = button.getAttribute('data-course-id');
            const courseName = button.getAttribute('data-course-name');

            if (confirm('Are you sure you want to enroll in "' + courseName + '"?')) {
                enrollInCourse(courseId, button);
            }
        });
    });

    // Handle unenrollment buttons
    const unenrollButtons = document.querySelectorAll('.unenroll-btn');
    unenrollButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const courseId = button.getAttribute('data-course-id');
            const courseName = button.getAttribute('data-course-name');

            if (confirm('Are you sure you want to unenroll from "' + courseName + '"?')) {
                unenrollFromCourse(courseId, button);
            }
        });
    });

    // Function to enroll in a course
    function enrollInCourse(courseId, button) {
        // Disable button and show loading
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enrolling...';

        // Prepare form data
        const formData = new FormData();
        formData.append('course_id', courseId);

        // Make AJAX request
        fetch('<?= base_url('/course/enroll') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);

                // Move course card from available to enrolled section
                moveCourseToEnrolled(courseId, data.course);

                // Update statistics
                updateEnrollmentStats();

                // Create notification if available
                if (typeof createNotification === 'function') {
                    createNotification(data.message, 'success');
                }
            } else {
                // Show error message
                showAlert('danger', data.message);
                // Re-enable button
                button.disabled = false;
                button.innerHTML = 'Enroll';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred. Please try again.');
            // Re-enable button
            button.disabled = false;
            button.innerHTML = 'Enroll';
        });
    }

    // Function to unenroll from a course
    function unenrollFromCourse(courseId, button) {
        // Disable button and show loading
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Unenrolling...';

        // Prepare form data
        const formData = new FormData();
        formData.append('course_id', courseId);

        // Make AJAX request
        fetch('<?= base_url('/course/unenroll') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showAlert('success', data.message);

                // Move course card from enrolled to available section
                moveCourseToAvailable(courseId);

                // Update statistics
                updateEnrollmentStats();
            } else {
                // Show error message
                showAlert('danger', data.message);
                // Re-enable button
                button.disabled = false;
                button.innerHTML = 'Unenroll';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred. Please try again.');
            // Re-enable button
            button.disabled = false;
            button.innerHTML = 'Unenroll';
        });
    }

    // Function to move course card to enrolled section
    function moveCourseToEnrolled(courseId, courseData) {
        // Find the course card in available courses
        const availableCard = document.querySelector(`.enroll-btn[data-course-id="${courseId}"]`).closest('.col-md-6');
        if (!availableCard) return;

        // Clone the card and modify for enrolled section
        const enrolledCard = availableCard.cloneNode(true);

        // Update button to unenroll
        const button = enrolledCard.querySelector('.enroll-btn');
        button.className = 'btn btn-sm btn-outline-danger unenroll-btn';
        button.innerHTML = 'Unenroll';
        button.setAttribute('data-course-name', courseData.name);

        // Add enrollment date
        const cardBody = enrolledCard.querySelector('.card-body');
        const existingFooter = cardBody.querySelector('.d-flex');
        if (existingFooter) {
            const enrollmentInfo = document.createElement('div');
            enrollmentInfo.innerHTML = `<small class="text-muted">Enrolled: ${new Date().toLocaleDateString()}</small>`;
            existingFooter.insertAdjacentElement('afterend', enrollmentInfo);
        }

        // Remove materials section if it exists (since it's for enrolled courses)
        const materialsSection = enrolledCard.querySelector('.mb-3');
        if (materialsSection && materialsSection.innerHTML.includes('Course Materials')) {
            materialsSection.remove();
        }

        // Move to enrolled courses section
        const enrolledContainer = document.querySelector('#enrolled-courses-container');
        if (enrolledContainer) {
            enrolledContainer.appendChild(enrolledCard);
        } else {
            // Fallback: find enrolled courses section
            const enrolledSection = document.querySelector('.row.mb-4 .col-12 h4');
            if (enrolledSection && enrolledSection.textContent.includes('My Enrolled Courses')) {
                const container = enrolledSection.closest('.col-12').querySelector('.row');
                if (container) {
                    container.appendChild(enrolledCard);
                }
            }
        }

        // Remove from available courses
        availableCard.remove();

        // Re-attach event listeners to the new button
        const newButton = enrolledCard.querySelector('.unenroll-btn');
        newButton.addEventListener('click', function() {
            const courseId = this.getAttribute('data-course-id');
            const courseName = this.getAttribute('data-course-name');
            if (confirm('Are you sure you want to unenroll from "' + courseName + '"?')) {
                unenrollFromCourse(courseId, this);
            }
        });
    }

    // Function to move course card to available section
    function moveCourseToAvailable(courseId) {
        // Find the course card in enrolled courses
        const enrolledCard = document.querySelector(`.unenroll-btn[data-course-id="${courseId}"]`).closest('.col-md-6');
        if (!enrolledCard) return;

        // Clone the card and modify for available section
        const availableCard = enrolledCard.cloneNode(true);

        // Update button to enroll
        const button = availableCard.querySelector('.unenroll-btn');
        button.className = 'btn btn-sm btn-success enroll-btn';
        button.innerHTML = 'Enroll';
        button.setAttribute('data-course-name', button.getAttribute('data-course-name'));

        // Remove enrollment date
        const enrollmentInfo = availableCard.querySelector('small.text-muted');
        if (enrollmentInfo && enrollmentInfo.textContent.includes('Enrolled:')) {
            enrollmentInfo.remove();
        }

        // Move to available courses section
        const availableContainer = document.querySelector('#available-courses-container');
        if (availableContainer) {
            availableContainer.appendChild(availableCard);
        } else {
            // Fallback: find available courses section
            const availableSections = document.querySelectorAll('.row.mb-4 .col-12 h4');
            availableSections.forEach(section => {
                if (section.textContent.includes('Available Courses')) {
                    const container = section.closest('.col-12').querySelector('.row');
                    if (container) {
                        container.appendChild(availableCard);
                    }
                }
            });
        }

        // Remove from enrolled courses
        enrolledCard.remove();

        // Re-attach event listeners to the new button
        const newButton = availableCard.querySelector('.enroll-btn');
        newButton.addEventListener('click', function() {
            const courseId = this.getAttribute('data-course-id');
            const courseName = this.getAttribute('data-course-name');
            if (confirm('Are you sure you want to enroll in "' + courseName + '"?')) {
                enrollInCourse(courseId, this);
            }
        });
    }

    // Function to update enrollment statistics
    function updateEnrollmentStats() {
        // Update enrolled courses count
        const enrolledCards = document.querySelectorAll('.unenroll-btn').length;
        const enrolledStat = document.querySelector('.card.bg-primary .card-title');
        if (enrolledStat) {
            enrolledStat.textContent = enrolledCards;
        }

        // Update available courses count
        const availableCards = document.querySelectorAll('.enroll-btn').length;
        const availableStat = document.querySelector('.card.bg-success .card-title');
        if (availableStat) {
            availableStat.textContent = availableCards;
        }
    }

    // Function to show alert messages
    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Insert at the top of the container
        const container = document.querySelector('.container.mt-4');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
        }

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }
});
<?php endif; ?>
</script>

<?php if ($role === 'student'): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.jQuery === 'undefined') return;

    // Client-side filter across enrolled and available courses
    $('#dashboardSearchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.dashboard-course-card').each(function() {
            var text = $(this).text().toLowerCase();
            $(this).closest('.col-md-6, .col-lg-4').toggle(text.indexOf(value) > -1);
        });
    });

    // Server-side search to show matching courses (replaces available container)
    $('#dashboardSearchForm').on('submit', function(e) {
        e.preventDefault();
        var term = $('#dashboardSearchInput').val();

        $.get('<?= base_url('/courses/search') ?>', {search_term: term}, function(data) {
            // Replace available courses container with results
            var $container = $('#dashboardAvailableContainer');
            if ($container.length === 0) {
                // Fallback to existing available section
                $container = $('<div id="dashboardAvailableContainer" class="row"></div>');
                $('h4:contains("Available Courses")').closest('.col-12').append($container);
            }
            $container.empty();

            if (data && data.length > 0) {
                $.each(data, function(i, course) {
                    var html = `
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100 dashboard-course-card">
                                <div class="card-body">
                                    <h6 class="card-title text-success">${course.course_name}</h6>
                                    <p class="card-text small text-muted">${course.course_code || ''}</p>
                                    <p class="card-text small">${(course.description || '').substring(0,100)}${(course.description || '').length > 100 ? '...' : ''}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">${course.units || 3} units</small>
                                        <button class="btn btn-sm btn-success enroll-btn" data-course-id="${course.course_id}" data-course-name="${course.course_name}">Enroll</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $container.append(html);
                });
            } else {
                $container.html('<div class="col-12"><div class="alert alert-info">No courses found matching your search.</div></div>');
            }
        });
    });

    // Delegate enroll button clicks in dynamic results
    $(document).on('click', '.enroll-btn', function() {
        var courseId = $(this).data('course-id');
        var btn = this;
        if (confirm('Enroll in this course?')) {
            $.post('<?= base_url('/course/enroll') ?>', {course_id: courseId}, function(resp) {
                if (resp.success) {
                    alert(resp.message);
                    // Optionally refresh page or update DOM
                    location.reload();
                } else {
                    alert(resp.message);
                }
            }, 'json');
        }
    });
});
</script>
<?php endif; ?>

<?= $this->endSection() ?>
