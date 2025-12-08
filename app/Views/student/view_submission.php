<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Student</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('student/assignments') ?>">Assignments</a></li>
                        <li class="breadcrumb-item active">My Submission</li>
                    </ol>
                </div>
                <h4 class="page-title">My Assignment Submission</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <?= esc($assignment['title']) ?>
                        <span class="float-end">
                            <?php
                            if ($submission['grade'] !== null) {
                                echo '<span class="badge bg-success">Graded</span>';
                            } elseif ($submission['submitted_at']) {
                                echo '<span class="badge bg-info">Submitted</span>';
                            }
                            ?>
                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Assignment Details:</h6>
                            <?php if ($assignment['instructions']): ?>
                                <p><strong>Instructions:</strong> <?= nl2br(esc($assignment['instructions'])) ?></p>
                            <?php endif; ?>
                            <p><strong>Submitted on:</strong> <?= date('M j, Y g:i A', strtotime($submission['submitted_at'])) ?></p>

                            <hr>

                            <h6>Your Submission:</h6>
                            <?php if ($submission['file_path']): ?>
                                <p><strong>File Uploaded:</strong></p>
                                <a href="<?= base_url($submission['file_path']) ?>" target="_blank" class="btn btn-outline-primary mb-2">
                                    <i class="mdi mdi-download"></i> Download My Submission File
                                </a>
                            <?php endif; ?>

                            <?php if ($submission['text']): ?>
                                <div class="mt-3">
                                    <strong>Text Submission:</strong>
                                    <div class="border p-3 mt-2 bg-light">
                                        <?= nl2br(esc($submission['text'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!$submission['file_path'] && !$submission['text']): ?>
                                <p class="text-muted">No submission content.</p>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="card-title mb-0">Grade & Feedback</h6>
                                </div>
                                <div class="card-body">
                                    <?php if ($submission['grade'] !== null): ?>
                                        <div class="text-center mb-3">
                                            <h2 class="text-success mb-0"><?= number_format($submission['grade'], 2) ?></h2>
                                            <small class="text-muted">Grade Points</small>
                                        </div>
                                        <?php if ($submission['feedback']): ?>
                                            <div class="mt-3">
                                                <strong>Teacher Feedback:</strong>
                                                <div class="border p-2 mt-2 bg-light rounded">
                                                    <?= nl2br(esc($submission['feedback'])) ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <p class="text-muted mt-2"><small>Graded on: <?= date('M j, Y g:i A', strtotime($submission['graded_at'])) ?></small></p>
                                    <?php else: ?>
                                        <div class="text-center text-muted">
                                            <i class="mdi mdi-clock-outline" style="font-size: 48px;"></i>
                                            <p class="mt-2">Not graded yet</p>
                                            <small>Teacher will review and grade your submission</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <a href="<?= base_url('student/assignments') ?>" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Back to Assignments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
