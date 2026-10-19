<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm" style="border-radius: 20px; overflow: hidden;">
  <div class="card-header bg-info text-white py-3">
    <h5 class="mb-0 fw-bold"><i class="fas fa-history me-2"></i>Riwayat Monitoring Kepatuhan</h5>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>No RM</th>
            <th>Nama Pasien</th>
            <th>Waktu</th>
            <th>Status Kepatuhan</th>
            <th>Sisa (%)</th>
            <th>Catatan</th>
            <th>Tanggal Input</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($riwayat as $r): ?>
          <tr>
            <td class="fw-bold text-muted"><?= $r['no_rm'] ?></td>
            <td><?= $r['nama_lengkap'] ?></td>
            <td class="text-uppercase small"><span class="badge bg-light text-dark"><?= $r['waktu_makan'] ?></span></td>
            <td>
              <?php if ($r['status_kepatuhan'] == 'habis'): ?>
                <span class="badge bg-success">Habis (100%)</span>
              <?php elseif ($r['status_kepatuhan'] == 'tidak_habis'): ?>
                <span class="badge bg-warning text-dark">Sisa</span>
              <?php else: ?>
                <span class="badge bg-danger">Tidak Makan</span>
              <?php endif; ?>
            </td>
            <td><?= $r['sisa_makanan'] ?>%</td>
            <td class="small italic text-muted"><?= $r['catatan'] ?: '-' ?></td>
            <td><small><?= date('d/m/Y H:i', strtotime($r['created_at'])) ?></small></td>
          </tr>
          <?php endforeach ?>
          <?php if (empty($riwayat)): ?>
            <tr><td colspan="7" class="text-center py-4">Belum ada data riwayat.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>