<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-3">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Detail Meal Plan - <?= esc($pasien['nama_lengkap']) ?></h5>
    </div>
    <div class="card-body">
        <p><b>Diagnosa:</b> <?= esc($mealPlan['diagnosa']) ?></p>
        <p><b>Status Diet:</b> <?= esc($mealPlan['status_diet']) ?></p>
        <p><b>Target Kalori:</b> <?= esc($mealPlan['target_kalori']) ?> kkal</p>
        <p><b>Periode:</b> <?= esc($mealPlan['tanggal_mulai']) ?> s/d <?= esc($mealPlan['tanggal_selesai']) ?></p>
        <p><b>Catatan:</b><br><?= esc($mealPlan['catatan_ahli_gizi']) ?></p>
    </div>
</div>

<a href="<?= base_url('ahli-gizi/meal-plan') ?>" class="btn btn-secondary">Kembali</a>

<?= $this->endSection() ?>
