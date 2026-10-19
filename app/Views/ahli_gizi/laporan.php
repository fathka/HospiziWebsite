<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-3">
    <div class="card-body" style="background-color: #68b8ab; color: white;">
        <h4 class="mb-0">Laporan Kepatuhan Pasien</h4>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        <!-- Filter Tanggal -->
        <form class="mb-3 d-flex gap-2" method="get" action="<?= base_url('ahli-gizi/laporan') ?>">
            <input type="date" name="tanggal_awal" value="<?= esc($tanggal_awal) ?>" class="form-control" required>
            <input type="date" name="tanggal_akhir" value="<?= esc($tanggal_akhir) ?>" class="form-control" required>
            <button type="submit" class="btn btn-success" style="background-color: #68b8ab; border-color: #68b8ab;">
                Filter
            </button>
            <a href="<?= base_url('ahli-gizi/export-laporan-pdf?tanggal_awal='.$tanggal_awal.'&tanggal_akhir='.$tanggal_akhir) ?>" class="btn btn-primary">
                Export PDF
            </a>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead style="background-color: #68b8ab; color: white;">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Waktu Makan</th>
                        <th>Status Kepatuhan</th>
                        <th>Sisa Makanan</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($monitorings): ?>
                        <?php foreach($monitorings as $m): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($m['tanggal'])) ?></td>
                            <td><?= esc($m['nama_lengkap']) ?></td>
                            <td><?= ucfirst($m['waktu_makan']) ?></td>
                            <td><?= ucfirst(str_replace('_',' ',$m['status_kepatuhan'])) ?></td>
                            <td><?= $m['sisa_makanan'] ?? '-' ?></td>
                            <td><?= $m['catatan'] ?? '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Data tidak tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
