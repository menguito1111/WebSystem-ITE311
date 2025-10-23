<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><?= esc($title ?? 'Course Management') ?></h2>
    <div>
        <a class="btn btn-outline-primary me-2" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
        <a class="btn btn-danger btn-sm" href="<?= site_url('logout') ?>">Logout</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-graduation-cap me-2"></i>
            All Courses
        </h5>
    </div>
    <div class="card-body">
        <?php if (empty($courses)): ?>
            <div class="text-center py-5">
                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No courses available</h5>
                <p class="text-muted">There are no courses in the system yet.</p>
            </div>
        <?php else: ?>
            <div class="row">
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
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>
