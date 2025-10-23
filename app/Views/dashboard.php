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

	<?php if ((session('role') ?? '') === 'student'): ?>
		<div class="row mt-3">
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

		<!-- jQuery CDN -->
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