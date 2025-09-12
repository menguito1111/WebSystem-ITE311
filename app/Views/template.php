<!doctype html>
<html lang="en">
<head>
  <title>MY WEBSITE</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Custom Navbar Styles */
    .navbar {
        background: linear-gradient(90deg, #0d3b24, #000000);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.4rem;
        letter-spacing: 1px;
        color: #4caf50 !important;
        text-transform: uppercase;
    }

    .nav-link {
        color: #ffffff !important;
        font-weight: 500;
        transition: color 0.3s ease, transform 0.2s ease;
    }

    .nav-link:hover {
        color: #4caf50 !important;
        transform: scale(1.05);
    }

    /* Buttons */
    .btn-success {
        background: linear-gradient(90deg, #28a745, #4caf50);
        border: none;
        border-radius: 20px;
        padding: 6px 14px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(90deg, #4caf50, #28a745);
        transform: scale(1.05);
    }

    .btn-danger {
        background: linear-gradient(90deg, #dc3545, #ff4d4d);
        border: none;
        border-radius: 20px;
        padding: 6px 14px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background: linear-gradient(90deg, #ff4d4d, #dc3545);
        transform: scale(1.05);
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('/') ?>">MY WEBSITE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/') ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('about') ?>">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
          </li>
          <li class="nav-item">
            <?php if (session()->get('isAuthenticated')): ?>
              <a class="btn btn-danger ms-3" href="<?= base_url('logout') ?>">Logout</a>
            <?php else: ?>
              <a class="btn btn-success ms-3" href="<?= base_url('login') ?>">Login</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main content -->
  <div class="container mt-4">
    <?= $this->renderSection('content') ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
