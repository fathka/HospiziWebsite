<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-3">
    <div class="card-body bg-primary text-white">
        <h4 class="mb-0">Tambah Menu Harian</h4>
        <small>
            <?= esc($pasien['nama_lengkap']) ?> | 
            Diagnosa: <?= esc($mealPlan['diagnosa']) ?>
        </small>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('ahli-gizi/menu-harian/store') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="meal_plan_id" value="<?= esc($mealPlan['id']) ?>">
            <input type="hidden" name="tanggal" value="<?= esc($tanggal) ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="text" class="form-control bg-light" value="<?= esc($tanggal) ?>" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Waktu Makan</label>
                    <select name="waktu_makan" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="pagi">Pagi</option>
                        <option value="snack_pagi">Snack Pagi</option>
                        <option value="siang">Siang</option>
                        <option value="snack_sore">Snack Sore</option>
                        <option value="malam">Malam</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Menu Makanan</label>
                <textarea name="nama_menu" class="form-control" rows="2" placeholder="Contoh: Nasi Merah, Pepes Ikan, Cah Brokoli" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Bahan Makanan</label>
                <input type="text" name="bahan_makanan" class="form-control" placeholder="Sebutkan bahan utama (opsional)">
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Kalori (kkal)</label>
                    <input type="number" name="kalori" class="form-control" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Protein (g)</label>
                    <input type="number" step="0.01" name="protein" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Lemak (g)</label>
                    <input type="number" step="0.01" name="lemak" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Karbohidrat (g)</label>
                    <input type="number" step="0.01" name="karbohidrat" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Catatan Diet / Keterangan</label>
                <input type="text" name="catatan" class="form-control" placeholder="Contoh: Rendah garam, tekstur lunak">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="<?= base_url('ahli-gizi/daily-plan/'.$mealPlan['id']) ?>" class="btn btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn btn-success px-4">
                    💾 Simpan Menu
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>