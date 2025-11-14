<?= $this->extend('template') ?>

<?= $this->section('title') ?>Announcements<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-bullhorn me-3 fs-2"></i>
                    <div>
                        <h2 class="mb-1">Announcements</h2>
                        <p class="mb-0 opacity-75">Stay updated with the latest news and announcements</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="row">
        <div class="col-12">
            <?php if (empty($announcements)): ?>
                <!-- No announcements message -->
                <div class="text-center py-5">
                    <div class="bg-light rounded-3 p-5">
                        <i class="fas fa-bullhorn text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-muted">No Announcements Yet</h4>
                        <p class="text-muted">Check back later for important updates and news.</p>
                    </div>
                </div>
            <?php else: ?>
                <!-- Announcements Cards -->
                <?php foreach ($announcements as $announcement): ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-primary mb-0 fw-bold">
                                    <?= esc($announcement['title']) ?>
                                </h5>
                                <small class="text-muted bg-light px-2 py-1 rounded">
                                    <i class="fas fa-clock me-1"></i>
                                    Posted on: <?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])) ?>
                                </small>
                            </div>
                            <div class="card-text">
                                <p class="mb-0 lh-lg">
                                    <?= nl2br(esc($announcement['content'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
    
    .bg-primary {
        background: linear-gradient(135deg, #007bff, #0056b3) !important;
    }
    
    .text-primary {
        color: #007bff !important;
    }
</style>
<?= $this->endSection() ?>
