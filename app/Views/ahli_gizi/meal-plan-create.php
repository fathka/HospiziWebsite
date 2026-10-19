<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Meal Plan - <?= esc($pasien['nama_lengkap']) ?></h5>
    </div>

    <form method="post" action="<?= base_url('ahli-gizi/meal-plan/store') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="pasien_id" value="<?= $pasien['id'] ?>">

        <div class="card-body row">

            <!-- PILIH TEMPLATE -->
            <div class="col-md-6">
                <label>Template Diet</label>
                <select id="templateSelect" class="form-control">
                    <option value="">-- Manual --</option>
                    <?php foreach ($templates as $t): ?>
                        <option value="<?= $t['id'] ?>"
                            data-status="<?= esc($t['status_diet']) ?>"
                            data-diagnosa="<?= esc($t['diagnosa']) ?>"
                            data-kalori="<?= esc($t['target_kalori']) ?>"
                            data-protein="<?= esc($t['target_protein']) ?>"
                            data-karbo="<?= esc($t['target_karbohidrat']) ?>"
                            data-lemak="<?= esc($t['target_lemak']) ?>"
                            data-boleh="<?= esc($t['makanan_boleh']) ?>"
                            data-tidak="<?= esc($t['makanan_tidak_boleh']) ?>"
                            data-catatan="<?= esc($t['catatan']) ?>"
                        >
                            <?= esc($t['nama_template']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-6">
                <label>Status Diet</label>
                <input type="text" name="status_diet" id="statusDiet" class="form-control" required>
            </div>

            <div class="col-md-6 mt-3">
                <label>Diagnosa</label>
                <input type="text" name="diagnosa" id="diagnosa" class="form-control" required>
            </div>

            <div class="col-md-6 mt-3">
                <label>Target Kalori</label>
                <input type="number" name="target_kalori" id="kalori" class="form-control">
            </div>

            <div class="col-md-4 mt-3">
                <label>Protein</label>
                <input type="number" name="target_protein" id="protein" class="form-control">
            </div>

            <div class="col-md-4 mt-3">
                <label>Karbohidrat</label>
                <input type="number" name="target_karbohidrat" id="karbo" class="form-control">
            </div>

            <div class="col-md-4 mt-3">
                <label>Lemak</label>
                <input type="number" name="target_lemak" id="lemak" class="form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggalMulai" class="form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggalSelesai" class="form-control">
            </div>

            <div class="col-md-6 mt-3">
                <label>Makanan Boleh</label>
                <textarea name="makanan_boleh" id="makananBoleh" class="form-control"></textarea>
            </div>

            <div class="col-md-6 mt-3">
                <label>Makanan Tidak Boleh</label>
                <textarea name="makanan_tidak_boleh" id="makananTidak" class="form-control"></textarea>
            </div>

            <div class="col-md-12 mt-3">
                <label>Catatan Ahli Gizi</label>
                <textarea name="catatan_ahli_gizi" id="catatan" class="form-control"></textarea>
            </div>

        </div>

        <div class="card-footer text-right">
            <a href="<?= base_url('ahli-gizi/meal-plan') ?>" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-primary">Simpan Meal Plan</button>
        </div>
    </form>
</div>

<script>
document.getElementById('templateSelect').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    document.getElementById('statusDiet').value = opt.dataset.status || '';
    document.getElementById('diagnosa').value   = opt.dataset.diagnosa || '';
    document.getElementById('kalori').value     = opt.dataset.kalori || '';
    document.getElementById('protein').value    = opt.dataset.protein || '';
    document.getElementById('karbo').value      = opt.dataset.karbo || '';
    document.getElementById('lemak').value      = opt.dataset.lemak || '';
    document.getElementById('makananBoleh').value = opt.dataset.boleh || '';
    document.getElementById('makananTidak').value = opt.dataset.tidak || '';
    document.getElementById('catatan').value    = opt.dataset.catatan || '';
});
</script>

<?= $this->endSection() ?>
