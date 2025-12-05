<?= $this->extend('template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/users/update/' . $user['id']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control <?= (isset($errors['name'])) ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name', esc($user['name'] ?? '')) ?>" required>
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control <?= (isset($errors['email'])) ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email', esc($user['email'] ?? '')) ?>" required>
                            <?php if (isset($errors['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['email'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small class="text-muted">(leave blank to keep current password)</small></label>
                            <input type="password" class="form-control <?= (isset($errors['password'])) ? 'is-invalid' : '' ?>" id="password" name="password">
                            <?php if (isset($errors['password'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['password'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control <?= (isset($errors['role'])) ? 'is-invalid' : '' ?>" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin" <?= (old('role', $user['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="teacher" <?= (old('role', $user['role'] ?? '') === 'teacher') ? 'selected' : '' ?>>Teacher</option>
                                <option value="student" <?= (old('role', $user['role'] ?? '') === 'student') ? 'selected' : '' ?>>Student</option>
                            </select>
                            <?php if (isset($errors['role'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['role'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('/admin/manage-users') ?>" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
