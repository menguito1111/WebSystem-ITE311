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

    <!-- Course Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h2 class="h4 mb-1"><?= esc($course['course_name']) ?></h2>
                            <p class="text-muted mb-2">Course Code: <?= esc($course['course_code']) ?></p>
                            <p class="mb-0"><?= esc($course['description'] ?? 'No description available') ?></p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary fs-6"><?= $course['units'] ?? 3 ?> Units</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Management Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="courseTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="materials-tab" data-bs-toggle="tab" data-bs-target="#materials" type="button" role="tab" aria-controls="materials" aria-selected="true">
                                <i class="fas fa-file-alt me-1"></i>Course Materials
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="false">
                                <i class="fas fa-users me-1"></i>Enrolled Students
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab" aria-controls="settings" aria-selected="false">
                                <i class="fas fa-cog me-1"></i>Course Settings
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="courseTabsContent">
                        <!-- Materials Tab -->
                        <div class="tab-pane fade show active" id="materials" role="tabpanel" aria-labelledby="materials-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Course Materials</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadMaterialModal">
                                    <i class="fas fa-plus me-1"></i>Upload Material
                                </button>
                            </div>

                            <?php if (!empty($materials)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Upload Date</th>
                                                <th>Size</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($materials as $material): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file me-2 text-muted"></i>
                                                        <?= esc($material['file_name']) ?>
                                                    </div>
                                                </td>
                                                <td><?= date('M d, Y H:i', strtotime($material['created_at'])) ?></td>
                                                <td>
                                                    <?php
                                                    $size = $material['file_size'] ?? 0;
                                                    if ($size > 1024 * 1024) {
                                                        echo round($size / (1024 * 1024), 2) . ' MB';
                                                    } elseif ($size > 1024) {
                                                        echo round($size / 1024, 2) . ' KB';
                                                    } else {
                                                        echo $size . ' B';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="<?= base_url('/materials/download/' . $material['id']) ?>" class="btn btn-sm btn-outline-primary" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-outline-danger" title="Delete" onclick="deleteMaterial(<?= $material['id'] ?>, '<?= esc($material['file_name']) ?>')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Materials Uploaded</h5>
                                    <p class="text-muted">Start by uploading your first course material.</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadMaterialModal">
                                        <i class="fas fa-plus me-1"></i>Upload First Material
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Students Tab -->
                        <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Enrolled Students</h5>
                            </div>

                            <?php if (!empty($enrolledStudents)): ?>
                                <!-- Search Bar -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
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
                                                            Showing <span id="studentCount"><?= count($enrolledStudents) ?></span> of <?= count($enrolledStudents) ?> students
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Email</th>
                                                <th>Year Level</th>
                                                <th>Enrollment Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="studentsTableBody">
                                            <?php foreach ($enrolledStudents as $student): ?>
                                            <tr class="student-row">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle bg-primary text-white me-2" style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">
                                                            <?= strtoupper(substr($student['name'], 0, 1)) ?>
                                                        </div>
                                                        <span class="student-name"><?= esc($student['name']) ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="student-email"><?= esc($student['email']) ?></span>
                                                </td>
                                                <td>
                                                    <?php if (($student['year_level'] ?? null)): ?>
                                                        <span class="badge bg-info text-dark"><?= esc($student['year_level']) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="enrollment-date"><?= date('M d, Y H:i', strtotime($student['enrollment_date'])) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">Enrolled</span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Students Enrolled</h5>
                                    <p class="text-muted">Students will appear here once they enroll in this course.</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <h5 class="mb-3">Course Settings</h5>
                            <form action="<?= base_url('/teacher/course/update/' . $course['course_id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Course Title</label>
                                        <input type="text" name="course_name" class="form-control" value="<?= esc($course['course_name']) ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">School Year</label>
                                        <input type="text" name="school_year" class="form-control" value="<?= esc($course['school_year'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Semester</label>
                                        <select name="semester" class="form-select">
                                            <option value="">Select Semester</option>
                                            <option value="1st Semester" <?= ($course['semester'] ?? '') === '1st Semester' ? 'selected' : '' ?>>1st Semester</option>
                                            <option value="2nd Semester" <?= ($course['semester'] ?? '') === '2nd Semester' ? 'selected' : '' ?>>2nd Semester</option>
                                            <option value="Summer" <?= ($course['semester'] ?? '') === 'Summer' ? 'selected' : '' ?>>Summer</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Schedule</label>
                                        <input type="text" name="schedule" class="form-control" value="<?= esc($course['schedule'] ?? '') ?>" placeholder="e.g., Mon/Wed 9:00-10:30 AM">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= esc($course['start_date'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="<?= esc($course['end_date'] ?? '') ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="3"><?= esc($course['description'] ?? '') ?></textarea>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Material Modal -->
<div class="modal fade" id="uploadMaterialModal" tabindex="-1" aria-labelledby="uploadMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadMaterialModalLabel">Upload Course Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/admin/course/' . $course['course_id'] . '/upload') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="materialFile" class="form-label">Select File</label>
                        <input type="file" class="form-control" id="materialFile" name="material" required>
                        <div class="form-text">Supported formats: PDF, DOC, DOCX, PPT, PPTX, ZIP.</div>
                    </div>
                    <div class="mb-3">
                        <label for="materialDescription" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="materialDescription" name="description" rows="3" placeholder="Brief description of the material..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Material</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Function to delete material
function deleteMaterial(materialId, fileName) {
    if (confirm('Are you sure you want to delete "' + fileName + '"? This action cannot be undone.')) {
        window.location.href = '<?= base_url('/materials/delete/') ?>' + materialId;
    }
}

// Student search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('studentSearchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const studentRows = document.querySelectorAll('.student-row');
    const studentCount = document.getElementById('studentCount');
    const totalStudents = <?= count($enrolledStudents) ?>;

    // Search functionality
    function filterStudents() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        studentRows.forEach(row => {
            const studentName = row.querySelector('.student-name').textContent.toLowerCase();
            const studentEmail = row.querySelector('.student-email').textContent.toLowerCase();

            const matches = studentName.includes(searchTerm) || studentEmail.includes(searchTerm);

            if (matches) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update counter
        studentCount.textContent = visibleCount;

        // Show/hide clear button
        if (searchTerm.length > 0) {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
        }
    }

    // Search input event listener
    searchInput.addEventListener('input', filterStudents);

    // Clear search button
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterStudents();
        searchInput.focus();
    });

    // Hide clear button initially
    clearSearchBtn.style.display = 'none';

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

<?= $this->endSection() ?>
