<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row mb-3">
    <div class="col-12">
        <div class="card shadow-sm" style="background-color: #68b8ab; color: white;">
            <div class="card-body">
                <h4 class="mb-0">Dashboard Ahli Gizi</h4>
                <small><?= esc($tanggal) ?></small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3" style="background-color:#4caf50; color:white;">
            <h5>Total Pasien Aktif</h5>
            <h2><?= esc($total_pasien) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3" style="background-color:#2196f3; color:white;">
            <h5>Pasien Patuh</h5>
            <h2><?= esc($pasien_patuh) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3" style="background-color:#ff9800; color:white;">
            <h5>Perlu Perhatian</h5>
            <h2><?= esc($pasien_perlu_perhatian) ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm text-center p-3" style="background-color:#f44336; color:white;">
            <h5>Tidak Patuh</h5>
            <h2><?= esc($pasien_tidak_patuh) ?></h2>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Monitoring & Menu Hari Ini</h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background-color: #68b8ab; color: white;">
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Diagnosa</th>
                        <th>Waktu Makan</th>
                        <th>Menu Hari Ini</th>
                        <th>Status Kepatuhan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pasienList as $p): ?>
                        <?php 
                            $mealPlan = null;
                            foreach ($mealPlansToday as $m) {
                                if ($m['pasien_id'] == $p['id']) $mealPlan = $m;
                            }
                            $waktuMakanList = ['pagi','siang','malam','snack'];
                        ?>
                        <?php foreach($waktuMakanList as $slot): ?>
                            <tr>
                                <td><?= esc($p['nama_lengkap']) ?></td>
                                <td><?= esc($mealPlan['diagnosa'] ?? '-') ?></td>
                                <td><?= ucfirst($slot) ?></td>
                                <td><?= esc($mealPlan['menu_' . $slot] ?? '-') ?></td>
                                <td><?= esc($monitoringMap[$p['id']][$slot]['status_kepatuhan'] ?? 'Belum diisi') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
