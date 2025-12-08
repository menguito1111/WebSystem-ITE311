<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Student</a></li>
                        <li class="breadcrumb-item active">My Assignments</li>
                    </ol>
                </div>
                <h4 class="page-title">My Assignments</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Assignments</h5>
                    <p class="text-muted">Keep track of all your assignments and their due dates.</p>

                    <?php if (empty($assignments)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="mdi mdi-information-outline me-1" style="font-size: 48px;"></i>
                            <p class="mt-2">No assignments available yet. Assignments will appear here once your instructors post them.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Assignment</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Grade</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($assignments as $assignment): ?>
                                        <tr>
                                            <td><?= esc($assignment['course_name']) ?></td>
                                            <td>
                                                <strong><?= esc($assignment['title']) ?></strong>
                                                <?php if ($assignment['instructions']): ?>
                                                    <br><small class="text-muted"><?= substr(esc($assignment['instructions']), 0, 100) ?><?= strlen($assignment['instructions']) > 100 ? '...' : '' ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($assignment['due_date']): ?>
                                                    <?= date('M j, Y g:i A', strtotime($assignment['due_date'])) ?>
                                                    <?php
                                                    $now = time();
                                                    $due = strtotime($assignment['due_date']);
                                                    if ($due < $now && $assignment['submission_status'] != 'Submitted'):
                                                    ?>
                                                        <br><span class="badge bg-danger">Overdue</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No due date</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusBadge = '';
                                                switch ($assignment['submission_status']) {
                                                    case 'Graded':
                                                        $statusBadge = 'bg-success';
                                                        break;
                                                    case 'Submitted':
                                                        $statusBadge = 'bg-info';
                                                        break;
                                                    case 'Not submitted':
                                                    default:
                                                        $statusBadge = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?= $statusBadge ?>"><?= $assignment['submission_status'] ?></span>
                                            </td>
                                            <td>
                                                <?php if ($assignment['grade'] !== null): ?>
                                                    <strong><?= number_format($assignment['grade'], 2) ?></strong>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($assignment['submission_status'] == 'Graded' || $assignment['submission_status'] == 'Submitted'): ?>
                                                    <a href="<?= base_url('student/view-submission/' . $assignment['assignment_id']) ?>" class="btn btn-sm btn-outline-primary">View Submission</a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('student/submit-assignment/' . $assignment['assignment_id']) ?>" class="btn btn-sm btn-primary">Submit</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
