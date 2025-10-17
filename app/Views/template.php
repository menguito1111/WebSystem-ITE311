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
		<a class="navbar-brand" href="<?= site_url('/') ?>">
			<i class="fas fa-graduation-cap"></i> WebSystem
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav me-auto">
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= site_url('/') ?>">
						<i class="fas fa-home"></i> Home
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">
						<i class="fas fa-info-circle"></i> About
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="<?= site_url('contact') ?>">
						<i class="fas fa-envelope"></i> Contact
					</a>
				</li>
				
				<?php 
				$role = strtolower((string) session('role'));
				$isLoggedIn = session('isLoggedIn');
				?>
				
				<?php if ($isLoggedIn): ?>
					<!-- ROLE-SPECIFIC NAVIGATION -->
					<li class="nav-item">
						<a class="nav-link <?= uri_string() == 'announcements' ? 'active' : '' ?>" href="<?= site_url('announcements') ?>">
							<i class="fas fa-bullhorn"></i> Announcements
						</a>
					</li>
					
					<?php if ($role === 'admin'): ?>
						<li class="nav-item">
							<a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
								<i class="fas fa-user-shield"></i> Admin Tools
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#"><i class="fas fa-users"></i> Manage Users</a></li>
								<li><a class="dropdown-item" href="#"><i class="fas fa-book"></i> Manage Courses</a></li>
								<li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> System Settings</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
							</ul>
						</li>
					<?php elseif ($role === 'teacher'): ?>
						<li class="nav-item">
							<a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="teacherDropdown" role="button" data-bs-toggle="dropdown">
								<i class="fas fa-chalkboard-teacher"></i> Teaching Tools
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#"><i class="fas fa-plus"></i> Create Course</a></li>
								<li><a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i> Create Assignment</a></li>
								<li><a class="dropdown-item" href="#"><i class="fas fa-chart-line"></i> Grade Book</a></li>
								<li><hr class="dropdown-divider"></li>
								<li><a class="dropdown-item" href="#"><i class="fas fa-users"></i> My Students</a></li>
							</ul>
						</li>
					<?php elseif ($role === 'student'): ?>
						<li class="nav-item">
							<a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								<i class="fas fa-book-open"></i> My Courses
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								<i class="fas fa-file-alt"></i> Assignments
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">
								<i class="fas fa-chart-bar"></i> Grades
							</a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
			
			<ul class="navbar-nav">
				<?php if ($isLoggedIn): ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
							<i class="fas fa-user"></i> 
							<?= session('user_name') ?>
							<span class="badge badge-soft ms-1">
								<?= ucfirst($role) ?>
							</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="#"><i class="fas fa-user-circle"></i> Profile</a></li>
							<li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
						</ul>
					</li>
				<?php else: ?>
					<li class="nav-item">
						<a class="nav-link <?= uri_string() == 'login' ? 'active' : '' ?>" href="<?= site_url('login') ?>">
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
		<div class="section-surface">
			<?= $this->renderSection('content') ?>
		</div>
	</div>
</div>

</body>
</html>