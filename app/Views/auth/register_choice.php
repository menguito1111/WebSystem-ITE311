<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-6">
        <div class="text-center mb-4">
            <h1 class="mb-2 section-header d-inline-block">Join Our Learning Platform</h1>
            <p class="text-muted">Choose how you want to get started</p>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card-lite text-center h-100">
                    <div class="mb-3">
                        <i class="fas fa-graduation-cap fa-4x text-success"></i>
                    </div>
                    <h4 class="mb-2">I'm a Student</h4>
                    <p class="text-muted mb-3">I want to enroll in courses, complete assignments, and track my progress.</p>
                    <a href="<?= base_url('register/student') ?>" class="btn btn-success btn-lg w-100">
                        Register as Student
                    </a>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card-lite text-center h-100">
                    <div class="mb-3">
                        <i class="fas fa-chalkboard-teacher fa-4x text-primary"></i>
                    </div>
                    <h4 class="mb-2">I'm a Teacher</h4>
                    <p class="text-muted mb-3">I want to create courses, manage students, and track their performance.</p>
                    <a href="<?= base_url('register/teacher') ?>" class="btn btn-primary btn-lg w-100">
                        Register as Teacher
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">Already have an account? <a href="<?= base_url('login') ?>">Log in here</a></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>