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

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-1">Create New Course</h2>
                    <p class="text-muted mb-0">Add a new course to the system for students to enroll in.</p>
                </div>
                <a href="<?= base_url('/teacher/get-courses') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Courses
                </a>
            </div>
        </div>
    </div>

    <!-- Create Course Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Course Information</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/teacher/store-course') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="course_name" name="course_name"
                                       value="<?= old('course_name') ?>" required>
                                <div class="invalid-feedback">
                                    Please provide a course name.
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="course_code" class="form-label">Course Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="course_code" name="course_code"
                                       value="<?= old('course_code') ?>" required>
                                <div class="invalid-feedback">
                                    Please provide a course code.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"
                                      placeholder="Describe what this course covers..."><?= old('description') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="units" class="form-label">Units</label>
                                <input type="number" class="form-control" id="units" name="units"
                                       value="<?= old('units', 3) ?>" min="1" max="6">
                                <div class="form-text">Number of credit units for this course (1-6).</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" id="semester" name="semester">
                                    <option value="">Select Semester</option>
                                    <option value="1st Semester" <?= old('semester') === '1st Semester' ? 'selected' : '' ?>>1st Semester</option>
                                    <option value="2nd Semester" <?= old('semester') === '2nd Semester' ? 'selected' : '' ?>>2nd Semester</option>
                                    <option value="Summer" <?= old('semester') === 'Summer' ? 'selected' : '' ?>>Summer</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="schedule" class="form-label">Schedule</label>
                                <input type="text" class="form-control" id="schedule" name="schedule"
                                       value="<?= old('schedule') ?>" placeholder="e.g., MWF 9:00-10:30 AM">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="room" class="form-label">Room</label>
                                <input type="text" class="form-control" id="room" name="room"
                                       value="<?= old('room') ?>" placeholder="e.g., Room 101">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('/teacher/get-courses') ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>Course Creation Guidelines
                    </h6>
                    <ul class="mb-0 small">
                        <li>Course Name should be descriptive and clear</li>
                        <li>Course Code should be unique (e.g., CS101, MATH201)</li>
                        <li>Description helps students understand what they'll learn</li>
                        <li>Units typically range from 1-6 depending on course complexity</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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

    // Auto-generate course code suggestion based on course name
    const courseNameInput = document.getElementById('course_name');
    const courseCodeInput = document.getElementById('course_code');

    courseNameInput.addEventListener('input', function() {
        if (courseCodeInput.value === '') {
            const name = this.value.trim();
            if (name.length > 0) {
                // Generate a simple code from the first few words
                const words = name.split(' ');
                let code = '';
                for (let i = 0; i < Math.min(words.length, 2); i++) {
                    code += words[i].substring(0, 3).toUpperCase();
                }
                // Add a number if needed
                code += '101';
                courseCodeInput.placeholder = code;
            } else {
                courseCodeInput.placeholder = 'e.g., CS101';
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
