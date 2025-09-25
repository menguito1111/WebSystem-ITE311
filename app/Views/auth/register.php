<?php
// ============================================
// SIMPLE UPDATE: ADD ROLE DROPDOWN TO EXISTING REGISTRATION FORM
// app/Views/auth/register.php (UPDATE YOUR EXISTING FILE)
// ============================================
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-2">
    <div class="col-md-7 col-lg-6">
        <div class="text-center mb-3">
            <h1 class="mb-1 section-header d-inline-block">Create Account</h1>
            <div class="text-muted">Start your journey</div>
        </div>

        <?php if (session()->getFlashdata('register_error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc(session()->getFlashdata('register_error')) ?>
            </div>
        <?php endif; ?>

        <div class="card-lite">
            <form action="<?= base_url('register') ?>" method="post" class="p-2">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= esc(old('name')) ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= esc(old('email')) ?>">
                </div>
                
                <!-- *** ADD THIS ROLE SELECTION *** -->
                <div class="mb-3">
                    <label for="role" class="form-label">I am a:</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="">Select your role...</option>
                        <option value="student" <?= old('role') === 'student' ? 'selected' : '' ?>>
                            Student - I want to learn and take courses
                        </option>
                        <option value="teacher" <?= old('role') === 'teacher' ? 'selected' : '' ?>>
                            Teacher - I want to create and manage courses
                        </option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Account</button>
            </form>
        </div>

        <div class="text-center mt-3">
            <p class="mb-0">Already have an account? <a href="<?= base_url('login') ?>">Log in here</a></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
