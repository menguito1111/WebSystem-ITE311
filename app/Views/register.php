<?= $this->extend('template') ?>

<?= $this->section('title') ?>Register<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    body {
        background: #f8fbff; /* light blue-white background */
    }

    .auth-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px 30px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .auth-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(0, 0, 0, 0.12);
    }

    h1 {
        color: #00796b;
        font-weight: 700;
    }

    .form-label {
        color: #455a64;
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #b2dfdb;
    }

    .form-control:focus {
        border-color: #00796b;
        box-shadow: 0 0 0 0.2rem rgba(0, 121, 107, 0.25);
    }

    .btn-primary {
        background: #00796b;
        border: none;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background: #00695c;
    }

    .text-primary {
        color: #00796b !important;
    }

    .alert {
        border-radius: 10px;
    }

    @media (max-width: 576px) {
        .auth-card {
            padding: 30px 20px;
        }
    }
</style>

<div class="container py-5">
    <div class="auth-card">
        <h1 class="text-center mb-4">Create Account</h1>

        <?php if (session()->getFlashdata('register_error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc(session()->getFlashdata('register_error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    name="name" 
                    required 
                    value="<?= esc(old('name')) ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    required 
                    value="<?= esc(old('email')) ?>">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    required>
            </div>

            <div class="mb-3">
                <label for="password_confirm" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password_confirm" 
                    name="password_confirm" 
                    required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Account</button>
        </form>

        <p class="text-center mt-3 small text-muted">
            Already have an account? 
            <a href="<?= base_url('login') ?>" class="text-primary fw-semibold">Login</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
