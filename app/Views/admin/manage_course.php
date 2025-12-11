<?= $this->extend('template') ?>

<?= $this->section('title') ?>Manage Course<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded-3 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cogs me-3 fs-2"></i>
                        <div>
                            <h2 class="mb-1">Manage Course</h2>
                            <p class="mb-0 opacity-75"><?= esc($course['course_name']) ?> (<?= esc($course['course_code']) ?>)</p>
                        </div>
                    </div>
                    <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Details -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold">Course Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Course Code:</label>
                                <p class="mb-0 text-primary fw-semibold fs-5"><?= esc($course['course_code']) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Course Name:</label>
                                <p class="mb-0"><?= esc($course['course_name']) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section (CN):</label>
                                <p class="mb-0"><?= esc($course['section_cn'] ?? 'Not specified') ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status:</label>
                                <span class="badge bg-<?= $course['status'] == 'Active' ? 'success' : 'secondary' ?> fs-6">
                                    <?= esc($course['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">School Year:</label>
                                <p class="mb-0"><?= esc($course['school_year'] ?? 'Not specified') ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Semester:</label>
                                <p class="mb-0"><?= esc($course['semester'] ?? 'Not specified') ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Schedule:</label>
                                <p class="mb-1"><?= esc($course['schedule'] ?? 'Not specified') ?></p>
                                <p class="mb-0">
                                    <small class="text-muted">
                                        <?= $course['schedule_date'] ? 'Date: ' . date('M d, Y', strtotime($course['schedule_date'])) : 'Date: Not set' ?>
                                        |
                                        <?= $course['schedule_time'] ? 'Time: ' . date('h:i A', strtotime($course['schedule_time'])) : 'Time: Not set' ?>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description:</label>
                                <p class="mb-0"><?= esc($course['description'] ?? 'No description available') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Start Date:</label>
                                <p class="mb-0"><?= $course['start_date'] ? date('M d, Y', strtotime($course['start_date'])) : 'Not specified' ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">End Date:</label>
                                <p class="mb-0"><?= $course['end_date'] ? date('M d, Y', strtotime($course['end_date'])) : 'Not specified' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Grading Period:</label>
                                <p class="mb-0"><?= esc($course['grading_period'] ?? 'Not set') ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Offer Grading Weight:</label>
                                <p class="mb-0"><?= isset($course['grading_weight']) && $course['grading_weight'] !== null ? esc($course['grading_weight']) . '%' : 'Not set' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-0">
                                <label class="form-label fw-bold">Assigned Teacher:</label>
                                <p class="mb-0">
                                    <?php if ($course['teacher_id']): ?>
                                        <?php
                                        $teacherName = '';
                                        foreach ($teachers as $teacher) {
                                            if ($teacher['id'] == $course['teacher_id']) {
                                                $teacherName = $teacher['name'];
                                                break;
                                            }
                                        }
                                        echo esc($teacherName);
                                        ?>
                                    <?php else: ?>
                                        <span class="text-muted">No teacher assigned</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Students -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Enrolled Students</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-info fs-6" id="studentCount"><?= count($enrolledStudents ?? []) ?> Students</span>
                        <?php if (!empty($availableStudents ?? [])): ?>
                        <form class="d-flex align-items-center" id="adminEnrollForm">
                            <?= csrf_field() ?>
                            <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
                            <select class="form-select form-select-sm me-2" name="student_id" required>
                                <option value="">Select student</option>
                                <?php foreach ($availableStudents as $student): ?>
                                <option value="<?= $student['id'] ?>"><?= esc($student['name']) ?> (<?= esc($student['email']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-user-plus me-1"></i>Enroll
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($enrolledStudents)): ?>
                    <!-- Search Bar -->
                    <div class="px-4 py-3 border-bottom">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text"
                                           id="studentSearchInput"
                                           class="form-control"
                                           placeholder="Search students by name or email...">
                                    <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <small class="text-muted">
                                    <i class="fas fa-users me-1"></i>
                                    Showing <span id="visibleCount"><?= count($enrolledStudents ?? []) ?></span> of <?= count($enrolledStudents ?? []) ?> students
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 fw-bold px-4 py-3">Student Name</th>
                                        <th class="border-0 fw-bold px-4 py-3">Email</th>
                                        <th class="border-0 fw-bold px-4 py-3">Enrollment Date</th>
                                        <th class="border-0 fw-bold px-4 py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    <?php foreach ($enrolledStudents as $student): ?>
                                    <tr class="student-row">
                                        <td class="px-4 py-3 fw-semibold">
                                            <span class="student-name"><?= esc($student['name']) ?></span>
                                        </td>
                                        <td class="px-4 py-3 text-muted">
                                            <span class="student-email"><?= esc($student['email']) ?></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="enrollment-date">
                                                <?= $student['enrollment_date'] ? date('M d, Y', strtotime($student['enrollment_date'])) : 'N/A' ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button class="btn btn-sm btn-outline-danger unenroll-btn"
                                                    onclick="unenrollStudent(<?= $student['id'] ?>, <?= $course['course_id'] ?>, '<?= esc($student['name']) ?>')"
                                                    data-student-id="<?= $student['id'] ?>">
                                                <i class="fas fa-user-minus me-1"></i>Unenroll
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card-body">
                        <div class="text-center py-5">
                            <i class="fas fa-users fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">No Students Enrolled</h5>
                            <p class="text-muted">No students are currently enrolled in this course.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
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
// Unenroll student from course
function unenrollStudent(studentId, courseId, studentName) {
    if (confirm(`Are you sure you want to unenroll ${studentName} from this course?`)) {
        fetch(`<?= base_url('/admin/courses/unenroll-student') ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                student_id: studentId,
                course_id: courseId
            })
        })
        .then(response => response.json())
        .then(data => {
            showMessage(data.success ? 'success' : 'error', data.message);
            if (data.success) {
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(error => {
            showMessage('error', 'An error occurred while unenrolling the student.');
        });
    }
}

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

// Student search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('studentSearchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const studentRows = document.querySelectorAll('.student-row');
    const visibleCount = document.getElementById('visibleCount');
    const studentCountBadge = document.getElementById('studentCount');
    const totalStudents = <?= count($enrolledStudents ?? []) ?>;
    const enrollForm = document.getElementById('adminEnrollForm');

    // Search functionality
    function filterStudents() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCountNum = 0;

        studentRows.forEach(row => {
            const studentName = row.querySelector('.student-name').textContent.toLowerCase();
            const studentEmail = row.querySelector('.student-email').textContent.toLowerCase();

            const matches = studentName.includes(searchTerm) || studentEmail.includes(searchTerm);

            if (matches) {
                row.style.display = '';
                visibleCountNum++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update counters
        visibleCount.textContent = visibleCountNum;
        studentCountBadge.textContent = visibleCountNum + ' Students';

        // Show/hide clear button
        if (searchTerm.length > 0) {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
        }
    }

    // Search input event listener
    if (searchInput) {
        searchInput.addEventListener('input', filterStudents);
    }

    // Clear search button
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            filterStudents();
            searchInput.focus();
        });

        // Hide clear button initially
        clearSearchBtn.style.display = 'none';
    }

    // Enroll student submit
    if (enrollForm) {
        enrollForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(enrollForm);
            fetch('<?= base_url('/admin/courses/enroll-student') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.success ? 'success' : 'error', data.message || '');
                if (data.success) {
                    setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(() => showMessage('error', 'Failed to enroll student'));
        });
    }
});
</script>
<?= $this->endSection() ?>
