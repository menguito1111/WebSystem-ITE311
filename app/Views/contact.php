<?= $this->extend('template') ?>

<?= $this->section('title') ?>Contact<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    body {
        background: #f8fbff; /* light blue-white background */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        max-width: 600px;
        margin: 0 auto; /* centers the card */
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
    }

    .page-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(0,0,0,0.12);
    }

    h1 {
        color: #00796b;
        font-weight: 700;
    }

    .divider {
        width: 60px;
        height: 4px;
        background: #00796b;
        margin: 10px auto 20px auto;
        border-radius: 3px;
    }

    p {
        color: #455a64;
        font-size: 1.05rem;
    }
</style>

<div class="container py-5">
    <div class="page-card">
        <h1 class="fw-bold">Contact 📩</h1>
        <div class="divider"></div>
        <p class="lead">This is my contact page.</p>
    </div>
</div>
<?= $this->endSection() ?>
