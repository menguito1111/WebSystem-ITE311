<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My CI Project</title>
	<!-- Bootstrap CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		:root {
			/* GitHub-inspired base with slight enhancements */
			--header-bg: #24292f;
			--header-border: #1f2328;
			--page-bg: #f6f8fa;
			--surface: #ffffff;
			--text: #24292f;
			--muted: #57606a;
			--border: #d0d7de;
			--brand: #0969da;
			--brand-hover: #0756b0;
			--accent: #2da44e; /* subtle green accent for tags/states */
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
		/* Page width */
		.org-container { max-width: 1280px; margin: 0 auto; padding-left: 16px; padding-right: 16px; }
		/* Header */
		.navbar { background-color: var(--header-bg); border-bottom: 1px solid var(--header-border); box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
		.navbar .navbar-brand { font-weight: 700; font-size: 1.125rem; color: #fff !important; letter-spacing: 0.2px; }
		.navbar .nav-link { color: rgba(255,255,255,0.85) !important; font-size: 0.95rem; padding: 0.5rem 0.75rem; border-bottom: 2px solid transparent; transition: color .15s ease, border-color .15s ease; }
		.navbar .nav-link:hover { color: #fff !important; border-bottom-color: rgba(255,255,255,0.6); }
		.navbar .nav-link.active { color: #fff !important; border-bottom-color: #fff; }
		/********** Advanced but subtle components **********/
		.main-wrapper { padding-top: 24px; padding-bottom: 48px; }
		.section-surface { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 24px; box-shadow: 0 10px 24px rgba(0,0,0,0.04), 0 2px 6px rgba(0,0,0,0.04); }
		.section-header { border-left: 4px solid var(--brand); padding-left: 12px; margin-bottom: 16px; }
		/* Optional Subnav (tabs-like) */
		.subnav { background: var(--surface); border: 1px solid var(--border); border-radius: 8px; padding: 8px; margin-bottom: 16px; }
		.subnav .nav-link { color: var(--muted) !important; border: 0; border-bottom: 2px solid transparent; padding: 8px 12px; border-radius: 6px; }
		.subnav .nav-link:hover { color: var(--text) !important; background: rgba(0,0,0,0.03); }
		.subnav .nav-link.active { color: var(--text) !important; background: rgba(9,105,218,0.06); border-bottom-color: var(--brand); }
		/* Cards */
		.card-lite { background: var(--surface); border: 1px solid var(--border); border-radius: 10px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
		/* Tables */
		.table-advanced { --bs-table-bg: transparent; border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
		.table-advanced thead th { background: rgba(0,0,0,0.03); color: var(--muted); font-weight: 600; }
		.table-advanced tbody tr + tr td { border-top: 1px solid var(--border); }
		.table-advanced td, .table-advanced th { padding: 12px 14px; }
		/* Forms */
		.form-control, .form-select { background: var(--surface); color: var(--text); border: 1px solid var(--border); border-radius: 8px; }
		.form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(9,105,218,0.15); }
		/* Buttons */
		.btn-primary { background-color: var(--brand); border-color: var(--brand); border-radius: 8px; }
		.btn-primary:hover, .btn-primary:focus { background-color: var(--brand-hover); border-color: var(--brand-hover); }
		.btn-outline { background: transparent; color: var(--brand); border: 1px solid var(--brand); border-radius: 8px; }
		.btn-outline:hover { background: rgba(9,105,218,0.08); }
		/* Tags/Badges */
		.badge-soft { background: rgba(45,164,78,0.12); color: var(--accent); border: 1px solid rgba(45,164,78,0.24); border-radius: 999px; padding: 4px 8px; font-weight: 600; }
		/* Focus visible for accessibility */
		:focus-visible { outline: 3px solid rgba(9,105,218,0.35); outline-offset: 2px; border-radius: 6px; }
		/* Animations kept subtle */
		.transition-all { transition: all .18s ease; }
	</style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg sticky-top">
	<div class="container org-container">
		<a class="navbar-brand" href="<?= site_url('/') ?>">WebSystem</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ms-auto">
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= site_url('/') ?>">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="<?= site_url('about') ?>">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="<?= site_url('contact') ?>">Contact</a>
				</li>
				<?php $role = strtolower((string) session('role')); ?>
				<?php if (!session('isLoggedIn')): ?>
				<li class="nav-item">
					<a class="nav-link <?= uri_string() == 'login' ? 'active' : '' ?>" href="<?= site_url('login') ?>">Login</a>
				</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>

<div class="main-wrapper">
	<div class="container org-container">
		<!-- Optional sub-navigation area (define a 'subnav' section in your views) -->
		<?= $this->renderSection('subnav') ?>
		<div class="section-surface">
			<!-- Dynamic content will load here -->
			<?= $this->renderSection('content') ?>
		</div>
	</div>
</div>

</body>
</html>
