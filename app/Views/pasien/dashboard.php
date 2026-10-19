<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Halo, <?= $pasien['nama_lengkap'] ?? 'Pasien' ?></h2>
    </div>

    <!-- Status Diet -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5>Status Diet</h5>
        </div>
        <div class="card-body">
            <p><strong>Jenis Diet:</strong> <?= $pasien['status_diet'] ?? 'Belum ditentukan' ?></p>
            <p><strong>Diagnosa:</strong> <?= $pasien['diagnosa'] ?? '-' ?></p>
        </div>
    </div>

    <!-- Menu Harian -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5>Menu Hari Ini</h5>
        </div>
        <div class="card-body">
            <?php if(!empty($menu_harian)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Waktu Makan</th>
                            <th>Menu</th>
                            <th>Bahan</th>
                            <th>Kalori</th>
                            <th>Protein</th>
                            <th>Karbohidrat</th>
                            <th>Lemak</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($menu_harian as $menu): ?>
                            <tr>
                                <td><?= $menu['waktu_makan'] ?></td>
                                <td><?= $menu['nama_menu'] ?></td>
                                <td><?= $menu['bahan_makanan'] ?></td>
                                <td><?= $menu['kalori'] ?></td>
                                <td><?= $menu['protein'] ?></td>
                                <td><?= $menu['karbohidrat'] ?></td>
                                <td><?= $menu['lemak'] ?></td>
                                <td><?= $menu['catatan'] ?? '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Menu harian belum tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Monitoring Kepatuhan -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h5>Monitoring Kepatuhan</h5>
        </div>
        <div class="card-body">
            <?php if(!empty($kepatuhan)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kepatuhan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($kepatuhan as $row): ?>
                            <tr>
                                <td><?= $row['tanggal'] ?? '-' ?></td>
                                <td><?= $row['patuh'] ?? '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Belum ada monitoring kepatuhan.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
