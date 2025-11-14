<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/') ?>">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <!-- Common link -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/dashboard') ?>">Dashboard</a>
                </li>

                <!-- Admin links -->
                <?php if (session()->get('userRole') === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/manage-users') ?>">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/reports') ?>">Reports</a>
                    </li>
                <?php endif; ?>

                <!-- Teacher links -->
                <?php if (session()->get('userRole') === 'teacher'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/teacher/classes') ?>">My Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/teacher/materials') ?>">Materials</a>
                    </li>
                <?php endif; ?>

                <!-- Student links -->
                <?php if (session()->get('userRole') === 'student'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/student/courses') ?>">My Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/student/grades') ?>">My Grades</a>
                    </li>
                <?php endif; ?>

                <!-- Logout -->
                <?php if (session()->get('isAuthenticated')): ?>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="<?= base_url('/logout') ?>">Logout</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
