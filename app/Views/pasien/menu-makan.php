<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-3" style="background-color:#68b8ab;color:white;">
    <div class="card-body">
        <h4><?= esc($pasien['nama_lengkap']) ?> - Menu Hari Ini</h4>
        <small>Diagnosa: <?= esc($pasien['diagnosa']) ?></small>
    </div>
</div>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <h5>Menu & Status Kepatuhan</h5>
        <table class="table table-bordered">
            <thead style="background-color:#68b8ab;color:white;">
                <tr>
                    <th>Waktu Makan</th>
                    <th>Menu</th>
                    <th>Status Kepatuhan</th>
                    <th>Sisa Makanan</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $waktuMakanList = ['pagi','siang','malam','snack'];
                foreach($waktuMakanList as $slot):
                    $menu = array_filter($menuHarian, fn($m) => $m['waktu_makan']==$slot);
                    $menu = $menu ? array_values($menu)[0]['nama_menu'] : '-';
                    $m = $monitoringMap[$slot] ?? null;
                ?>
                <tr>
                    <td><?= ucfirst($slot) ?></td>
                    <td><?= esc($menu) ?></td>
                    <td><?= $m['status_kepatuhan'] ?? 'Belum diisi' ?></td>
                    <td><?= $m['sisa_makanan'] ?? '-' ?></td>
                    <td><?= $m['catatan'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5>Tips & Edukasi Diet</h5>
        <?php if($tips): ?>
            <ul>
                <?php foreach($tips as $t): ?>
                    <li><strong><?= esc($t['judul']) ?>:</strong> <?= esc($t['isi']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada tips khusus untuk diagnosa ini.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
