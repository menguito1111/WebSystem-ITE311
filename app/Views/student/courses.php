<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Student</a></li>
                        <li class="breadcrumb-item active">My Courses</li>
                    </ol>
                </div>
                <h4 class="page-title">My Courses</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Enrolled Courses</h5>
                    <p class="text-muted">Here are your enrolled courses for this semester.</p>
                    
                    <?php if (empty($enrollments)): ?>
                        <div class="alert alert-info" role="alert">
                            <i class="mdi mdi-information-outline me-1"></i>
                            No courses enrolled yet. Contact your advisor to enroll in courses.
                        </div>
                    <?php else: ?>
                        <?php foreach ($enrollments as $enrollment): ?>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <?= esc($enrollment['course_code']) ?> - <?= esc($enrollment['course_name']) ?>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">
                                        <strong>Description:</strong> <?= esc($enrollment['description'] ?? 'No description available.') ?>
                                    </p>

                                    <h6>Course Materials</h6>
                                    <?php if (empty($enrollment['materials'])): ?>
                                        <p class="text-muted">No materials available for this course.</p>
                                    <?php else: ?>
                                        <div class="list-group">
                                            <?php foreach ($enrollment['materials'] as $material): ?>
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="mdi mdi-file-document-outline me-2"></i>
                                                        <?= esc($material['file_name']) ?>
                                                        <small class="text-muted d-block">
                                                            Uploaded: <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                    <a href="<?= base_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-primary">
                                                        <i class="mdi mdi-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
