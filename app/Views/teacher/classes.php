<?= $this->extend('template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">My Classes</h2>
                    <p class="text-muted mb-0">Manage your teaching classes and course materials.</p>
                </div>
                <a href="<?= base_url('/teacher/create-course') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Course
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Classes/Courses Grid -->
    <div class="row mb-3">
        <div class="col-md-6">
            <form id="searchForm" class="d-flex">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search courses..." name="search_term">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="coursesContainer" class="row">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-1"><?= esc($course['course_name']) ?></h5>
                                <span class="badge bg-primary"><?= $course['units'] ?? 3 ?> Units</span>
                            </div>

                            <p class="card-text text-muted small mb-2">Code: <?= esc($course['course_code']) ?></p>

                            <p class="card-text flex-grow-1">
                                <?= esc(substr($course['description'] ?? 'No description available', 0, 100)) ?>
                                <?= strlen($course['description'] ?? '') > 100 ? '...' : '' ?>
                            </p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>
                                        <?= ($enrollmentCounts[$course['course_id']] ?? 0) . ' enrolled' ?>
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?= esc($course['semester'] ?? 'N/A') ?>
                                    </small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('/teacher/course/' . $course['course_id']) ?>" class="btn btn-outline-primary btn-sm flex-fill">
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
                <div class="text-center py-5">
                    <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Classes Yet</h5>
                    <p class="text-muted">You haven't created any courses yet. Start by creating your first course.</p>
                    <a href="<?= base_url('/teacher/create-course') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Create Your First Course
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Stats -->
    <?php if (!empty($courses)): ?>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Quick Statistics</h6>
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1"><?= $courseStats['totalCourses'] ?? 0 ?></h4>
                                    <small class="text-muted">Total Courses</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-success mb-1"><?= $courseStats['totalEnrollments'] ?? 0 ?></h4>
                                    <small class="text-muted">Total Enrollments</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="text-info mb-1"><?= $courseStats['totalUnits'] ?? 0 ?></h4>
                                    <small class="text-muted">Total Units</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-warning mb-1"><?= $courseStats['activeCourses'] ?? 0 ?></h4>
                                <small class="text-muted">Active Courses</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
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
</script>

<script>
// jQuery-based client-side filtering and server-side search via AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Ensure jQuery is available
    if (typeof window.jQuery === 'undefined') {
        return;
    }

    // Client-side filtering
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('.card.h-100').filter(function() {
            $(this).closest('.col-md-6, .col-lg-4').toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Server-side search with AJAX (on submit)
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        var searchTerm = $('#searchInput').val();

        $.get('<?= base_url('/courses/search') ?>', {search_term: searchTerm}, function(data) {
            $('#coursesContainer').empty();

            if (data && data.length > 0) {
                $.each(data, function(index, course) {
                    var courseHtml = `
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 course-card">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-1">${course.course_name}</h5>
                                        <span class="badge bg-primary">${course.units || 3} Units</span>
                                    </div>
                                    <p class="card-text text-muted small mb-2">Code: ${course.course_code || ''}</p>
                                    <p class="card-text flex-grow-1">${(course.description || '').substring(0, 120)}${(course.description || '').length > 120 ? '...' : ''}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted"><i class="fas fa-users me-1"></i>${course.enrollment_count || ''} enrolled</small>
                                            <small class="text-muted"><i class="fas fa-calendar me-1"></i>${course.semester || 'N/A'}</small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="<?= base_url('/teacher/course/') ?>${course.course_id}" class="btn btn-outline-primary btn-sm flex-fill"><i class="fas fa-cog me-1"></i>Manage</a>
                                            <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-eye me-1"></i>View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#coursesContainer').append(courseHtml);
                });
            } else {
                $('#coursesContainer').html('<div class="col-12"><div class="alert alert-info">No courses found matching your search.</div></div>');
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
