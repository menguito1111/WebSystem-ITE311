<?= $this->extend('template') ?>
<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><?= esc($title) ?></h2>
            
            <div class="alert alert-info">
                <h5 class="alert-heading">⚙️ System Settings</h5>
                <p class="mb-0">Admin-only access confirmed. Configure system-wide settings.</p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">General Settings</h5>
                            <p class="card-text">Configure basic system settings.</p>
                            <a href="#" class="btn btn-primary">Configure</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Security Settings</h5>
                            <p class="card-text">Manage security policies and access controls.</p>
                            <a href="#" class="btn btn-primary">Security</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="<?= base_url('/dashboard') ?>" class="btn btn-outline-secondary">← Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
