<?= $this->extend('template') ?>
<?= $this->section('title') ?>Create Announcement<?= $this->endSection() ?>
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

    <!-- Validation Errors -->
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                <?php foreach ($errors as $field => $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-bullhorn me-2"></i>Create New Announcement
                    </h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/announcements/store') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <i class="fas fa-heading me-1"></i>Title <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?= (isset($errors['title'])) ? 'is-invalid' : '' ?>"
                                   id="title"
                                   name="title"
                                   value="<?= old('title') ?>"
                                   placeholder="Enter announcement title"
                                   required>
                            <?php if (isset($errors['title'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['title'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Content <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?= (isset($errors['content'])) ? 'is-invalid' : '' ?>"
                                      id="content"
                                      name="content"
                                      rows="8"
                                      placeholder="Enter announcement content"
                                      required><?= old('content') ?></textarea>
                            <?php if (isset($errors['content'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['content'] ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text">
                                <small class="text-muted">
                                    This announcement will be visible to all students. Make sure the content is clear and professional.
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i>Publish Announcement
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});

// Form validation enhancement
document.getElementById('content').addEventListener('input', function() {
    const content = this.value.trim();
    const minLength = 10;

    if (content.length < minLength) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});

document.getElementById('title').addEventListener('input', function() {
    const title = this.value.trim();
    const minLength = 3;

    if (title.length < minLength) {
        this.classList.add('is-invalid');
        this.classList.remove('is-valid');
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    }
});
</script>

<?= $this->endSection() ?>
