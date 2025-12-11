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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form id="searchForm" class="d-flex">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search courses..." name="search_term">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="mdi mdi-magnify"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="coursesContainer">
                        <?php if (empty($enrollments)): ?>
                            <div class="alert alert-info" role="alert">
                                <i class="mdi mdi-information-outline me-1"></i>
                                No courses enrolled yet. Contact your advisor to enroll in courses.
                            </div>
                        <?php else: ?>
                            <?php foreach ($enrollments as $enrollment): ?>
                                <div class="card mb-4 course-card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <?= esc($enrollment['course_code']) ?> - <?= esc($enrollment['course_name']) ?>
                                        </h5>
                                        <?php $status = $enrollment['status'] ?? 'approved'; ?>
                                        <span class="badge bg-<?= $status === 'approved' ? 'success' : ($status === 'pending' ? 'warning' : 'danger') ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted mb-3">
                                            <strong>Description:</strong> <?= esc($enrollment['description'] ?? 'No description available.') ?>
                                        </p>

                                        <?php if ($status === 'pending'): ?>
                                            <div class="alert alert-warning mb-3">
                                                <i class="mdi mdi-timer-sand"></i> Enrollment pending teacher approval. Materials will be available once approved.
                                            </div>
                                        <?php elseif ($status === 'rejected'): ?>
                                            <div class="alert alert-danger mb-3">
                                                <i class="mdi mdi-cancel"></i> Enrollment was rejected. Contact the teacher for details.
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($status === 'approved'): ?>
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
</div>
    <script>
    // jQuery-based client-side filtering and server-side search via AJAX for student courses
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.jQuery === 'undefined') {
            return;
        }

        // Client-side filtering for enrollment cards
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.course-card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Server-side search with AJAX (on submit) - shows general courses
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            var searchTerm = $('#searchInput').val();

            $.get('<?= base_url('/courses/search') ?>', {search_term: searchTerm}, function(data) {
                $('#coursesContainer').empty();

                if (data && data.length > 0) {
                    $.each(data, function(index, course) {
                        var html = `
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">${course.course_code || ''} - ${course.course_name}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3"><strong>Description:</strong> ${course.description || 'No description available.'}</p>
                                    <div class="d-flex gap-2">
                                        <a href="<?= base_url('/courses/view/') ?>${course.course_id}" class="btn btn-primary">View Course</a>
                                    </div>
                                </div>
                            </div>`;
                        $('#coursesContainer').append(html);
                    });
                } else {
                    $('#coursesContainer').html('<div class="alert alert-info">No courses found matching your search.</div>');
                }
            });
        });
    });
    </script>

<?= $this->endSection() ?>
