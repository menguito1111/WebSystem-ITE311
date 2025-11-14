<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Student</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Student Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-3">Welcome back, <?= esc($userName) ?>!</h3>
                            <p class="text-muted mb-4">Here's what's happening with your courses today.</p>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body text-center">
                                            <i class="mdi mdi-book-open-variant text-primary" style="font-size: 2rem;"></i>
                                            <h4 class="mt-2">My Courses</h4>
                                            <p class="text-muted">View your enrolled courses</p>
                                            <a href="<?= base_url('student/courses') ?>" class="btn btn-primary btn-sm">View Courses</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body text-center">
                                            <i class="mdi mdi-chart-line text-success" style="font-size: 2rem;"></i>
                                            <h4 class="mt-2">My Grades</h4>
                                            <p class="text-muted">Check your academic progress</p>
                                            <a href="<?= base_url('student/grades') ?>" class="btn btn-success btn-sm">View Grades</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body text-center">
                                            <i class="mdi mdi-file-document text-warning" style="font-size: 2rem;"></i>
                                            <h4 class="mt-2">Assignments</h4>
                                            <p class="text-muted">Track your assignments</p>
                                            <a href="<?= base_url('student/assignments') ?>" class="btn btn-warning btn-sm">View Assignments</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card border">
                                <div class="card-body">
                                    <h5 class="card-title">Quick Actions</h5>
                                    <div class="d-grid gap-2">
                                        <a href="<?= base_url('announcements') ?>" class="btn btn-outline-primary">
                                            <i class="mdi mdi-bullhorn me-1"></i> View Announcements
                                        </a>
                                        <a href="<?= base_url('student/courses') ?>" class="btn btn-outline-success">
                                            <i class="mdi mdi-book-open me-1"></i> My Courses
                                        </a>
                                        <a href="<?= base_url('student/grades') ?>" class="btn btn-outline-info">
                                            <i class="mdi mdi-chart-line me-1"></i> My Grades
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
