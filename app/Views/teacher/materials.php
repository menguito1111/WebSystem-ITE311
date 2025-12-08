<?= $this->extend('template') ?>

<?= $this->section('title') ?><?= $title ?> - Course Materials<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .course-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .course-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .material-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #495057;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="section-header mb-4">
            <h2><i class="fas fa-file-alt text-primary me-2"></i>Course Materials</h2>
            <p class="text-muted mb-0">Manage assignments, resources, and materials for your courses</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card course-card">
            <div class="card-body text-center p-4">
                <div class="material-icon bg-light rounded-circle mx-auto mb-3">
                    <i class="fas fa-upload fa-2x"></i>
                </div>
                <h6 class="card-title mb-2">Upload Materials</h6>
                <p class="card-text text-muted small">Add files, documents, and resources</p>
                <a href="<?= base_url('teacher/get-courses') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Select Course
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card course-card">
            <div class="card-body text-center p-4">
                <div class="material-icon bg-light rounded-circle mx-auto mb-3">
                    <i class="fas fa-task fa-2x"></i>
                </div>
                <h6 class="card-title mb-2">Assignments</h6>
                <p class="card-text text-muted small">Create and manage assignments</p>
                <a href="<?= base_url('teacher/grades') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-arrow-right me-1"></i>Manage Grades
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card course-card">
            <div class="card-body text-center p-4">
                <div class="material-icon bg-light rounded-circle mx-auto mb-3">
                    <i class="fas fa-chart-line fa-2x"></i>
                </div>
                <h6 class="card-title mb-2">Reports</h6>
                <p class="card-text text-muted small">View submission and progress reports</p>
                <a href="#" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-eye me-1"></i>View Reports
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Materials Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Material Activity</h6>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <div class="material-icon bg-light rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                        <i class="fas fa-inbox fa-3x text-muted"></i>
                    </div>
                    <h6 class="text-muted mb-2">No Recent Activity</h6>
                    <p class="text-muted small mb-3">Your material management activity will appear here</p>
                    <a href="<?= base_url('teacher/get-courses') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info border-0">
            <h6><i class="fas fa-info-circle me-2"></i>Need Help?</h6>
            <p class="mb-2">To upload materials for your courses:</p>
            <ol class="mb-0 small">
                <li>Go to <strong>My Courses</strong> to select a course</li>
                <li>Click on <strong>Upload Materials</strong> in the course management area</li>
                <li>Upload your files and provide descriptions</li>
            </ol>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
