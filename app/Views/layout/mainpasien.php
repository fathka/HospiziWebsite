<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc ($title ?? 'Hospizi')?> HOSPIZI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f4f7f6; }
        .navbar-custom { background: linear-gradient(135deg, #396660 0%, #73CCBF 100%); }
        .navbar-brand { font-weight: bold; font-size: 24px; color: #A4DAD2 !important; }
        .nav-link { color: #fff !important; margin-right: 15px; font-weight: 500; }
        .nav-link:hover { color: #A4DAD2 !important; }
        .main-content { padding: 40px 20px; }
        .footer { background: white; padding: 20px 0; border-top: 1px solid #dee2e6; margin-top: 50px; width: 100%; position: relative; left: 0; bottom: 0; right: 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('ahli-gizi/dashboard') ?>">Hospizi</a>
        <button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"  aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ahli-gizi/dashboard') ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ahli-gizi/data-pasien') ?>">Data Pasien</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ahli-gizi/meal-plan') ?>">Meal Plan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ahli-gizi/monitoring-pasien') ?>">Monitoring</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('ahli-gizi/laporan') ?>">Laporan</a>
                </li>
            </ul>
            <div class="navbar-nav ml-auto">
                <span class="navbar-text text-white mr-3">Halo, Ahli Gizi<?= session()->get('ahli_gizi_nama') ?></span>
                <a class="btn btn-outline-light btn-sm mt-1" href="<?= base_url('auth/logout') ?>">Keluar</a>
            </div>
        </div>
    </div>
</nav>

<div class="container main-content">
    <?= $this->renderSection('content') ?>
</div>

<footer class="footer text-center">
    <div class="container">
        <span class="text-muted">&copy; 2026 Hospizi - Sistem Pelayanan Gizi Terpadu</span>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>