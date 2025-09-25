<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-2">
    <div class="col-md-7 col-lg-6">
        <div class="text-center mb-3">
            <i class="fas fa-graduation-cap fa-3x text-success mb-2"></i>
            <h1 class="mb-1 section-header d-inline-block">Student Registration</h1>
            <div class="text-muted">Join as a learner</div>
        </div>

        <!-- Registration form here -->
        <div class="card-lite">
            <form action="<?= base_url('register/student') ?>" method="post" class="p-2">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= esc(old('name')) ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= esc(old('email')) ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Register as Student</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
