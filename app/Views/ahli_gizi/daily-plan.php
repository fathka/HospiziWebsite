<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm mb-3">
    <div class="card-body bg-success text-white text-center">
        <h4 class="mb-0">DAILY MEAL PLAN</h4>
        <small>
            <?= esc($mealPlan['status_diet'] ?? '-') ?> |
            <?= esc($mealPlan['diagnosa'] ?? '-') ?>
        </small>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h5>Daftar Daily Meal Plan</h5>
    <a href="<?= base_url('ahli-gizi/menu-harian/create/' . $mealPlan['id'].'/'.date('Y-m-d')) ?>"
       class="btn btn-primary">
        + Tambah Daily Plan
    </a>
</div>


<div class="card shadow-sm">
    <div class="card-body">

        <?php if (empty($dailyPlans)): ?>
            <div class="alert alert-warning text-center">
                Belum ada Daily Plan untuk meal plan ini
            </div>
        <?php endif; ?>

        <?php
        // grouping menu harian berdasarkan tanggal
        $grouped = [];
        foreach ($dailyPlans as $d) {
            $grouped[$d['tanggal']][] = $d;
        }
        ?>

        <?php foreach ($grouped as $tanggal => $menus): ?>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <b><?= date('d M Y', strtotime($tanggal)) ?></b>

                    <a href="<?= base_url('ahli-gizi/menu-harian/create/'.$mealPlan['id'].'/'.$tanggal) ?>"
                       class="btn btn-sm btn-primary">
                        + Tambah Menu
                    </a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="20%">Waktu Makan</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menus as $m): ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= esc($m['waktu_makan'] ?? '-') ?>
                                    </td>
                                    <td>
                                        <?= nl2br(esc($m['nama_menu'] ?? '-')) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url('ahli-gizi/meal-plan') ?>" class="btn btn-secondary">
        ← Kembali ke Meal Plan
    </a>
</div>

<?= $this->endSection() ?>
