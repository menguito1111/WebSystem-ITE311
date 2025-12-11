<?= $this->extend('template') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0"><?= esc($title) ?></h2>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</button>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Year Level</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users) && is_array($users)): ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= esc($u['id'] ?? $u['user_id'] ?? '') ?></td>
                                    <td><?= esc($u['name'] ?? '') ?></td>
                                    <td><?= esc($u['email'] ?? '') ?></td>
                                    <td>
                                        <?php if (($u['role'] ?? '') === 'student'): ?>
                                            <span class="badge bg-info text-dark"><?= esc($u['year_level'] ?? 'N/A') ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (($u['id'] ?? $u['user_id'] ?? 0) == 1): ?>
                                            <span class="badge bg-primary">Admin</span>
                                        <?php else: ?>
                                            <select class="form-select form-select-sm role-select" data-user-id="<?= esc($u['id'] ?? $u['user_id'] ?? '') ?>">
                                                <option value="student" <?= (($u['role'] ?? '') === 'student') ? 'selected' : '' ?>>Student</option>
                                                <option value="teacher" <?= (($u['role'] ?? '') === 'teacher') ? 'selected' : '' ?>>Teacher</option>
                                                
                                                <option value="admin" <?= (($u['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                                                                                            <option value="librarian" <?= (($u['role'] ?? '') === 'librarian') ? 'selected' : '' ?>>Librarian</option>
                                            </select>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $status = $u['status'] ?? 'active'; ?>
                                        <span class="badge bg-<?= $status === 'active' ? 'success' : 'secondary' ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($u['created_at'] ?? '') ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($u['deleted_at'])): ?>
                                            <span class="badge bg-danger">Deleted</span>
                                            <button class="btn btn-sm btn-outline-secondary" disabled>Edit</button>
                                        <?php else: ?>
                                            <?php if (($u['id'] ?? $u['user_id'] ?? 0) != 1): ?>
                                                <a href="<?= base_url('/admin/users/edit/' . ($u['id'] ?? $u['user_id'] ?? '')) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-secondary" disabled title="Cannot edit main admin">Edit</button>
                                            <?php endif; ?>
                                            <?php if (($u['id'] ?? $u['user_id'] ?? 0) != 1): ?>
                                                <button data-user-id="<?= esc($u['id'] ?? $u['user_id'] ?? '') ?>" class="btn btn-sm btn-outline-<?= (($u['status'] ?? 'active') === 'active') ? 'warning' : 'success' ?> btn-toggle-status">
                                                    <?= (($u['status'] ?? 'active') === 'active') ? 'Deactivate' : 'Activate' ?>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-secondary" disabled title="Cannot deactivate main admin">Protected</button>
                                            <?php endif; ?>
                                            <?php if (($u['role'] ?? '') !== 'admin' || ($u['id'] ?? $u['user_id'] ?? 0) != 1): ?>
                                                <button data-id="<?= esc($u['id'] ?? $u['user_id'] ?? '') ?>" class="btn btn-sm btn-outline-danger btn-delete-user">Delete</button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline-secondary" disabled title="Cannot delete admin user">Delete</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="<?= base_url('/dashboard') ?>" class="btn btn-outline-secondary">← Back to Dashboard</a>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>
                        <select class="form-control" id="userRole" name="role" required>
                            <option value="">Select Role</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="yearLevelGroup">
                        <label for="yearLevel" class="form-label">Year Level</label>
                        <select class="form-control" id="yearLevel" name="year_level">
                            <option value="">Select Year Level</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                            <option value="5th Year">5th Year</option>
                        </select>
                        <div class="form-text">Only required for students.</div>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <small><strong>Note:</strong> The default password for new users is: <code>password123</code></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete user buttons
    document.querySelectorAll('.btn-delete-user').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            if (!id) return;

            if (!confirm('Are you sure you want to delete this user?')) return;

            // Send POST request to delete endpoint
            fetch('<?= base_url('/admin/users/delete') ?>/' + id, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            }).then(function(res) { return res.json(); }).then(function(data) {
                if (data && data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to delete user');
                }
            }).catch(function() {
                alert('Failed to delete user');
            });
        });
    });

    // Handle add user form submission
    const addUserForm = document.getElementById('addUserForm');
    if (addUserForm) {
        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('<?= base_url('/admin/users/create') ?>', {
                method: 'POST',
                body: formData
            }).then(function(res) { return res.json(); }).then(function(data) {
                if (data && data.success) {
                    alert(data.message || 'User created successfully');
                    // Close modal and reset form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
                    modal.hide();
                    addUserForm.reset();
                    // Reload page to show new user
                    location.reload();
                } else {
                    alert(data.message || 'Failed to create user');
                }
            }).catch(function() {
                alert('Failed to create user');
            });
        });
    }

    const roleSelect = document.getElementById('userRole');
    const yearLevelGroup = document.getElementById('yearLevelGroup');

    function toggleYearLevel() {
        if (!roleSelect || !yearLevelGroup) return;
        if (roleSelect.value === 'student') {
            yearLevelGroup.classList.remove('d-none');
        } else {
            yearLevelGroup.classList.add('d-none');
            yearLevelGroup.querySelector('select').value = '';
        }
    }

    if (roleSelect) {
        roleSelect.addEventListener('change', toggleYearLevel);
        toggleYearLevel();
    }

    // Handle role change
    document.querySelectorAll('.role-select').forEach(function(select) {
        select.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const newRole = this.value;

            if (!userId || !newRole) return;

            if (!confirm('Are you sure you want to change this user\'s role to ' + newRole + '?')) {
                // Reset to previous value
                location.reload();
                return;
            }

            const formData = new FormData();
            formData.append('role', newRole);

            fetch('<?= base_url('/admin/users/change-role') ?>/' + userId, {
                method: 'POST',
                body: formData
            }).then(function(res) { return res.json(); }).then(function(data) {
                if (data && data.success) {
                    alert(data.message || 'Role updated successfully');
                    // Update the display
                    location.reload();
                } else {
                    alert(data.message || 'Failed to update role');
                    location.reload();
                }
            }).catch(function() {
                alert('Failed to update role');
                location.reload();
            });
        });
    });

    // Handle status toggle
    document.querySelectorAll('.btn-toggle-status').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const currentText = this.textContent.trim();

            if (!userId) return;

            const action = currentText.toLowerCase();
            if (!confirm('Are you sure you want to ' + action + ' this user?')) return;

            fetch('<?= base_url('/admin/users/change-status') ?>/' + userId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ userId: userId })
            }).then(function(res) { return res.json(); }).then(function(data) {
                if (data && data.success) {
                    alert(data.message || 'Status updated successfully');
                    location.reload();
                } else {
                    alert(data.message || 'Failed to update status');
                }
            }).catch(function() {
                alert('Failed to update status');
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
