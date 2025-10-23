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
            <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-primary">Manage Courses</a>
            <a href="#" class="btn btn-outline-success" onclick="showCourses()">Course Materials</a>
            <a href="#" class="btn btn-outline-info" onclick="showUploadOptions()">Upload Files</a>
            <a href="#" class="btn btn-outline-secondary disabled">View Reports</a>
        </div>
    </div>
</div>

<div class="mt-4" id="courses-section" style="display: none;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Course Materials</h5>
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

<div class="mt-4" id="upload-section" style="display: none;">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Upload Files</h5>
            <button class="btn btn-sm btn-outline-secondary" onclick="hideUploadOptions()">
                <i class="fas fa-times"></i> Close
            </button>
        </div>
        <div class="card-body">
            <div class="row" id="upload-courses-list">
                <!-- Upload options will be loaded here -->
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
    document.getElementById('upload-section').style.display = 'none';
    loadCourses();
}

function hideCourses() {
    document.getElementById('courses-section').style.display = 'none';
}

function showUploadOptions() {
    document.getElementById('upload-section').style.display = 'block';
    document.getElementById('courses-section').style.display = 'none';
    loadUploadCourses();
}

function hideUploadOptions() {
    document.getElementById('upload-section').style.display = 'none';
}

function loadCourses() {
    const coursesList = document.getElementById('courses-list');
    
    <?php if (!empty($courses)): ?>
        coursesList.innerHTML = `
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= esc($course['title']) ?></h6>
                            <?php if (!empty($course['description'])): ?>
                                <p class="card-text text-muted small"><?= esc($course['description']) ?></p>
                            <?php endif; ?>
                            
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('course/' . $course['id'] . '/materials') ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-folder-open me-1"></i>
                                        View Materials
                                    </a>
                                    <a href="<?= base_url('materials/upload/' . $course['id']) ?>" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-upload me-1"></i>
                                        Upload Material
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted small">
                            <i class="fas fa-calendar me-1"></i>
                            Created: <?= date('M d, Y', strtotime($course['created_at'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        `;
    <?php else: ?>
        coursesList.innerHTML = `
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    No courses available yet.
                    <br><br>
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Create Course
                    </a>
                </div>
            </div>
        `;
    <?php endif; ?>
}

function loadUploadCourses() {
    const uploadCoursesList = document.getElementById('upload-courses-list');
    
    <?php if (!empty($courses)): ?>
        uploadCoursesList.innerHTML = `
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 border-success">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-success">
                                <i class="fas fa-graduation-cap me-1"></i>
                                <?= esc($course['title']) ?>
                            </h6>
                            <?php if (!empty($course['description'])): ?>
                                <p class="card-text text-muted small"><?= esc($course['description']) ?></p>
                            <?php endif; ?>
                            
                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('materials/upload/' . $course['id']) ?>" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-upload me-1"></i>
                                        Upload Material
                                    </a>
                                    <a href="<?= base_url('course/' . $course['id'] . '/materials') ?>" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>
                                        View Materials
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted small">
                            <i class="fas fa-calendar me-1"></i>
                            Created: <?= date('M d, Y', strtotime($course['created_at'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        `;
    <?php else: ?>
        uploadCoursesList.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>No Courses Available</strong>
                    <br><br>
                    <p class="mb-3">You need to create courses before you can upload materials.</p>
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-warning btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        Create Your First Course
                    </a>
                </div>
            </div>
        `;
    <?php endif; ?>
}
</script>

<?= $this->endSection() ?>


