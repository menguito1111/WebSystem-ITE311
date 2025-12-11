<?= $this->extend('template') ?>

<?= $this->section('title') ?>Course Management<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-graduation-cap me-3 fs-2"></i>
                    <div>
                        <h2 class="mb-1">Course Management</h2>
                        <p class="mb-0 opacity-75">Manage and monitor all courses in the system</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-book text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-primary"><?= $totalCourses ?></h4>
                            <p class="text-muted mb-0">Total Courses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-success"><?= $activeCourses ?></h4>
                            <p class="text-muted mb-0">Active Courses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="courseSearch" class="form-control border-0 bg-light"
                                       placeholder="Search by course title, code, or teacher..." onkeyup="filterCourses()">
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-outline-primary" onclick="resetSearch()">
                                <i class="fas fa-times me-1"></i>Clear Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">All Courses</h5>
                    <button class="btn btn-primary" onclick="openCreateModal()">
                        <i class="fas fa-plus me-1"></i>Create Course
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="coursesTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 fw-bold px-4 py-3">Course Code</th>
                                    <th class="border-0 fw-bold px-4 py-3">Course Title</th>
                                    <th class="border-0 fw-bold px-4 py-3">Description</th>
                                    <th class="border-0 fw-bold px-4 py-3">School Year</th>
                                    <th class="border-0 fw-bold px-4 py-3">Semester</th>
                                    <th class="border-0 fw-bold px-4 py-3">Schedule</th>
                                    <th class="border-0 fw-bold px-4 py-3">Teacher</th>
                                    <th class="border-0 fw-bold px-4 py-3">Status</th>
                                    <th class="border-0 fw-bold px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                <tr class="course-row"
                                    data-course-id="<?= $course['course_id'] ?>"
                                    data-course-code="<?= esc($course['course_code']) ?>"
                                    data-course-name="<?= esc($course['course_name']) ?>"
                                    data-description="<?= esc($course['description']) ?>"
                                    data-school-year="<?= esc($course['school_year'] ?? '') ?>"
                                    data-semester="<?= esc($course['semester'] ?? '') ?>"
                                    data-schedule="<?= esc($course['schedule'] ?? '') ?>"
                                    data-teacher-id="<?= $course['teacher_id'] ?? '' ?>"
                                    data-start-date="<?= $course['start_date'] ?? '' ?>"
                                    data-end-date="<?= $course['end_date'] ?? '' ?>"
                                    data-status="<?= $course['status'] ?>">
                                    <td class="px-4 py-3 fw-bold text-primary"><?= esc($course['course_code']) ?></td>
                                    <td class="px-4 py-3 fw-semibold"><?= esc($course['course_name']) ?></td>
                                    <td class="px-4 py-3 text-muted">
                                        <?= strlen($course['description']) > 50 ? esc(substr($course['description'], 0, 50)) . '...' : esc($course['description']) ?>
                                    </td>
                                    <td class="px-4 py-3"><?= esc($course['school_year'] ?? '-') ?></td>
                                    <td class="px-4 py-3"><?= esc($course['semester'] ?? '-') ?></td>
                                    <td class="px-4 py-3"><?= esc($course['schedule'] ?? '-') ?></td>
                                    <td class="px-4 py-3">
                                        <?php if ($course['teacher_name']): ?>
                                            <span class="badge bg-info text-white"><?= esc($course['teacher_name']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">Not assigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3">
                                        <select class="form-select form-select-sm status-select"
                                                data-course-id="<?= $course['course_id'] ?>"
                                                onchange="updateCourseStatus(<?= $course['course_id'] ?>, this.value)">
                                            <option value="Active" <?= $course['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                                            <option value="Inactive" <?= $course['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary"
                                                onclick="openEditModal(<?= $course['course_id'] ?>)">
                                            <i class="fas fa-edit me-1"></i>Edit Details
                                        </button>
                                        <a class="btn btn-sm btn-outline-secondary ms-1"
                                           href="<?= base_url('/admin/manage-course/' . $course['course_id']) ?>">
                                            <i class="fas fa-cog me-1"></i>Manage
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editCourseModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Course Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCourseForm">
                <div class="modal-body">
                    <input type="hidden" id="editCourseId" name="course_id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editCourseCode" class="form-label fw-bold">Course Code</label>
                            <input type="text" class="form-control" id="editCourseCode" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="editCourseName" class="form-label fw-bold">Course Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editCourseName" name="course_name" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editSchoolYear" class="form-label fw-bold">School Year</label>
                            <input type="text" class="form-control" id="editSchoolYear" name="school_year" placeholder="e.g., 2024-2025">
                        </div>
                        <div class="col-md-6">
                            <label for="editSemester" class="form-label fw-bold">Semester</label>
                            <select class="form-select" id="editSemester" name="semester">
                                <option value="">Select Semester</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editStartDate" class="form-label fw-bold">Start Date</label>
                            <input type="date" class="form-control" id="editStartDate" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="editEndDate" class="form-label fw-bold">End Date</label>
                            <input type="date" class="form-control" id="editEndDate" name="end_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editTeacher" class="form-label fw-bold">Teacher</label>
                            <select class="form-select" id="editTeacher" name="teacher_id">
                                <option value="">Select Teacher</option>
                                <?php foreach ($teachers as $teacher): ?>
                                <option value="<?= $teacher['id'] ?>"><?= esc($teacher['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editSchedule" class="form-label fw-bold">Schedule</label>
                            <input type="text" class="form-control" id="editSchedule" name="schedule"
                                   placeholder="e.g., Mon/Wed 9:00-10:30 AM">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editDescription" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editStatus" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="editStatus" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Course Modal -->
<div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="createCourseModalLabel">
                    <i class="fas fa-plus me-2"></i>Create New Course
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCourseForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="createCourseCode" class="form-label fw-bold">Course Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="createCourseCode" name="course_code" required
                                   placeholder="e.g., CS101, MATH201">
                            <div class="invalid-feedback">
                                Course code is required and must be unique.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="createCourseName" class="form-label fw-bold">Course Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="createCourseName" name="course_name" required
                                   placeholder="e.g., Introduction to Programming">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="createSchoolYear" class="form-label fw-bold">School Year</label>
                            <input type="text" class="form-control" id="createSchoolYear" name="school_year"
                                   placeholder="e.g., 2024-2025">
                        </div>
                        <div class="col-md-6">
                            <label for="createSemester" class="form-label fw-bold">Semester</label>
                            <select class="form-select" id="createSemester" name="semester">
                                <option value="">Select Semester</option>
                                <option value="1st Semester">1st Semester</option>
                                <option value="2nd Semester">2nd Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="createStartDate" class="form-label fw-bold">Start Date</label>
                            <input type="date" class="form-control" id="createStartDate" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="createEndDate" class="form-label fw-bold">End Date</label>
                            <input type="date" class="form-control" id="createEndDate" name="end_date">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="createTeacher" class="form-label fw-bold">Teacher</label>
                            <select class="form-select" id="createTeacher" name="teacher_id">
                                <option value="">Select Teacher (Optional)</option>
                                <?php foreach ($teachers as $teacher): ?>
                                <option value="<?= $teacher['id'] ?>"><?= esc($teacher['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="createSchedule" class="form-label fw-bold">Schedule</label>
                            <input type="text" class="form-control" id="createSchedule" name="schedule"
                                   placeholder="e.g., Mon/Wed 9:00-10:30 AM">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="createDescription" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="createDescription" name="description" rows="3"
                                  placeholder="Course description..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="createStatus" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="createStatus" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

<!-- Font Awesome and Bootstrap JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, #0d6efd, #0056b3) !important;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .status-select {
        border: none;
        background: none;
        font-weight: 500;
    }

    .status-select:focus {
        box-shadow: none;
    }

    .badge {
        font-size: 0.75em;
    }

    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    #messageContainer .alert {
        border: none;
        border-radius: 0.375rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<script>
let currentCourseId = null;

// Filter courses based on search input
function filterCourses() {
    const searchTerm = document.getElementById('courseSearch').value.toLowerCase();
    const rows = document.querySelectorAll('.course-row');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Reset search
function resetSearch() {
    document.getElementById('courseSearch').value = '';
    filterCourses();
}

// Update course status
function updateCourseStatus(courseId, status) {
    const formData = new FormData();
    formData.append('status', status);

    fetch(`<?= base_url('/admin/courses/update/') ?>${courseId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showMessage(data.success ? 'success' : 'error', data.message);
    })
    .catch(error => {
        showMessage('error', 'An error occurred while updating the course status.');
    });
}

// Open create modal
function openCreateModal() {
    // Reset form
    document.getElementById('createCourseForm').reset();

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('createCourseModal'));
    modal.show();
}

// Open edit modal
function openEditModal(courseId) {
    currentCourseId = courseId;

    // Find the course row
    const row = document.querySelector(`[data-course-id="${courseId}"]`);

    // Populate modal with course data from data attributes
    document.getElementById('editCourseId').value = row.getAttribute('data-course-id');
    document.getElementById('editCourseCode').value = row.getAttribute('data-course-code');
    document.getElementById('editCourseName').value = row.getAttribute('data-course-name');
    document.getElementById('editSchoolYear').value = row.getAttribute('data-school-year');
    document.getElementById('editSemester').value = row.getAttribute('data-semester');
    document.getElementById('editSchedule').value = row.getAttribute('data-schedule');
    document.getElementById('editDescription').value = row.getAttribute('data-description');
    document.getElementById('editTeacher').value = row.getAttribute('data-teacher-id');
    document.getElementById('editStartDate').value = row.getAttribute('data-start-date');
    document.getElementById('editEndDate').value = row.getAttribute('data-end-date');
    document.getElementById('editStatus').value = row.getAttribute('data-status');

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editCourseModal'));
    modal.show();
}

// Handle create course form submission
document.getElementById('createCourseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`<?= base_url('/admin/courses/create') ?>`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('createCourseModal')).hide();

            // Reload page to show updated data
            location.reload();
        } else {
            showMessage('error', data.message);
        }
    })
    .catch(error => {
        showMessage('error', 'An error occurred while creating the course.');
    });
});

// Handle edit form submission
document.getElementById('editCourseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`<?= base_url('/admin/courses/update/') ?>${currentCourseId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('editCourseModal')).hide();

            // Reload page to show updated data
            location.reload();
        } else {
            showMessage('error', data.message);
        }
    })
    .catch(error => {
        showMessage('error', 'An error occurred while updating the course.');
    });
});

// Show message function
function showMessage(type, message) {
    const container = document.getElementById('messageContainer');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';

    container.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas ${iconClass} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    // Auto hide after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 150);
        }
    }, 5000);
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any Bootstrap components if needed
});
</script>
<?= $this->endSection() ?>
