<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-upload me-2"></i>
                        Upload Material for: <?= esc($course['title']) ?>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('materials/upload/' . $course_id) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="material_file" class="form-label">
                                <i class="fas fa-file me-1"></i>
                                Select File
                            </label>
                            <input type="file" class="form-control" id="material_file" name="material_file" required>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Allowed file types: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, PNG<br>
                                Maximum file size: 10MB
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Course Information</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title"><?= esc($course['title']) ?></h6>
                                    <?php if (!empty($course['description'])): ?>
                                        <p class="card-text text-muted"><?= esc($course['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i>
                                Back to Courses
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i>
                                Upload Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// File input validation
document.getElementById('material_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 10 * 1024 * 1024; // 10MB
    const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 
                         'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                         'text/plain', 'image/jpeg', 'image/jpg', 'image/png'];
    
    if (file) {
        if (file.size > maxSize) {
            alert('File size must be less than 10MB');
            e.target.value = '';
            return;
        }
        
        if (!allowedTypes.includes(file.type)) {
            alert('File type not allowed. Please select a PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, JPEG, or PNG file.');
            e.target.value = '';
            return;
        }
    }
});
</script>
<?= $this->endSection() ?>
