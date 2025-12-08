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
                        <li class="breadcrumb-item active">Submit Assignment</li>
                    </ol>
                </div>
                <h4 class="page-title">Submit Assignment</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <?= esc($assignment['title']) ?>
                        <?php if ($assignment['due_date']): ?>
                            <small class="text-muted ms-2">(Due: <?= date('M j, Y g:i A', strtotime($assignment['due_date'])) ?>)</small>
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if ($assignment['instructions']): ?>
                        <div class="mb-4">
                            <h6>Instructions:</h6>
                            <div class="border p-3 bg-light">
                                <?= nl2br(esc($assignment['instructions'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($assignment['attachment']): ?>
                        <div class="mb-4">
                            <h6>Assignment File:</h6>
                            <a href="<?= base_url($assignment['attachment']) ?>" target="_blank" class="btn btn-outline-primary">
                                <i class="mdi mdi-download"></i> Download Assignment File
                            </a>
                        </div>
                    <?php endif; ?>

                    <hr>

                    <form action="<?= base_url('student/store-submission') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="assignment_id" value="<?= $assignment['assignment_id'] ?>">

                        <div class="row">
                            <div class="col-12">
                                <h6>Submission Content:</h6>
                                <p class="text-muted">You can submit either a file upload, text content, or both.</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="submission_text" class="form-label">Text Submission (Optional)</label>
                                <textarea class="form-control <?= isset($errors['submission_text']) ? 'is-invalid' : '' ?>" id="submission_text" name="submission_text" rows="6" placeholder="Enter your assignment text here..."><?= set_value('submission_text') ?></textarea>
                                <div class="invalid-feedback">
                                    <?= isset($errors['submission_text']) ? $errors['submission_text'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="submission_file" class="form-label">File Upload (Optional)</label>
                                <input type="file" class="form-control <?= isset($errors['submission_file']) ? 'is-invalid' : '' ?>" id="submission_file" name="submission_file" accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg,.gif">
                                <div class="form-text">Accepted formats: PDF, DOC, DOCX, TXT, PNG, JPG, JPEG, GIF. Max size: 5MB</div>
                                <div class="invalid-feedback">
                                    <?= isset($errors['submission_file']) ? $errors['submission_file'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <p class="text-muted">Please note: At least one of file upload or text submission is required.</p>
                                <button type="submit" class="btn btn-primary">Submit Assignment</button>
                                <a href="<?= base_url('student/assignments') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
