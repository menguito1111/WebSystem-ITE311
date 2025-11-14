<?= $this->extend('template') ?>

<?= $this->section('title') ?>Teacher Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-success text-white p-4 rounded-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-chalkboard-teacher me-3 fs-2"></i>
                    <div>
                        <h2 class="mb-1">Teacher Dashboard</h2>
                        <p class="mb-0 opacity-75">Welcome, Teacher!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    <i class="fas fa-graduation-cap text-success mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-success mb-3">Welcome, Teacher!</h3>
                    <p class="text-muted fs-5">
                        You are logged in as: <strong><?= esc($userName) ?></strong><br>
                        Email: <strong><?= esc($userEmail) ?></strong><br>
                        Role: <span class="badge bg-success"><?= esc($userRole) ?></span>
                    </p>
                    <p class="text-muted">
                        This is your teacher dashboard. Here you can manage your classes, 
                        view student grades, and access teaching materials.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .bg-success {
        background: linear-gradient(135deg, #28a745, #1e7e34) !important;
    }
    
    .text-success {
        color: #28a745 !important;
    }
</style>
<?= $this->endSection() ?>
