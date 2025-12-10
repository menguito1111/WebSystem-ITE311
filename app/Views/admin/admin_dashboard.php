<?= $this->extend('template') ?>

<?= $this->section('title') ?>Admin Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-danger text-white p-4 rounded-3 shadow-sm">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-shield me-3 fs-2"></i>
                    <div>
                        <h2 class="mb-1">Admin Dashboard</h2>
                        <p class="mb-0 opacity-75">Welcome, Admin!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    <i class="fas fa-crown text-danger mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-danger mb-3">Welcome, Admin!</h3>
                    <p class="text-muted fs-5">
                        You are logged in as: <strong><?= esc($userName) ?></strong><br>
                        Email: <strong><?= esc($userEmail) ?></strong><br>
                        Role: <span class="badge bg-danger"><?= esc($userRole) ?></span>
                    </p>
                    <p class="text-muted">
                        This is your admin dashboard. Here you can manage users,
                        view system reports, and configure system settings.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="<?= base_url('/admin/manage-users') ?>" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm quick-action-card">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-users text-primary mb-3 fs-2"></i>
                                        <h6 class="card-title text-primary fw-bold mb-1">Manage Users</h6>
                                        <p class="card-text text-muted small">Add, edit, and manage system users</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('/admin/course-management') ?>" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm quick-action-card">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-graduation-cap text-success mb-3 fs-2"></i>
                                        <h6 class="card-title text-success fw-bold mb-1">Course Management</h6>
                                        <p class="card-text text-muted small">Manage courses, teachers, and schedules</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('/admin/reports') ?>" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm quick-action-card">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-chart-bar text-info mb-3 fs-2"></i>
                                        <h6 class="card-title text-info fw-bold mb-1">Reports</h6>
                                        <p class="card-text text-muted small">View system reports and analytics</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= base_url('/admin/settings') ?>" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm quick-action-card">
                                    <div class="card-body text-center p-4">
                                        <i class="fas fa-cog text-warning mb-3 fs-2"></i>
                                        <h6 class="card-title text-warning fw-bold mb-1">Settings</h6>
                                        <p class="card-text text-muted small">Configure system settings</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Search (Admin) -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Search Courses</h5>
                    <p class="text-muted">Quickly search all courses in the system.</p>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form id="adminSearchForm" class="d-flex">
                                <div class="input-group">
                                    <input type="text" id="adminSearchInput" class="form-control" placeholder="Search courses..." name="search_term">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="adminCoursesContainer" class="row"></div>
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
    
    .bg-danger {
        background: linear-gradient(135deg, #dc3545, #c82333) !important;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.jQuery === 'undefined') return;

    $('#adminSearchForm').on('submit', function(e) {
        e.preventDefault();
        var term = $('#adminSearchInput').val();
        $.get('<?= base_url('/courses/search') ?>', {search_term: term}, function(data) {
            $('#adminCoursesContainer').empty();
            if (data && data.length > 0) {
                $.each(data, function(i, course) {
                    var html = `
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">${course.course_name}</h5>
                                    <p class="card-text text-muted">${course.description || ''}</p>
                                    <a href="<?= base_url('/teacher/course/') ?>${course.course_id}" class="btn btn-sm btn-primary">Manage</a>
                                </div>
                            </div>
                        </div>`;
                    $('#adminCoursesContainer').append(html);
                });
            } else {
                $('#adminCoursesContainer').html('<div class="col-12"><div class="alert alert-info">No courses found.</div></div>');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
