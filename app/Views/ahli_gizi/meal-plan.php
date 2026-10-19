<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-3">
    <div class="card-body text-center text-white" style="background-color:#73CCBF">
        <h3 class="mb-0">MEAL PLAN PASIEN</h3>
        <p class="mb-0">Klik Buat untuk menambahkan Meal Plan atau lihat riwayat</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>No RM</th>
                    <th>Nama</th>
                    <th>Bangsal</th>
                    <th>Status Meal Plan</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pasien)): ?>
                    <?php foreach ($pasien as $p): ?>
                    <tr>
                        <td><?= esc($p['no_rm'] ?? '-') ?></td>
                        <td><?= esc($p['nama_lengkap'] ?? '-') ?></td>
                        <td><?= esc($p['bangsal'] ?? '-') ?></td>
                        <td class="text-center">
                            <?php if (!empty($p['has_meal_plan'])): ?>
                                <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Belum Ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Tombol Buat dengan data alergi -->
                            <button class="btn btn-sm btn-primary btn-buat-mealplan"
                                type="button"
                                data-id="<?= $p['id'] ?>"
                                data-alergi="<?= esc($p['alergi'] ?? '') ?>">
                                Buat
                            </button>

                            <?php if (!empty($p['has_meal_plan'])): ?>
                                <a href="<?= base_url('ahli-gizi/daily-plan/'.($p['meal_plan_id'] ?? '')) ?>"
                                   class="btn btn-sm btn-success">
                                    Daily Plan
                                </a>

                                <button class="btn btn-sm btn-info"
                                    data-toggle="modal"
                                    data-target="#modalHistory<?= $p['id'] ?>">
                                    Riwayat
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- ================= MODAL MEAL PLAN ================= -->
                    <div class="modal fade" id="modalMealPlan<?= $p['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <form method="post" action="<?= base_url('ahli-gizi/meal-plan/store') ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="pasien_id" value="<?= $p['id'] ?>">

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            Meal Plan - <?= esc($p['nama_lengkap'] ?? '-') ?>
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body row">
                                        <div class="col-md-6">
                                            <label>Template Diet</label>
                                            <select class="form-control templateSelect" data-id="<?= $p['id'] ?>">
                                                <option value="">-- Manual --</option>
                                                <?php foreach ($templates ?? [] as $t): ?>
                                                    <option
                                                        data-status="<?= esc($t['status_diet'] ?? '') ?>"
                                                        data-diagnosa="<?= esc($t['diagnosa'] ?? '') ?>"
                                                        data-kalori="<?= esc($t['target_kalori'] ?? '') ?>"
                                                        data-protein="<?= esc($t['target_protein'] ?? '') ?>"
                                                        data-karbo="<?= esc($t['target_karbohidrat'] ?? '') ?>"
                                                        data-lemak="<?= esc($t['target_lemak'] ?? '') ?>"
                                                        data-boleh="<?= esc($t['makanan_boleh'] ?? '') ?>"
                                                        data-tidak="<?= esc($t['makanan_tidak_boleh'] ?? '') ?>"
                                                        data-catatan="<?= esc($t['catatan'] ?? '') ?>">
                                                        <?= esc($t['nama_template'] ?? '-') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label>Status Diet</label>
                                            <input type="text" name="status_diet"
                                                class="form-control statusDiet<?= $p['id'] ?>" required>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Diagnosa</label>
                                            <input type="text" name="diagnosa"
                                                class="form-control diagnosa<?= $p['id'] ?>" required>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Target Kalori (kkal)</label>
                                            <input type="number" name="target_kalori"
                                                class="form-control kalori<?= $p['id'] ?>">
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label>Protein</label>
                                            <input type="number" name="target_protein"
                                                class="form-control protein<?= $p['id'] ?>">
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label>Karbohidrat</label>
                                            <input type="number" name="target_karbohidrat"
                                                class="form-control karbo<?= $p['id'] ?>">
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label>Lemak</label>
                                            <input type="number" name="target_lemak"
                                                class="form-control lemak<?= $p['id'] ?>">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Tanggal Mulai</label>
                                            <input type="date" name="tanggal_mulai" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Tanggal Selesai</label>
                                            <input type="date" name="tanggal_selesai" class="form-control" required>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Makanan Boleh</label>
                                            <textarea name="makanan_boleh" class="form-control boleh<?= $p['id'] ?>"></textarea>
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label>Makanan Tidak Boleh</label>
                                            <textarea name="makanan_tidak_boleh" class="form-control tidak<?= $p['id'] ?>"></textarea>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label>Catatan Ahli Gizi</label>
                                            <textarea name="catatan_ahli_gizi" class="form-control catatan<?= $p['id'] ?>"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Meal Plan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ================= MODAL RIWAYAT ================= -->
                    <div class="modal fade" id="modalHistory<?= $p['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title">
                                        Riwayat Meal Plan - <?= esc($p['nama_lengkap'] ?? '-') ?>
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                        $riwayat = $mealPlanModel
                                            ->where('pasien_id', $p['id'])
                                            ->orderBy('tanggal_mulai', 'DESC')
                                            ->findAll();
                                    ?>

                                    <?php if ($riwayat): ?>
                                        <ul class="list-group">
                                            <?php foreach ($riwayat as $mp): ?>
                                                <li class="list-group-item">
                                                    <b><?= esc($mp['tanggal_mulai'] ?? '-') ?> s/d <?= esc($mp['tanggal_selesai'] ?? '-') ?></b><br>
                                                    Status: <?= esc($mp['status_diet'] ?? '-') ?><br>
                                                    Kalori: <?= esc($mp['target_kalori'] ?? '-') ?> kkal<br>
                                                    Protein: <?= esc($mp['target_protein'] ?? '-') ?> g<br>
                                                    Karbohidrat: <?= esc($mp['target_karbohidrat'] ?? '-') ?> g<br>
                                                    Lemak: <?= esc($mp['target_lemak'] ?? '-') ?> g
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="text-muted">Belum ada riwayat meal plan.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Data pasien belum tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Alert alergi sebelum buka modal
    document.querySelectorAll('.btn-buat-mealplan').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const alergi = this.dataset.alergi;

            if(alergi && alergi.trim() !== ''){
                alert("⚠ Perhatian! Pasien memiliki alergi terhadap: " + alergi);
            }

            // buka modal setelah alert
            $('#modalMealPlan' + id).modal('show');
        });
    });

    // Script template diet
    document.querySelectorAll('.templateSelect').forEach(select => {
        select.addEventListener('change', function () {
            const id = this.dataset.id;
            const opt = this.options[this.selectedIndex];

            document.querySelector('.statusDiet' + id).value = opt.dataset.status || '';
            document.querySelector('.diagnosa' + id).value   = opt.dataset.diagnosa || '';
            document.querySelector('.kalori' + id).value     = opt.dataset.kalori || '';
            document.querySelector('.protein' + id).value    = opt.dataset.protein || '';
            document.querySelector('.karbo' + id).value      = opt.dataset.karbo || '';
            document.querySelector('.lemak' + id).value      = opt.dataset.lemak || '';
            document.querySelector('.boleh' + id).value      = opt.dataset.boleh || '';
            document.querySelector('.tidak' + id).value      = opt.dataset.tidak || '';
            document.querySelector('.catatan' + id).value    = opt.dataset.catatan || '';
        });
    });

});
</script>

<?= $this->endSection() ?>
