<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Teacher</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('teacher/assignments') ?>">Assignments</a></li>
                        <li class="breadcrumb-item active">Submissions</li>
                    </ol>
                </div>
                <h4 class="page-title">Assignment Submissions</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Submissions for: <strong><?= esc($assignment['title']) ?></strong>
                        <?php if ($assignment['due_date']): ?>
                            (Due: <?= date('M j, Y g:i A', strtotime($assignment['due_date'])) ?>)
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Submission Date</th>
                                    <th>File/Text</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submissions as $submission): ?>
                                    <tr>
                                        <td>
                                            <strong><?= esc($submission['student_name']) ?></strong><br>
                                            <small class="text-muted"><?= esc($submission['student_email']) ?></small>
                                        </td>
                                        <td>
                                            <?php if ($submission['submission'] && $submission['submission']['submitted_at']): ?>
                                                <?= date('M j, Y g:i A', strtotime($submission['submission']['submitted_at'])) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Not submitted</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($submission['submission']): ?>
                                                <?php if ($submission['submission']['file_path']): ?>
                                                    <i class="mdi mdi-file-outline"></i> File uploaded
                                                <?php endif; ?>
                                                <?php if ($submission['submission']['text']): ?>
                                                    <i class="mdi mdi-text-box-outline"></i> Text submitted
                                                <?php endif; ?>
                                                <?php if (!$submission['submission']['file_path'] && !$submission['submission']['text']): ?>
                                                    <span class="text-muted">No content</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Not submitted</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $submission['submission'] && $submission['submission']['grade'] !== null ? 'bg-success' : ($submission['submission'] ? 'bg-info' : 'bg-secondary') ?>">
                                                <?= $submission['submission'] && $submission['submission']['grade'] !== null ? 'Graded' : ($submission['submission'] ? 'Submitted' : 'Not submitted') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($submission['submission'] && $submission['submission']['grade'] !== null): ?>
                                                <strong class="text-success"><?= number_format($submission['submission']['grade'], 2) ?></strong>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($submission['submission']): ?>
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewSubmission(<?= $submission['submission']['assignment_submission_id'] ?>)">
                                                    View & Grade
                                                </button>
                                            <?php endif; ?>
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

<!-- Grade Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Grade Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="submissionDetails">
                    <!-- Content loaded via AJAX -->
                </div>
                <hr>
                <form id="gradeForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="assignment_submission_id" id="submissionId">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="number" step="0.01" class="form-control" id="grade" name="grade" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="feedback" class="form-label">Feedback (Optional)</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitGrade()">Submit Grade</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewSubmission(submissionId) {
    fetch('<?= base_url('teacher/get-submission-details') ?>/' + submissionId)
        .then(response => response.json())
        .then(data => {
            document.getElementById('submissionId').value = submissionId;
            document.getElementById('submissionDetails').innerHTML = data.html;
            document.getElementById('grade').value = data.grade || '';
            document.getElementById('feedback').value = data.feedback || '';
            new bootstrap.Modal(document.getElementById('gradeModal')).show();
        });
}

function submitGrade() {
    const form = document.getElementById('gradeForm');
    const formData = new FormData(form);

    fetch('<?= base_url('teacher/grade-submission') ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the grade.');
    });
}
</script>

<?= $this->endSection() ?>
