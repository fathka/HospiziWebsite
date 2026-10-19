<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --hospizi-teal: #69c0b0; /* Warna hijau tosca utama */
        --hospizi-light-teal: #e1f2f0;
        --hospizi-dark: #4a8f83;
        --bg-gray: #f4f7f6;
    }

    body {
        background-color: var(--bg-gray);
    }

    /* Filter Box Style */
    .filter-section {
        background: white;
        border-radius: 25px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .filter-label {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 15px;
    }

    .hospizi-input {
        border-radius: 50px;
        border: 1px solid #ced4da;
        padding: 10px 20px;
        background-color: white;
        transition: 0.3s;
    }

    .hospizi-input:focus {
        border-color: var(--hospizi-teal);
        box-shadow: 0 0 0 0.2rem rgba(105, 192, 176, 0.25);
    }

    /* Table Container */
    .monitoring-container {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 4px 25px rgba(0,0,0,0.05);
    }

    .monitoring-header {
        background-color: var(--hospizi-teal);
        color: white;
        padding: 20px 30px;
    }

    .monitoring-header h2 {
        font-weight: 800;
        margin: 0;
        letter-spacing: 0.5px;
    }

    /* Table Design */
    .table-hospizi thead th {
        background-color: #f8f9fa;
        color: #777;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border: none;
        padding: 15px;
    }

    .table-hospizi tbody td {
        padding: 15px;
        border-bottom: 1px solid #f1f1f1;
    }

    /* Button Status Badges */
    .btn-status {
        border-radius: 50px;
        font-size: 0.75rem;
        padding: 6px 15px;
        font-weight: 700;
        border: none;
        min-width: 90px;
        transition: 0.3s ease;
    }

    .btn-habis { background-color: var(--hospizi-teal); color: white; } /* Sesuai gambar: Hijau */
    .btn-sisa { background-color: #f6e05e; color: #856404; } /* Sesuai gambar: Kuning */
    .btn-kosong { background-color: #f56565; color: white; } /* Sesuai gambar: Merah */
    .btn-input { background-color: var(--hospizi-light-teal); color: var(--hospizi-teal); border: 1px dashed var(--hospizi-teal); }

    .btn-status:hover {
        transform: translateY(-2px);
        filter: brightness(0.9);
    }

    .date-display {
        font-weight: 700;
        color: #444;
        margin: 20px 0;
        font-size: 1.2rem;
    }
</style>

<div class="container py-4">
    <div class="filter-section">
        <div class="filter-label">Filter Pencarian</div>
        <form method="get" action="<?= base_url('ahli-gizi/monitoring-pasien') ?>" class="row g-3">
            <div class="col-md-3">
                <label class="small text-muted ms-2">Nama</label>
                <input type="text" name="nama" class="form-control hospizi-input" placeholder="Cari nama pasien...">
            </div>
            <div class="col-md-2">
                <label class="small text-muted ms-2">Jenis Diet</label>
                <input type="text" name="diet" class="form-control hospizi-input" placeholder="Contoh: Diet Gula">
            </div>
            <div class="col-md-2">
                <label class="small text-muted ms-2">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control hospizi-input">
            </div>
            <div class="col-md-3">
                <label class="small text-muted ms-2">Pilih Hari Monitoring</label>
                <input type="date" name="tanggal" class="form-control hospizi-input" value="<?= $tanggal ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn text-white w-100 rounded-pill fw-bold" style="background: var(--hospizi-dark); padding: 10px;">Cari Data</button>
            </div>
        </form>
    </div>

    <div class="text-center date-display">
        <i class="far fa-calendar-alt me-2"></i><?= date('l, d F Y', strtotime($tanggal)) ?>
    </div>

    <div class="monitoring-container">
        <div class="monitoring-header">
            <h2>Monitoring</h2>
        </div>
        <div class="table-responsive">
            <table class="table table-hospizi align-middle mb-0">
                <thead class="text-center">
                    <tr>
                        <th class="ps-4 text-start">No RM</th>
                        <th class="text-start">Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>Diagnosa</th>
                        <th>Bangsal</th>
                        <th>Jenis Diet</th>
                        <th>Pagi</th>
                        <th>Siang</th>
                        <th>Malam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pasienList as $p): ?>
                    <tr>
                        <td class="ps-4 small fw-bold text-muted"><?= esc($p['no_rm']) ?></td>
                        <td><span class="fw-bold text-dark"><?= esc($p['nama_lengkap']) ?></span></td>
                        <td class="text-center small"><?= date('d M Y', strtotime($p['tanggal_lahir'])) ?></td>
                        <td class="text-center"><span class="badge bg-light text-dark fw-normal rounded-pill px-3"><?= esc($p['diagnosa'] ?? 'Umum') ?></span></td>
                        <td class="text-center"><small class="text-muted"><?= esc($p['bangsal'] ?? '-') ?></small></td>
                        <td class="text-center fw-bold text-info" style="font-size: 0.8rem;"><?= esc($p['jenis_diet'] ?? '-') ?></td>
                        
                        <?php foreach (['pagi', 'siang', 'malam'] as $waktu): ?>
                            <td class="text-center">
                                <?php 
                                $m = $monitoringMap[$p['id']][$waktu] ?? null; 
                                $btnClass = 'btn-input';
                                $label = '+ Input';

                                if($m) {
                                    if($m['status_kepatuhan'] == 'habis') { $btnClass = 'btn-habis'; $label = 'Habis'; }
                                    elseif($m['status_kepatuhan'] == 'tidak_habis') { $btnClass = 'btn-sisa'; $label = 'Sisa'; }
                                    elseif($m['status_kepatuhan'] == 'tidak_makan') { $btnClass = 'btn-kosong'; $label = 'Kosong'; }
                                }
                                ?>
                                <button type="button" class="btn btn-status <?= $btnClass ?>" 
                                    onclick="openModalMonitoring(<?= $p['id'] ?>, '<?= esc($p['nama_lengkap']) ?>', '<?= $waktu ?>', '<?= $tanggal ?>')">
                                    <?= $label ?>
                                </button>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMonitoring" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('ahli-gizi/simpan-kepatuhan') ?>" method="post" class="modal-content border-0" style="border-radius: 20px;">
            <?= csrf_field() ?>
            <div class="modal-header border-0 bg-light rounded-top">
                <h5 class="fw-bold mb-0">Input Kepatuhan Makan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" name="pasien_id" id="modal_pasien_id">
                <input type="hidden" name="tanggal" id="modal_tanggal">
                <input type="hidden" name="waktu_makan" id="modal_waktu">

                <div class="mb-4 text-center">
                    <p class="text-muted mb-1">Mencatat data untuk:</p>
                    <h5 id="label_nama_pasien" class="fw-bold text-dark"></h5>
                    <span id="label_waktu" class="badge text-uppercase px-3 py-2" style="background: var(--hospizi-teal);"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Kepatuhan</label>
                    <select name="status_kepatuhan" class="form-select hospizi-input" required>
                        <option value="habis">Habis (100%)</option>
                        <option value="tidak_habis">Tidak Habis / Sisa</option>
                        <option value="tidak_makan">Tidak Makan Sama Sekali</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Sisa Makanan (%)</label>
                    <input type="number" name="sisa_makanan" class="form-control hospizi-input" placeholder="Isi 0 jika habis">
                </div>

                <div class="mb-0">
                    <label class="form-label fw-bold">Catatan Perkembangan</label>
                    <textarea name="catatan" class="form-control" rows="3" style="border-radius: 15px;" placeholder="Contoh: Pasien mual, hanya makan sayur..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 justify-content-center">
                <button type="submit" class="btn text-white px-5 rounded-pill fw-bold" style="background: var(--hospizi-teal);">💾 Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModalMonitoring(id, nama, waktu, tanggal) {
    document.getElementById('modal_pasien_id').value = id;
    document.getElementById('modal_tanggal').value = tanggal;
    document.getElementById('modal_waktu').value = waktu;
    document.getElementById('label_nama_pasien').innerText = nama;
    document.getElementById('label_waktu').innerText = waktu;
    
    new bootstrap.Modal(document.getElementById('modalMonitoring')).show();
}
</script>

<?= $this->endSection() ?>