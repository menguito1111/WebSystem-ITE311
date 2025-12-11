<?php
// ============================================
// STEP 5: DYNAMIC NAVIGATION BAR
// app/Views/templates/header.php (Add to existing template.php)
// ============================================
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My CI Project</title>
	<!-- Bootstrap CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery CDN -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Font Awesome for Icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<style>
		:root {
			--header-bg: #24292f;
			--header-border: #1f2328;
			--page-bg: #f6f8fa;
			--surface: #ffffff;
			--text: #24292f;
			--muted: #57606a;
			--border: #d0d7de;
			--brand: #0969da;
			--brand-hover: #0756b0;
			--accent: #2da44e;
		}
		@media (prefers-color-scheme: dark) {
			:root {
				--header-bg: #161b22;
				--header-border: #0d1117;
				--page-bg: #0d1117;
				--surface: #0e141b;
				--text: #e6edf3;
				--muted: #9ea7b3;
				--border: #30363d;
				--brand: #1f6feb;
				--brand-hover: #388bfd;
				--accent: #3fb950;
			}
		}
		* { box-sizing: border-box; }
		html, body { height: 100%; }
		body {
			background-color: var(--page-bg);
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
			color: var(--text);
			line-height: 1.5;
			min-height: 100vh;
			accent-color: var(--brand);
		}
		.org-container { max-width: 1280px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }
		.navbar { background-color: var(--header-bg); border-bottom: 1px solid var(--header-border); box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
		.navbar .navbar-brand { font-weight: 700; font-size: 1.125rem; color: #fff !important; letter-spacing: 0.2px; }
		.navbar .nav-link { color: rgba(255,255,255,0.85) !important; font-size: 0.95rem; padding: 0.5rem 0.75rem; border-bottom: 2px solid transparent; transition: color .15s ease, border-color .15s ease; }
		.navbar .nav-link:hover { color: #fff !important; border-bottom-color: rgba(255,255,255,0.6); }
		.navbar .nav-link.active { color: #fff !important; border-bottom-color: #fff; }
		.navbar .dropdown-menu { background: var(--surface); border: 1px solid var(--border); }
		.navbar .dropdown-item { color: var(--text) !important; }
		.navbar .dropdown-item:hover { background: rgba(0,0,0,0.05); }
		.main-wrapper { padding-top: 24px; padding-bottom: 48px; }
		.section-surface { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 24px; box-shadow: 0 10px 24px rgba(0,0,0,0.04), 0 2px 6px rgba(0,0,0,0.04); }
		.section-header { border-left: 4px solid var(--brand); padding-left: 12px; margin-bottom: 16px; }
		.card-lite { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
		.table-advanced { --bs-table-bg: transparent; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
		.table-advanced thead th { background: rgba(0,0,0,0.03); color: var(--muted); font-weight: 600; }
		.table-advanced tbody tr + tr td { border-top: 1px solid var(--border); }
		.table-advanced td, .table-advanced th { padding: 12px 14px; }
		.form-control, .form-select { background: var(--surface); color: var(--text); border: 1px solid var(--border); border-radius: 8px; }
		.form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(9,105,218,0.15); }
		.btn-primary { background-color: var(--brand); border-color: var(--brand); border-radius: 8px; }
		.btn-primary:hover, .btn-primary:focus { background-color: var(--brand-hover); border-color: var(--brand-hover); }
		.btn-outline { background: transparent; color: var(--brand); border: 1px solid var(--brand); border-radius: 8px; }
		.btn-outline:hover { background: rgba(9,105,218,0.08); }
		.badge-soft { background: rgba(45,164,78,0.12); color: var(--accent); border: 1px solid rgba(45,164,78,0.24); border-radius: 999px; padding: 4px 8px; font-weight: 600; }
		:focus-visible { outline: 3px solid rgba(9,105,218,0.35); outline-offset: 2px; border-radius: 6px; }
		.transition-all { transition: all .18s ease; }
	</style>
</head>
<body>

<!-- STEP 5: DYNAMIC NAVIGATION BAR -->
<nav class="navbar navbar-expand-lg sticky-top">
	<div class="container org-container">
		<a class="navbar-brand" href="<?= base_url('/') ?>">
			<i class="fas fa-graduation-cap"></i> WebSystem
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= base_url('/') ?>">
						<i class="fas fa-home"></i> Home
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">
						<i class="fas fa-info-circle"></i> About
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">
						<i class="fas fa-envelope"></i> Contact
					</a>
				</li>

				<?php
				$role = strtolower((string) session()->get('userRole'));
				$isLoggedIn = session()->get('isAuthenticated');
				?>

				<?php if ($isLoggedIn): ?>
					<!-- ROLE-SPECIFIC NAVIGATION -->

					<?php if ($role === 'admin'): ?>
						<li class="nav-item">
							<a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
								<i class="fas fa-user-shield"></i> Admin Tools
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="<?= base_url('admin/manage-users') ?>"><i class="fas fa-users"></i> Manage Users</a></li>
								<li><a class="dropdown-item" href="<?= base_url('courses/search') ?>"><i class="fas fa-book"></i> Manage Courses</a></li>
								<li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>"><i class="fas fa-cog"></i> System Settings</a></li>
							</ul>
						</li>
					<?php elseif ($role === 'teacher'): ?>
						<li class="nav-item">
							<a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="teacherDropdown" role="button" data-bs-toggle="dropdown">
								<i class="fas fa-chalkboard-teacher"></i> Teaching Tools
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="<?= base_url('teacher/create-course') ?>"><i class="fas fa-plus"></i> Create Course</a></li>
								<li><a class="dropdown-item" href="<?= base_url('teacher/materials') ?>"><i class="fas fa-file-alt"></i> Course Materials</a></li>
								<li><a class="dropdown-item" href="<?= base_url('teacher/grades') ?>"><i class="fas fa-chart-line"></i> Grade Book</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="<?= base_url('teacher/get-courses') ?>"><i class="fas fa-users"></i> My Courses</a></li>
							</ul>
						</li>
					<?php elseif ($role === 'student'): ?>
						<li class="nav-item">
							<a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url('student/courses') ?>">
								<i class="fas fa-book-open"></i> My Courses
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url('student/assignments') ?>">
								<i class="fas fa-file-alt"></i> Assignments
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="<?= base_url('student/grades') ?>">
								<i class="fas fa-chart-bar"></i> Grades
							</a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>

			<ul class="navbar-nav">
				<?php if ($isLoggedIn): ?>
					<!-- Notifications Dropdown -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-bell"></i>
							<span id="notificationBadge" class="badge bg-danger" style="display: none;"></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-end" id="notificationsList" style="min-width: 300px;">
							<li><h6 class="dropdown-header">Notifications</h6></li>
							<li><div class="text-center p-2"><small class="text-muted">Loading...</small></div></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item text-center" href="#">View All</a></li>
						</ul>
					</li>

					<!-- User Dropdown -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
							<i class="fas fa-user"></i>
							<?= session()->get('user_name') ?>
							<span class="badge badge-soft ms-1">
								<?= ucfirst($role) ?>
							</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> Profile</a></li>
							<li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
						</ul>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a class="nav-link <?= uri_string() == 'login' ? 'active' : '' ?>" href="<?= base_url('login') ?>">
							<i class="fas fa-sign-in-alt"></i> Login
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>

<div class="main-wrapper">
	<div class="container org-container">
		<?= $this->renderSection('subnav') ?>

		<!-- Flash Messages -->
		<?php if (session()->has('success')): ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<i class="fas fa-check-circle me-2"></i>
				<?= session('success') ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>

		<?php if (session()->has('error')): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-exclamation-triangle me-2"></i>
				<?= session('error') ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>

		<?php if (session()->has('errors')): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<i class="fas fa-exclamation-triangle me-2"></i>
				<ul class="mb-0">
					<?php foreach (session('errors') as $error): ?>
						<li><?= esc($error) ?></li>
					<?php endforeach; ?>
				</ul>
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		<?php endif; ?>

		<div class="section-surface">
			<?= $this->renderSection('content') ?>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
    // Function to fetch notifications
    function fetchNotifications() {
        $.ajax({
            url: '<?= base_url('notifications') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                updateNotificationBadge(data.unreadCount);
                updateNotificationDropdown(data.notifications);
            },
            error: function() {
                console.log('Error fetching notifications');
            }
        });
    }

    // Function to update notification badge
    function updateNotificationBadge(count) {
        const badge = $('#notificationBadge');
        if (count > 0) {
            badge.text(count).show();
        } else {
            badge.hide();
        }
    }

    // Function to update notification dropdown
    function updateNotificationDropdown(notifications) {
        const list = $('#notificationsList');
        const items = list.find('li:not(.dropdown-header):not(:last-child)');

        // Remove existing notification items
        items.slice(1, -1).remove();

        if (notifications.length > 0) {
            notifications.forEach(function(notification) {
                const item = `
                    <li>
                        <a class="dropdown-item d-flex justify-content-between align-items-start" href="#" data-id="${notification.id}">
                            <div class="me-2">
                                <small>${notification.message}</small>
                            </div>
                            <button class="btn btn-sm btn-outline-primary mark-read-btn" data-id="${notification.id}">Mark Read</button>
                        </a>
                    </li>
                `;
                list.find('li').last().before(item);
            });
        } else {
            const noNotifications = '<li><div class="text-center p-2"><small class="text-muted">No new notifications</small></div></li>';
            list.find('li').last().before(noNotifications);
        }
    }

    // Handle mark as read
    $(document).on('click', '.mark-read-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const notificationId = $(this).data('id');

        $.ajax({
            url: '<?= base_url('notifications/mark_read/') ?>' + notificationId,
            method: 'POST',
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    fetchNotifications(); // Refresh notifications
                }
            },
            error: function() {
                console.log('Error marking notification as read');
            }
        });
    });

    // Fetch notifications on page load
    fetchNotifications();

    // Refresh notifications every 60 seconds
    setInterval(fetchNotifications, 60000);
});
</script>
</body>
</html>
