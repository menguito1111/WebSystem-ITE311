<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My CI Project</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    body {
        background-color: #33373c;
        font-family: "Poppins", sans-serif;
        margin: 0;
    }

    /* Top Navbar */
    .navbar {
        background: #eaeaeaff; /* soft light blue */
        box-shadow: 0px 2px 5px rgba(0,0,0,0.15);
        padding: 10px 20px;
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.3rem;
        color: #333 !important;
    }

    .nav-link {
        font-size: 1rem;
        color: #333 !important;
        padding: 8px 15px;
        border-radius: 6px;
        transition: 0.2s;
    }

    .nav-link:hover {
        background: #d0e5fa;
        color: #000 !important;
    }

    .nav-link.active {
        background: #fe0000ff;
        color: #fff !important;
        font-weight: bold;
    }

    /* Main container */
    .container {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0px 3px 8px rgba(0,0,0,0.1);
    }
</style>


</head>
<body>

<!-- Navigation Bar (hide on login & register) -->
<?php if (!in_array(uri_string(), ['login', 'register'])): ?>
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= site_url('/') ?>">My WebSystem</a>
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
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>

<div class="container mt-4">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>
