<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card p-4 shadow-sm">
    <h4 class="mb-3">
        Menu Harian - <?= date('d M Y', strtotime($tanggal)) ?>
    </h4>

    <?php if (empty($menus)) : ?>
        <div class="alert alert-warning">
            Tidak ada menu pada tanggal ini
        </div>
    <?php endif ?>

    <?php
        $totalKalori = 0;
        $totalProtein = 0;
        $totalLemak = 0;
        $totalKarbo = 0;
    ?>

    <?php foreach ($menus as $menu) : ?>
        <?php
            $totalKalori += $menu['kalori'];
            $totalProtein += $menu['protein'];
            $totalLemak += $menu['lemak'];
            $totalKarbo += $menu['karbohidrat'];
        ?>

        <div class="card mb-3 border">
            <div class="card-header fw-bold text-uppercase">
                <?= $menu['waktu_makan'] ?>
            </div>
            <div class="card-body">
                <p><strong>Menu:</strong> <?= $menu['menu'] ?></p>
                <div class="row">
                    <div class="col-md-3">Kalori: <?= $menu['kalori'] ?> kkal</div>
                    <div class="col-md-3">Protein: <?= $menu['protein'] ?> g</div>
                    <div class="col-md-3">Lemak: <?= $menu['lemak'] ?> g</div>
                    <div class="col-md-3">Karbo: <?= $menu['karbohidrat'] ?> g</div>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- TOTAL -->
    <div class="card mt-4 bg-light">
        <div class="card-body">
            <h5>Total Asupan Harian</h5>
            <div class="row">
                <div class="col-md-3"><b>Kalori:</b> <?= $totalKalori ?> kkal</div>
                <div class="col-md-3"><b>Protein:</b> <?= $totalProtein ?> g</div>
                <div class="col-md-3"><b>Lemak:</b> <?= $totalLemak ?> g</div>
                <div class="col-md-3"><b>Karbo:</b> <?= $totalKarbo ?> g</div>
            </div>
        </div>
    </div>

    <a href="<?= base_url('ahli-gizi/daily-plan/' . service('uri')->getSegment(4)) ?>"
       class="btn btn-secondary mt-3">
        Kembali
    </a>
</div>

<?= $this->endSection() ?>
