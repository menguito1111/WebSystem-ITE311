<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Teacher</a></li>
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
                    <h5 class="card-title">Courses</h5>
                    <p class="text-muted">Manage your courses and materials.</p>

                    <?php if (empty($courses)): ?>
                        <div class="alert alert-info" role="alert">
                            <i class="mdi mdi-information-outline me-1"></i>
                            No courses available.
                        </div>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <?= esc($course['course_code']) ?> - <?= esc($course['course_name']) ?>
                                    </h5>
                                    <a href="<?= base_url('admin/course/' . $course['course_id'] . '/upload') ?>" class="btn btn-sm btn-primary">
                                        <i class="mdi mdi-upload me-1"></i>Upload Material
                                    </a>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">
                                        <strong>Description:</strong> <?= esc($course['description'] ?? 'No description available.') ?>
                                    </p>

                                    <h6>Course Materials</h6>
                                    <?php if (empty($course['materials'])): ?>
                                        <p class="text-muted">No materials uploaded for this course.</p>
                                    <?php else: ?>
                                        <div class="list-group">
                                            <?php foreach ($course['materials'] as $material): ?>
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <i class="mdi mdi-file-document-outline me-2"></i>
                                                        <?= esc($material['file_name']) ?>
                                                        <small class="text-muted d-block">
                                                            Uploaded: <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                    <div>
                                                        <a href="<?= base_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="mdi mdi-download me-1"></i>Download
                                                        </a>
                                                        <a href="<?= base_url('materials/delete/' . $material['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this material?');">
                                                            <i class="mdi mdi-delete me-1"></i>Delete
                                                        </a>
                                                    </div>
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
