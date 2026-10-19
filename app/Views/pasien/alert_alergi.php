<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card text-center shadow p-4" style="max-width: 420px; border-radius: 16px;">
        
        <div class="mb-3">
            <span style="font-size:42px;">⚠️</span>
        </div>

        <?php $alergi = explode(',', $pasien['alergi_pasien']); ?>

        <h5 class="text-danger font-weight-bold mb-3">
            PASIEN MEMILIKI ALERGI !!
        </h5>

        <ul class="list-unstyled text-danger font-weight-bold">
            <?php foreach ($alergi as $a): ?>
                <li>• <?= strtoupper(trim($a)) ?></li>
            <?php endforeach; ?>
        </ul>

        <div class="mt-4">
            <a href="<?= base_url('pasien/dashboard-lanjut') ?>" 
               class="btn btn-info btn-sm px-4">
                LIHAT DETAIL
            </a>

            <br>

            <a href="<?= base_url('pasien/logout') ?>" 
               class="btn btn-link text-muted btn-sm mt-2">
                Logout
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
