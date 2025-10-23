<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-2">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-3">
            <h1 class="mb-1 section-header d-inline-block">Sign In</h1>
            <div class="text-muted">Access your account</div>
        </div>

        <?php if (session()->getFlashdata('register_success')): ?>
            <div class="alert alert-success" role="alert">
                <?= esc(session()->getFlashdata('register_success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('login_error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc(session()->getFlashdata('login_error')) ?>
            </div>
        <?php endif; ?>

        <div class="card-lite">
            <form action="<?= base_url('login') ?>" method="post" class="p-2">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= esc(old('email')) ?>">
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label mb-0">Password</label>
                        <a class="small" href="#">Forgot password?</a>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>

        <p class="text-center mt-3 text-muted small">Don't have an account? <a href="<?= base_url('register') ?>">Register</a></p>
    </div>
</div>
<?= $this->endSection() ?>