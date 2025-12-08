<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Teacher</a></li>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">All My Assignments</h5>
                        <a href="<?= base_url('teacher/create-assignment') ?>" class="btn btn-primary">
                            <i class="mdi mdi-plus"></i> Create Assignment
                        </a>
                    </div>

                    <?php if (empty($assignments)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="mdi mdi-information-outline me-1" style="font-size: 48px;"></i>
                            <p class="mt-2">You haven't created any assignments yet.</p>
                            <a href="<?= base_url('teacher/create-assignment') ?>" class="btn btn-primary">Create Your First Assignment</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Assignment</th>
                                        <th>Course</th>
                                        <th>Due Date</th>
                                        <th>Submissions</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($assignments as $assignment): ?>
                                        <?php
                                        $courseModel = new \App\Models\CourseModel();
                                        $course = $courseModel->find($assignment['course_id']);
                                        $submissionModel = new \App\Models\AssignmentSubmissionModel();
                                        $submissionCount = count($submissionModel->getSubmissionsByAssignment($assignment['assignment_id']));
                                        ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($assignment['title']) ?></strong>
                                            </td>
                                            <td>
                                                <?php if ($course): ?>
                                                    <a href="<?= base_url('teacher/assignments/' . $course['course_id']) ?>" class="text-decoration-none">
                                                        <?= esc($course['course_name']) ?> (<?= esc($course['course_code']) ?>)
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($assignment['due_date']): ?>
                                                    <?= date('M j, Y g:i A', strtotime($assignment['due_date'])) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No due date</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= $submissionCount ?></span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('teacher/assignment-submissions/' . $assignment['assignment_id']) ?>" class="btn btn-sm btn-outline-primary">
                                                    View Submissions
                                                </a>
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
