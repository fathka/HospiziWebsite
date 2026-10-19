<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Menu Harian</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('ahli-gizi/menu-harian/simpan') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="meal_plan_id" value="<?= $mealPlanId ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu Makan</label>
                            <select name="waktu_makan" class="form-select" required>
                                <option value="pagi">Pagi</option>
                                <option value="snack_pagi">Snack Pagi</option>
                                <option value="siang">Siang</option>
                                <option value="snack_sore">Snack Sore</option>
                                <option value="malam">Malam</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Menu / Nama Makanan</label>
                            <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Nasi Merah + Ayam Bakar" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kalori (kkal)</label>
                                <input type="number" step="any" name="kalori" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Protein (g)</label>
                                <input type="number" step="any" name="protein" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lemak (g)</label>
                                <input type="number" step="any" name="lemak" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Karbohidrat (g)</label>
                                <input type="number" step="any" name="karbohidrat" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Simpan Menu</button>
                            <a href="<?= base_url('ahli-gizi/daily-plan/' . $mealPlanId) ?>" class="btn btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>