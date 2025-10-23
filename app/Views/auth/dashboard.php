<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-0 section-header d-inline-block">
            <?php
            switch($user_role) {
                case 'admin':
                    echo '<i class="fas fa-user-shield"></i> Admin Dashboard';
                    break;
                case 'teacher':
                    echo '<i class="fas fa-chalkboard-teacher"></i> Teacher Dashboard';
                    break;
                case 'student':
                    echo '<i class="fas fa-graduation-cap"></i> Student Dashboard';
                    break;
                default:
                    echo 'Dashboard';
            }
            ?>
        </h1>
        <p class="text-muted mb-0">Welcome back, <?= esc($user_name) ?>!</p>
    </div>
    <div>
        <span class="badge badge-soft me-2"><?= ucfirst($user_role) ?></span>
        <a class="btn btn-outline btn-sm" href="<?= site_url('logout') ?>">Logout</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<!-- CONDITIONAL CONTENT BASED ON USER ROLE -->

<?php if ($user_role === 'admin'): ?>
    <!-- ADMIN DASHBOARD CONTENT -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h3 class="mb-1"><?= esc($total_users ?? 0) ?></h3>
                <p class="text-muted mb-0">Total Users</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-user-shield fa-2x text-danger mb-2"></i>
                <h3 class="mb-1"><?= esc($total_admins ?? 0) ?></h3>
                <p class="text-muted mb-0">Admins</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-chalkboard-teacher fa-2x text-warning mb-2"></i>
                <h3 class="mb-1"><?= esc($total_teachers ?? 0) ?></h3>
                <p class="text-muted mb-0">Teachers</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-lite text-center">
                <i class="fas fa-graduation-cap fa-2x text-success mb-2"></i>
                <h3 class="mb-1"><?= esc($total_students ?? 0) ?></h3>
                <p class="text-muted mb-0">Students</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card-lite">
                <h5 class="mb-3">Recent Users</h5>
                <div class="table-responsive">
                    <table class="table table-advanced">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_users)): ?>
                                <?php foreach ($recent_users as $user): ?>
                                    <tr>
                                        <td><?= esc($user['name'] ?? 'N/A') ?></td>
                                        <td><?= esc($user['email'] ?? 'N/A') ?></td>
                                        <td>
                                            <span class="badge badge-soft">
                                                <?= ucfirst($user['role'] ?? 'student') ?>
                                            </span>
                                        </td>
                                        <td><?= date('M j, Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No recent users</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-lite">
                <h5 class="mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Add New User
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-book"></i> Manage Courses
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-chart-bar"></i> View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($user_role === 'teacher'): ?>
    <!-- TEACHER DASHBOARD CONTENT -->
    <div class="row">
        <div class="col-md-8">
            <div class="card-lite">
                <h5 class="mb-3">Create New Course</h5>
                <form id="create-course-form" method="post" action="<?= site_url('/course/create') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="course-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="course-title" name="title" placeholder="e.g., Introduction to PHP" required>
                    </div>
                    <div class="mb-3">
                        <label for="course-description" class="form-label">Description</label>
                        <textarea class="form-control" id="course-description" name="description" rows="3" placeholder="Optional description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn-create-course">
                        <i class="fas fa-plus"></i> Create Course
                    </button>
                </form>
            </div>
            
            <div class="card-lite mt-3">
                <h5 class="mb-3">My Courses</h5>
                <?php $myCourses = $my_courses ?? []; ?>
                <?php if (!empty($myCourses)): ?>
                    <ul class="list-group" id="teacher-courses-list">
                        <?php foreach ($myCourses as $course): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?= esc($course['title'] ?? ('Course #' . ($course['id'] ?? ''))) ?>
                                    <?php if (!empty($course['description'])): ?>
                                        <small class="text-muted d-block"><?= esc($course['description']) ?></small>
                                    <?php endif; ?>
                                </span>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('course/' . $course['id'] . '/materials') ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-folder-open me-1"></i>
                                        View Materials
                                    </a>
                                    <a href="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" 
                                       class="btn btn-sm btn-success">
                                        <i class="fas fa-upload me-1"></i>
                                        Upload
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">No courses yet. Create your first course above.</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-lite mb-3">
                <h5 class="mb-3">Quick Actions</h5>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-book"></i> Create Assignment
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar"></i> View Grades
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-users"></i> Manage Students
                    </a>
                </div>
            </div>
            
            <div class="card-lite">
                <h5 class="mb-3">Statistics</h5>
                <div class="text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x text-primary"></i>
                        <h4 class="mb-0"><?= esc($total_students_in_courses ?? 0) ?></h4>
                        <small class="text-muted">Students Enrolled</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery for AJAX course creation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function(){
            $('#create-course-form').on('submit', function(e){
                e.preventDefault();
                var $btn = $('#btn-create-course');
                $btn.prop('disabled', true).text('Creating...');
                var $form = $(this);
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: $form.serialize()
                }).done(function(resp){
                    var message = resp && resp.message ? resp.message : 'Course created';
                    var course = resp && resp.course ? resp.course : null;
                    var $alert = $('<div class="alert alert-success mt-3" role="alert"></div>').text(message);
                    $('.section-surface').prepend($alert);
                    if (course) {
                        var $list = $('#teacher-courses-list');
                        if ($list.length === 0) {
                            $list = $('<ul class="list-group" id="teacher-courses-list"></ul>');
                            $('.card-lite.mt-3').eq(0).find('.text-muted').remove();
                            $('.card-lite.mt-3').eq(0).append($list);
                        }
                        var $li = $('<li class="list-group-item d-flex justify-content-between align-items-center"></li>');
                        var html = '<span>' + (course.title || ('Course #' + course.id)) + (course.description ? '<small class="text-muted d-block">' + course.description + '</small>' : '') + '</span>';
                        $li.html(html);
                        $list.append($li);
                        $('#create-course-form')[0].reset();
                    }
                }).fail(function(xhr){
                    var msg = 'Failed to create course';
                    if (xhr && xhr.responseJSON && xhr.responseJSON.message) { msg = xhr.responseJSON.message; }
                    var $alert = $('<div class="alert alert-danger mt-3" role="alert"></div>').text(msg);
                    $('.section-surface').prepend($alert);
                }).always(function(){
                    $btn.prop('disabled', false).html('<i class="fas fa-plus"></i> Create Course');
                });
            });
        });
    </script>

