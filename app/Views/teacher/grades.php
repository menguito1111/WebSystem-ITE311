<?= $this->extend('template') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Grade Students') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-0"><?= esc($title ?? 'Grade Students') ?></h2>
                <p class="text-muted mb-0">Select a course to view enrolled students and enter grades.</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php
            // Simple course selector; controller currently does not supply courses,
            // so we'll load teacher's courses here as a minimal implementation.
            $courseModel = new \App\Models\CourseModel();
            $teacherId = session()->get('userId');
            $courses = $courseModel->getCoursesByTeacher($teacherId);
            ?>

            <?php if (!empty($courses)): ?>
                <div class="mb-3">
                    <label for="courseSelect" class="form-label">Course</label>
                    <select id="courseSelect" class="form-select">
                        <option value="">-- Select a course --</option>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= esc($c['course_id']) ?>"><?= esc($c['course_name']) ?> (<?= esc($c['course_code']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="studentsContainer">
                    <p class="text-muted">Choose a course to load enrolled students and grade them.</p>
                </div>

            <?php else: ?>
                <div class="alert alert-info">
                    You have no courses yet. Create a course first to grade students.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var select = document.getElementById('courseSelect');
    if (!select) return;

    select.addEventListener('change', function() {
        var courseId = this.value;
        var container = document.getElementById('studentsContainer');
        if (!courseId) {
            container.innerHTML = '<p class="text-muted">Choose a course to load enrolled students and grade them.</p>';
            return;
        }

        // Fetch enrollments via a simple endpoint (may need implementing on server)
        fetch('<?= base_url('/teacher/course-enrollments') ?>/' + courseId)
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (!Array.isArray(data) || data.length === 0) {
                    container.innerHTML = '<div class="alert alert-info">No enrolled students for this course.</div>';
                    return;
                }

                var html = '<table class="table"><thead><tr><th>Student</th><th>Email</th><th>Grade</th><th></th></tr></thead><tbody>';
                data.forEach(function(s) {
                    html += '<tr>' +
                        '<td>' + (s.student_name || '') + '</td>' +
                        '<td>' + (s.student_email || '') + '</td>' +
                        '<td><input class="form-control form-control-sm" value="' + (s.grade || '') + '" /></td>' +
                        '<td><button class="btn btn-sm btn-primary">Save</button></td>' +
                        '</tr>';
                });
                html += '</tbody></table>';
                container.innerHTML = html;
            }).catch(function() {
                container.innerHTML = '<div class="alert alert-danger">Failed to load enrollments.</div>';
            });
    });
});
</script>

<?= $this->endSection() ?>
