<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h4 class="mb-3">Search Results for "<?= esc($searchTerm) ?>"</h4>

    <div class="row">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-1"><?= esc($course['course_name']) ?></h5>
                                <span class="badge bg-primary"><?= esc($course['units'] ?? 3) ?> Units</span>
                            </div>

                            <p class="card-text text-muted small mb-2">Code: <?= esc($course['course_code'] ?? '') ?></p>

                            <p class="card-text flex-grow-1">
                                <?= esc(substr($course['description'] ?? 'No description available', 0, 120)) ?>
                                <?= strlen($course['description'] ?? '') > 120 ? '...' : '' ?>
                            </p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted"><i class="fas fa-users me-1"></i><?= esc($course['enrollment_count'] ?? '') ?> enrolled</small>
                                    <small class="text-muted"><i class="fas fa-calendar me-1"></i><?= esc($course['semester'] ?? 'N/A') ?></small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('/teacher/course/' . ($course['course_id'] ?? '')) ?>" class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-cog me-1"></i>Manage
                                    </a>
                                    <a href="#" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No courses found matching your search.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
