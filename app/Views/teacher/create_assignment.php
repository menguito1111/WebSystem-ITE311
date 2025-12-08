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
                        <li class="breadcrumb-item active">Create Assignment</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Assignment</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('teacher/store-assignment') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                                <select class="form-control <?= isset($errors['course_id']) ? 'is-invalid' : '' ?>" id="course_id" name="course_id" required>
                                    <option value="">Select a course</option>
                                    <?php
                                    foreach ($courses as $course) {
                                        $selected = (isset($courseId) && $courseId == $course['course_id']) ? 'selected' : '';
                                        echo "<option value=\"{$course['course_id']}\" {$selected}>{$course['course_name']} ({$course['course_code']})</option>";
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= isset($errors['course_id']) ? $errors['course_id'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label">Assignment Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= set_value('title') ?>" required>
                                <div class="invalid-feedback">
                                    <?= isset($errors['title']) ? $errors['title'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="instructions" class="form-label">Instructions / Description</label>
                                <textarea class="form-control <?= isset($errors['instructions']) ? 'is-invalid' : '' ?>" id="instructions" name="instructions" rows="5"><?= set_value('instructions') ?></textarea>
                                <div class="invalid-feedback">
                                    <?= isset($errors['instructions']) ? $errors['instructions'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="datetime-local" class="form-control <?= isset($errors['due_date']) ? 'is-invalid' : '' ?>" id="due_date" name="due_date" value="<?= set_value('due_date') ?>">
                                <div class="invalid-feedback">
                                    <?= isset($errors['due_date']) ? $errors['due_date'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="attachment" class="form-label">Attachment (optional)</label>
                                <input type="file" class="form-control <?= isset($errors['attachment']) ? 'is-invalid' : '' ?>" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.txt">
                                <div class="form-text">Accepted formats: PDF, DOC, DOCX, TXT. Max size: 2MB</div>
                                <div class="invalid-feedback">
                                    <?= isset($errors['attachment']) ? $errors['attachment'] : '' ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Create Assignment</button>
                                <a href="<?= base_url('teacher/assignments') ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
