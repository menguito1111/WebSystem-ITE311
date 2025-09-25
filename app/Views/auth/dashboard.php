<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-0 section-header d-inline-block">
            <?php
            switch($user_role) {
                case 'admin':
                    echo '<i class="fas fa-user-shield"></i> Admin Dashboard';
                    break;
                case 'teacher':
                    echo '<i class="fas fa-chalkboard-teacher"></i> Teacher Dashboard';
                    break;
                case 'student':
                    echo '<i class="fas fa-graduation-cap"></i> Student Dashboard';
                    break;
                default:
                    echo 'Dashboard';
            }
            ?>
        </h1>
        <p class="text-muted mb-0">Welcome back, <?= esc($user_name) ?>!</p>
    </div>
    <div>
        <span class="badge badge-soft me-2"><?= ucfirst($user_role) ?></span>
        <a class="btn btn-outline btn-sm" href="<?= site_url('logout') ?>">Logout</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<!-- CONDITIONAL CONTENT BASED ON USER ROLE -->

<?php if ($user_role === 'admin'): ?>
    <!-- ADMIN DASHBOARD CONTENT -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h3 class="mb-1"><?= esc($total_users ?? 0) ?></h3>
                <p class="text-muted mb-0">Total Users</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-user-shield fa-2x text-danger mb-2"></i>
                <h3 class="mb-1"><?= esc($total_admins ?? 0) ?></h3>
                <p class="text-muted mb-0">Admins</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-chalkboard-teacher fa-2x text-warning mb-2"></i>
                <h3 class="mb-1"><?= esc($total_teachers ?? 0) ?></h3>
                <p class="text-muted mb-0">Teachers</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-graduation-cap fa-2x text-success mb-2"></i>
                <h3 class="mb-1"><?= esc($total_students ?? 0) ?></h3>
                <p class="text-muted mb-0">Students</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card-lite">
                <h5 class="mb-3">Recent Users</h5>
                <div class="table-responsive">
                    <table class="table table-advanced">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_users)): ?>
                                <?php foreach ($recent_users as $user): ?>
                                    <tr>
                                        <td><?= esc($user['name'] ?? 'N/A') ?></td>
                                        <td><?= esc($user['email'] ?? 'N/A') ?></td>
                                        <td>
                                            <span class="badge badge-soft">
                                                <?= ucfirst($user['role'] ?? 'student') ?>
                                            </span>
                                        </td>
                                        <td><?= date('M j, Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No recent users</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-lite">
                <h5 class="mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Add New User
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-book"></i> Manage Courses
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-chart-bar"></i> View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($user_role === 'teacher'): ?>
    <!-- TEACHER DASHBOARD CONTENT -->
    <div class="row">
        <div class="col-md-8">
            <div class="card-lite">
                <h5 class="mb-3">My Courses</h5>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Course management features will be available soon. You can create and manage your courses here.
                </div>
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Course
                </button>
            </div>
            
            <div class="card-lite mt-3">
                <h5 class="mb-3">Recent Activity</h5>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No recent activity to display.
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-lite mb-3">
                <h5 class="mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-book"></i> Create Assignment
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar"></i> View Grades
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-users"></i> Manage Students
                    </a>
                </div>
            </div>
            
            <div class="card-lite">
                <h5 class="mb-3">Statistics</h5>
                <div class="text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x text-primary"></i>
                        <h4 class="mb-0"><?= esc($total_students_in_courses ?? 0) ?></h4>
                        <small class="text-muted">Students Enrolled</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php else: // STUDENT DASHBOARD ?>
    <!-- STUDENT DASHBOARD CONTENT -->
    <div class="row">
        <div class="col-md-8">
            <div class="card-lite">
                <h5 class="mb-3">My Courses</h5>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    You're not enrolled in any courses yet. Contact your teacher or administrator to get enrolled.
                </div>
            </div>
            
            <div class="card-lite mt-3">
                <h5 class="mb-3">Assignments</h5>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No assignments due at this time.
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-lite mb-3">
                <h5 class="mb-3">Recent Grades</h5>
                <div class="text-center text-muted">
                    <i class="fas fa-chart-line fa-3x mb-2"></i>
                    <p>No grades available yet.</p>
                </div>
            </div>
            
            <div class="card-lite">
                <h5 class="mb-3">Quick Links</h5>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-book-open"></i> Course Materials
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-file-alt"></i> Submit Assignment
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-calendar-check"></i> View Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>