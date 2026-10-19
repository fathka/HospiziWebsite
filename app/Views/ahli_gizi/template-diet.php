<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .card-template {
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        border: none;
    }
    .btn-simpan {
        background-color: #79D1C3;
        color: white;
        font-weight: bold;
        border-radius: 20px;
    }
    .btn-simpan:hover {
        background-color: #68b8ab;
        color: white;
    }
</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="card shadow-sm mb-4" style="background-color: #73CCBF;">
        <div class="card-body text-center">
            <h3 class="mb-0 text-white">TEMPLATE DIET</h3>
            <small class="text-white">Template rencana asuhan gizi berdasarkan kondisi penyakit</small>
        </div>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- FORM TEMPLATE DIET -->
    <div class="card card-template mb-4">
        <div class="card-header font-weight-bold">
            Form Template Diet
        </div>

        <div class="card-body">
            <form action="<?= base_url('ahli-gizi/template-diet/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <!-- Nama Template -->
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Nama Template</label>
                        <input type="text" name="nama_template" class="form-control"
                               placeholder="Contoh: Diet DM, Diet Rendah Garam"
                               required>
                    </div>

                    <!-- Target Kalori -->
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Target Kalori (kkal/hari)</label>
                        <input type="number" name="target_kalori" class="form-control"
                               placeholder="Contoh: 1800">
                    </div>
                </div>

                <!-- Target Makronutrisi -->
                <div class="mb-3">
                    <label class="font-weight-bold">Target Makronutrisi</label>
                    <div class="row">
                        <div class="col-4">
                            <input type="number" name="karbohidrat" class="form-control" placeholder="Karbohidrat (%)">
                            <input type="number" name="protein" class="form-control mt-2" placeholder="Protein (%)">
                            <input type="number" name="lemak" class="form-control mt-2" placeholder="Lemak (%)">
                        </div>
                    </div>
                    <small class="text-muted text-italic">*Total penjumlahan Karbo+Prot+Lemak harus 100%</small>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="font-weight-bold">Deskripsi / Catatan Diet</label>
                    <textarea name="deskripsi" rows="4" class="form-control"
                              placeholder="Jelaskan tujuan diet, indikasi, dan catatan penting..."></textarea>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-simpan px-4">
                        Simpan Template
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- INFO PENGGUNAAN -->
    <div class="card card-template">
        <div class="card-body">
            <h6 class="font-weight-bold">📌 Catatan Penggunaan</h6>
            <ul class="mb-0">
                <li>Template diet digunakan untuk pasien dengan kondisi penyakit yang sama.</li>
                <li>Template dapat diterapkan ke Meal Plan pasien.</li>
                <li>Template memudahkan pembuatan rencana asuhan gizi.</li>
            </ul>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
