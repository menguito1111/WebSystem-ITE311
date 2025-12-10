<?= $this->extend('template') ?>

<?= $this->section('title') ?>Announcements<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bullhorn me-3 fs-2"></i>
                        <div>
                            <h2 class="mb-1">Announcements</h2>
                            <p class="mb-0 opacity-75">Stay updated with the latest news and announcements</p>
                        </div>
                    </div>
                    <?php if (in_array(session()->get('userRole'), ['teacher', 'admin'])): ?>
                        <a href="<?= base_url('/announcements/create') ?>" class="btn btn-light">
                            <i class="fas fa-plus me-1"></i>Create Announcement
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form id="searchForm" class="d-flex">
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text"
                                           id="searchInput"
                                           class="form-control"
                                           placeholder="Search announcements by title or content..."
                                           name="search_term">
                                    <button class="btn btn-outline-primary" type="submit">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing <span id="announcementCount"><?= count($announcements) ?></span> announcement(s)
                            </small>
                        </div>
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
                                <div class="d-flex align-items-center gap-2">
                                    <?php if (in_array(session()->get('userRole'), ['teacher', 'admin'])): ?>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('/announcements/edit/' . $announcement['id']) ?>"
                                               class="btn btn-sm btn-outline-warning"
                                               title="Edit Announcement">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger delete-announcement-btn"
                                                    data-announcement-id="<?= $announcement['id'] ?>"
                                                    data-announcement-title="<?= esc($announcement['title']) ?>"
                                                    title="Delete Announcement">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                    <small class="text-muted bg-light px-2 py-1 rounded">
                                        <i class="fas fa-clock me-1"></i>
                                        Posted on: <?= date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])) ?>
                                    </small>
                                </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    const announcementCount = document.getElementById('announcementCount');

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const searchTerm = searchInput.value.trim();

        // Show loading state
        const submitBtn = searchForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...';
        submitBtn.disabled = true;

        // Make AJAX request
        fetch(`<?= base_url('/announcements/search') ?>?search_term=${encodeURIComponent(searchTerm)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateAnnouncementsList(data.announcements);
                announcementCount.textContent = data.announcements.length;

                // Show success message
                showAlert('success', `Found ${data.announcements.length} announcement(s) matching "${searchTerm}"`);
            } else {
                showAlert('danger', 'Search failed. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred during search.');
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Delete functionality
    document.querySelectorAll('.delete-announcement-btn').forEach(button => {
        button.addEventListener('click', function() {
            const announcementId = this.getAttribute('data-announcement-id');
            const announcementTitle = this.getAttribute('data-announcement-title');

            if (confirm(`Are you sure you want to delete the announcement "${announcementTitle}"?\n\nThis action cannot be undone.`)) {
                deleteAnnouncement(announcementId, this);
            }
        });
    });

    function deleteAnnouncement(announcementId, button) {
        // Disable button and show loading
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // Make AJAX request
        fetch(`<?= base_url('/announcements/delete/') ?>${announcementId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the announcement card with fade effect
                const card = button.closest('.card');
                card.style.opacity = '0';
                setTimeout(() => {
                    card.remove();
                    // Update count
                    const currentCount = parseInt(announcementCount.textContent) - 1;
                    announcementCount.textContent = Math.max(0, currentCount);

                    // Check if no announcements left
                    const remainingCards = document.querySelectorAll('.card.mb-4');
                    if (remainingCards.length === 0) {
                        // Show empty state
                        const container = document.querySelector('.row .col-12');
                        container.innerHTML = `
                            <div class="text-center py-5">
                                <div class="bg-light rounded-3 p-5">
                                    <i class="fas fa-bullhorn text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h4 class="text-muted">No Announcements Yet</h4>
                                    <p class="text-muted">Check back later for important updates and news.</p>
                                </div>
                            </div>
                        `;
                    }
                }, 300);

                showAlert('success', data.message);
            } else {
                showAlert('danger', data.message);
                // Re-enable button
                button.disabled = false;
                button.innerHTML = '<i class="fas fa-trash"></i>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred. Please try again.');
            // Re-enable button
            button.disabled = false;
            button.innerHTML = '<i class="fas fa-trash"></i>';
        });
    }

    function updateAnnouncementsList(announcements) {
        const container = document.querySelector('.row .col-12');
        let html = '';

        if (announcements.length === 0) {
            html = `
                <div class="text-center py-5">
                    <div class="bg-light rounded-3 p-5">
                        <i class="fas fa-bullhorn text-muted mb-3" style="font-size: 3rem;"></i>
                        <h4 class="text-muted">No Announcements Found</h4>
                        <p class="text-muted">Try a different search term or clear the search to see all announcements.</p>
                        <button class="btn btn-outline-primary" onclick="clearSearch()">
                            <i class="fas fa-times me-1"></i>Clear Search
                        </button>
                    </div>
                </div>
            `;
        } else {
            announcements.forEach(announcement => {
                let editDeleteButtons = '';
                <?php if (in_array(session()->get('userRole'), ['teacher', 'admin'])): ?>
                editDeleteButtons = `
                    <div class="btn-group" role="group">
                        <a href="<?= base_url('/announcements/edit/') ?>${announcement.id}"
                           class="btn btn-sm btn-outline-warning"
                           title="Edit Announcement">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-outline-danger delete-announcement-btn"
                                data-announcement-id="${announcement.id}"
                                data-announcement-title="${announcement.title.replace(/"/g, '"')}"
                                title="Delete Announcement">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                <?php endif; ?>

                html += `
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-primary mb-0 fw-bold">
                                    ${announcement.title}
                                </h5>
                                <div class="d-flex align-items-center gap-2">
                                    ${editDeleteButtons}
                                    <small class="text-muted bg-light px-2 py-1 rounded">
                                        <i class="fas fa-clock me-1"></i>
                                        Posted on: ${new Date(announcement.created_at).toLocaleDateString('en-US', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric',
                                            hour: 'numeric',
                                            minute: '2-digit',
                                            hour12: true
                                        })}
                                    </small>
                                </div>
                            </div>
                            <div class="card-text">
                                <p class="mb-0 lh-lg">
                                    ${announcement.content.replace(/\n/g, '<br>')}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        // Replace the content
        const existingContent = container.querySelector(':not(.text-center)');
        if (existingContent) {
            existingContent.outerHTML = html;
        } else {
            container.innerHTML = html;
        }

        // Re-attach delete event listeners
        document.querySelectorAll('.delete-announcement-btn').forEach(button => {
            button.addEventListener('click', function() {
                const announcementId = this.getAttribute('data-announcement-id');
                const announcementTitle = this.getAttribute('data-announcement-title');

                if (confirm(`Are you sure you want to delete the announcement "${announcementTitle}"?\n\nThis action cannot be undone.`)) {
                    deleteAnnouncement(announcementId, this);
                }
            });
        });
    }

    function clearSearch() {
        searchInput.value = '';
        searchForm.dispatchEvent(new Event('submit'));
    }

    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Insert at the top of the container
        const container = document.querySelector('.container-fluid');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
        }

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alertDiv);
            bsAlert.close();
        }, 5000);
    }

    // Clear search on page load if needed
    window.clearSearch = clearSearch;
});
</script>
<?= $this->endSection() ?>
