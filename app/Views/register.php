<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<style>
    /* Same style as login for consistent look */
    body {
        background: linear-gradient(135deg, #1a1a1a, #0d3b24);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .auth-wrapper {
        min-height: calc(100vh - 56px); /* keeps space for navbar */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .auth-card {
        backdrop-filter: blur(12px);
        background: rgba(0, 0, 0, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        transition: transform 0.3s ease;
        max-width: 500px;
        width: 100%;
    }

    .auth-card:hover {
        transform: translateY(-4px);
    }

    .form-control {
        background-color: rgba(255, 255, 255, 0.1) !important;
        border: none !important;
        color: #ffffff !important;
        border-radius: 10px;
    }

    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 2px #28a745;
    }

    .btn-custom {
        background: linear-gradient(90deg, #28a745, #4caf50);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(90deg, #4caf50, #28a745);
        transform: scale(1.02);
    }

    .auth-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #4caf50;
        text-align: center;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
    }

    .link-custom {
        color: #ffc107;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .link-custom:hover {
        color: #ffda6a;
        text-decoration: underline;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <h2 class="auth-title">📝 Create Account</h2>

        <?php if (session()->getFlashdata('register_error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= esc(session()->getFlashdata('register_error')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-floating mb-3">
                <input 
                    type="text" 
                    class="form-control" 
                    id="name" 
                    name="name" 
                    placeholder="Your Name"
                    required 
                    value="<?= esc(old('name')) ?>">
                <label for="name" class="text-light">Name</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="name@example.com"
                    required 
                    value="<?= esc(old('email')) ?>">
                <label for="email" class="text-light">Email address</label>
            </div>
            <div class="form-floating mb-3">
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="Password"
                    required>
                <label for="password" class="text-light">Password</label>
            </div>
            <div class="form-floating mb-4">
                <input 
                    type="password" 
                    class="form-control" 
                    id="password_confirm" 
                    name="password_confirm" 
                    placeholder="Confirm Password"
                    required>
                <label for="password_confirm" class="text-light">Confirm Password</label>
            </div>

            <button type="submit" class="btn btn-custom w-100 py-2">Create Account</button>
        </form>

        <hr class="my-4 border-light">

        <p class="text-center small mb-0">
            Already have an account? 
            <a href="<?= base_url('login') ?>" class="link-custom">Login here</a>
        </p>
    </div>
</div>

<?= $this->endSection() ?>