<?php else: // STUDENT DASHBOARD ?>
    <!-- STUDENT DASHBOARD CONTENT -->
    <div class="row">
        <div class="col-md-6">
            <div class="card-lite mb-3">
                <h5 class="mb-3">Enrolled Courses</h5>
                <?php $enrolled = $enrolled_courses ?? []; ?>
                <?php if (!empty($enrolled)): ?>
                    <ul class="list-group">
                        <?php foreach ($enrolled as $course): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?= esc($course['title'] ?? ('Course #' . ($course['id'] ?? ''))) ?>
                                    <?php if (!empty($course['description'])): ?>
                                        <small class="text-muted d-block"><?= esc($course['description']) ?></small>
                                    <?php endif; ?>
                                </span>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('course/' . $course['id'] . '/materials') ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-folder-open me-1"></i>
                                        Materials
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">No enrolled courses yet.</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-lite mb-3">
                <h5 class="mb-3">Available Courses</h5>
                <?php $available = $available_courses ?? []; ?>
                <?php if (!empty($available)): ?>
                    <ul class="list-group" id="available-courses-list">
                        <?php foreach ($available as $course): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <?= esc($course['title'] ?? ('Course #' . ($course['id'] ?? ''))) ?>
                                    <?php if (!empty($course['description'])): ?>
                                        <small class="text-muted d-block"><?= esc($course['description']) ?></small>
                                    <?php endif; ?>
                                </span>
                                <button class="btn btn-sm btn-primary btn-enroll" data-course-id="<?= esc($course['id']) ?>">Enroll</button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="text-muted">No available courses.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- jQuery for AJAX enrollment -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function(){
            $(document).on('click', '.btn-enroll', function(e){
                e.preventDefault();
                var $btn = $(this);
                var courseId = $btn.data('course-id');
                $btn.prop('disabled', true).text('Enrolling...');
                $.post('<?= site_url('/course/enroll') ?>', { course_id: courseId })
                    .done(function(resp){
                        var message = resp && resp.message ? resp.message : 'Enrolled';
                        var $alert = $('<div class="alert alert-success mt-3" role="alert"></div>').text(message);
                        $('.section-surface').prepend($alert);
                        $btn.closest('li').fadeOut(200, function(){ $(this).remove(); });
                    })
                    .fail(function(xhr){
                        var msg = 'Failed to enroll';
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) { msg = xhr.responseJSON.message; }
                        var $alert = $('<div class="alert alert-danger mt-3" role="alert"></div>').text(msg);
                        $('.section-surface').prepend($alert);
                        $btn.prop('disabled', false).text('Enroll');
                    });
            });
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>