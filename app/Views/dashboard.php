<?= $this->extend('template') ?>

<?= $this->section('content') ?>
	<div class="d-flex justify-content-between align-items-center mb-3">
		<h1 class="mb-0 section-header d-inline-block">Dashboard</h1>
		<a href="<?= base_url('logout') ?>" class="btn btn-outline btn-sm">Logout</a>
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

	<div class="card-lite mb-3">
		<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2 justify-content-between">
			<div>
				<div class="fw-semibold">Welcome, <?= esc(session('user_name')) ?>!</div>
				<div class="text-muted small">Email: <?= esc(session('user_email')) ?> | Role: <?= esc(session('role')) ?></div>
			</div>
		</div>
	</div>

	<div class="card-lite">
		<h5 class="mb-2">Overview</h5>
		<p class="mb-2">This is a protected page only visible after login.</p>
		<p class="text-muted mb-0">You are successfully logged in as <?= esc(session('role')) ?>.</p>
	</div>
<?= $this->endSection() ?>