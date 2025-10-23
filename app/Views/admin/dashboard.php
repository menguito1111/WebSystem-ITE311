<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><?= esc($title ?? 'Admin Dashboard') ?></h2>
    <div>
        <a class="btn btn-danger btn-sm" href="<?= site_url('logout') ?>">Logout</a>
    </div>
    
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Total Users</h6>
                <h3 class="card-title mb-0"><?= esc($totalUsers ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Admins</h6>
                <h3 class="card-title mb-0"><?= esc($totalAdmins ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Teachers</h6>
                <h3 class="card-title mb-0"><?= esc($totalTeachers ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Students</h6>
                <h3 class="card-title mb-0"><?= esc($totalStudents ?? 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Total Courses</h6>
                <h3 class="card-title mb-0"><?= esc($totalCourses ?? 0) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="card">
        <div class="card-header">Quick Actions</div>
        <div class="card-body d-flex gap-2 flex-wrap">
            <a href="#" class="btn btn-primary disabled">Manage Users</a>
            <a href="#" class="btn btn-outline-primary disabled">Manage Courses</a>
            <a href="#" class="btn btn-outline-success" onclick="showCourses()">Course Materials</a>
            <a href="#" class="btn btn-outline-secondary disabled">View Reports</a>
        </div>
    </div>
</div>

<div class="mt-4" id="courses-section" style="display: none;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Course Management</h5>
            <button class="btn btn-sm btn-outline-secondary" onclick="hideCourses()">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
        <div class="card-body">
            <div class="row" id="courses-list">
                <!-- Courses will be loaded here -->
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="card">
        <div class="card-header">Recent Activity</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentUsers)): ?>
                            <?php foreach ($recentUsers as $u): ?>
                                <tr>
                                    <td><?= esc($u['name'] ?? '-') ?></td>
                                    <td><?= esc($u['email'] ?? '-') ?></td>
                                    <td><span class="badge bg-secondary text-uppercase"><?= esc($u['role'] ?? '-') ?></span></td>
                                    <td><?= esc($u['created_at'] ?? '-') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted p-3">No recent activity.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function showCourses() {
    document.getElementById('courses-section').style.display = 'block';
    loadCourses();
}

function hideCourses() {
    document.getElementById('courses-section').style.display = 'none';
}

function loadCourses() {
    // This would typically fetch from an API endpoint
    // For now, we'll show a placeholder
    const coursesList = document.getElementById('courses-list');
    coursesList.innerHTML = `
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Course management functionality would be implemented here.
                <br><br>
                <a href="<?= base_url('admin/courses') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-cog me-1"></i>
                    Manage Courses
                </a>
            </div>
        </div>
    `;
}
</script>

<?= $this->endSection() ?>


