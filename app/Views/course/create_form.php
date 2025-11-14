<?= $this->extend('template') ?>
<?= $this->section('title') ?>Create New Course<?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Create New Course
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?= esc(session()->getFlashdata('error')) ?>
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

                    <!-- Course Creation Form -->
                    <form action="<?= base_url('/teacher/store-course') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="course_name" class="form-label">
                                <i class="fas fa-book me-1"></i>Course Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?= session('errors.course_name') ? 'is-invalid' : '' ?>" 
                                   id="course_name" 
                                   name="course_name" 
                                   value="<?= old('course_name') ?>" 
                                   placeholder="Enter course name"
                                   required>
                            <?php if (session('errors.course_name')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.course_name')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="course_code" class="form-label">
                                <i class="fas fa-code me-1"></i>Course Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control <?= session('errors.course_code') ? 'is-invalid' : '' ?>" 
                                   id="course_code" 
                                   name="course_code" 
                                   value="<?= old('course_code') ?>" 
                                   placeholder="e.g., CS101, MATH201"
                                   required>
                            <?php if (session('errors.course_code')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.course_code')) ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text">Course code must be unique and 3-50 characters long.</div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Course Description
                            </label>
                            <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      placeholder="Enter course description (optional)"><?= old('description') ?></textarea>
                            <?php if (session('errors.description')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.description')) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="units" class="form-label">
                                <i class="fas fa-hashtag me-1"></i>Credit Units
                            </label>
                            <input type="number" 
                                   class="form-control <?= session('errors.units') ? 'is-invalid' : '' ?>" 
                                   id="units" 
                                   name="units" 
                                   value="<?= old('units', 3) ?>" 
                                   min="1" 
                                   max="10"
                                   placeholder="3">
                            <?php if (session('errors.units')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.units')) ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text">Number of credit units for this course (default: 3).</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('/dashboard') ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for form enhancement -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Form validation
    const form = document.querySelector('form');
    const courseNameInput = document.getElementById('course_name');
    const courseCodeInput = document.getElementById('course_code');

    // Real-time validation for course code
    courseCodeInput.addEventListener('input', function() {
        const value = this.value.toUpperCase();
        this.value = value;
        
        // Check if course code is valid format
        if (value.length > 0 && value.length < 3) {
            this.setCustomValidity('Course code must be at least 3 characters long');
        } else if (value.length > 50) {
            this.setCustomValidity('Course code must be 50 characters or less');
        } else {
            this.setCustomValidity('');
        }
    });

    // Form submission validation
    form.addEventListener('submit', function(e) {
        const courseName = courseNameInput.value.trim();
        const courseCode = courseCodeInput.value.trim();

        if (!courseName) {
            e.preventDefault();
            alert('Please enter a course name.');
            courseNameInput.focus();
            return false;
        }

        if (!courseCode) {
            e.preventDefault();
            alert('Please enter a course code.');
            courseCodeInput.focus();
            return false;
        }

        if (courseCode.length < 3) {
            e.preventDefault();
            alert('Course code must be at least 3 characters long.');
            courseCodeInput.focus();
            return false;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Creating Course...';
        submitBtn.disabled = true;
    });
});
</script>

<?= $this->endSection() ?>
