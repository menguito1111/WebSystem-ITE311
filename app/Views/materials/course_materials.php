<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-folder-open me-2"></i>
                        Course Materials: <?= esc($course['title']) ?>
                    </h4>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Dashboard
                    </a>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($course['description'])): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Course Description:</strong> <?= esc($course['description']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($materials)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No materials available</h5>
                            <p class="text-muted">There are no materials uploaded for this course yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($materials as $material): ?>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-start mb-3">
                                                <div class="me-3">
                                                    <?php
                                                    $fileExtension = strtolower(pathinfo($material['file_name'], PATHINFO_EXTENSION));
                                                    $iconClass = 'fas fa-file';
                                                    
                                                    switch ($fileExtension) {
                                                        case 'pdf':
                                                            $iconClass = 'fas fa-file-pdf text-danger';
                                                            break;
                                                        case 'doc':
                                                        case 'docx':
                                                            $iconClass = 'fas fa-file-word text-primary';
                                                            break;
                                                        case 'ppt':
                                                        case 'pptx':
                                                            $iconClass = 'fas fa-file-powerpoint text-warning';
                                                            break;
                                                        case 'txt':
                                                            $iconClass = 'fas fa-file-alt text-secondary';
                                                            break;
                                                        case 'jpg':
                                                        case 'jpeg':
                                                        case 'png':
                                                            $iconClass = 'fas fa-file-image text-success';
                                                            break;
                                                        default:
                                                            $iconClass = 'fas fa-file text-muted';
                                                    }
                                                    ?>
                                                    <i class="<?= $iconClass ?> fa-2x"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title mb-1 text-truncate" title="<?= esc($material['file_name']) ?>">
                                                        <?= esc($material['file_name']) ?>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        <?= date('M d, Y', strtotime($material['uploaded_at'])) ?>
                                                    </small>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-auto">
                                                <div class="d-grid gap-2">
                                                    <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download me-1"></i>
                                                        Download
                                                    </a>
                                                    
                                                    <?php if (session()->get('role') === 'admin' || session()->get('role') === 'teacher'): ?>
                                                        <a href="<?= base_url('materials/delete/' . $material['id']) ?>" 
                                                           class="btn btn-outline-danger btn-sm"
                                                           onclick="return confirm('Are you sure you want to delete this material?')">
                                                            <i class="fas fa-trash me-1"></i>
                                                            Delete
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (session()->get('role') === 'admin' || session()->get('role') === 'teacher'): ?>
<div class="container mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Instructor Actions</h5>
                    <p class="card-text">Upload new materials for this course</p>
                    <a href="<?= base_url('materials/upload/' . $course['id']) ?>" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i>
                        Upload New Material
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

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
