<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    /* Menggunakan style unik kamu */
    .container-edit-hospizi {
        background-color: #E2F3F0; 
        border-radius: 35px;
        border: 4px solid #BEE9E2;
        padding: 30px;
        max-width: 800px;
        margin: 20px auto;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    }
    
    .form-header-hospizi {
        background-color: #79D1C3;
        color: white;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
        font-size: 1.2rem;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        border: none;
        width: 100%;
    }

    .title-data-pasien {
        color: #3D5A56;
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .label-hospizi {
        color: #4A706A;
        font-weight: 700;
        margin-bottom: 3px;
        font-size: 0.9rem;
    }

    .input-hospizi {
        border-radius: 12px !important;
        border: 2px solid #888 !important;
        background-color: white !important;
        padding: 8px 15px !important;
        height: 45px !important;
        box-shadow: inset 0 4px 6px rgba(0,0,0,0.2) !important; 
    }

    .input-alergi {
        background-color: #D67D6E !important; 
        border: 2px solid #B55F52 !important;
        color: white !important;
    }

    .btn-update-hospizi {
        background-color: #3E5F58 !important;
        color: white !important;
        border-radius: 15px !important;
        padding: 12px !important;
        font-weight: bold !important;
        border: none !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.2);
    }

    .btn-batal-hospizi {
        background-color: #C3E492 !important;
        color: #555 !important;
        border-radius: 15px !important;
        padding: 12px !important;
        font-weight: bold !important;
        border: none !important;
    }
</style>

<div class="container-fluid">
    <div class="container-edit-hospizi">
        
        <div class="form-header-hospizi">
            EDIT DATA PASIEN: <?= esc($pasien['nama_lengkap']) ?>
        </div>

        <form action="<?= base_url('ahli-gizi/update-pasien/' . $pasien['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <h2 class="title-data-pasien">Update Data</h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="label-hospizi">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= esc($pasien['nama_lengkap']) ?>" class="input-hospizi form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="label-hospizi">NO RM</label>
                        <input type="text" name="no_rm" value="<?= esc($pasien['no_rm']) ?>" class="input-hospizi form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="label-hospizi">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="<?= $pasien['tanggal_lahir'] ?>" class="input-hospizi form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label class="label-hospizi">Bangsal</label>
                        <input type="text" name="bangsal" value="<?= esc($pasien['bangsal']) ?>" class="input-hospizi form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="label-hospizi">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" value="<?= $pasien['tanggal_masuk'] ?>" class="input-hospizi form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label class="label-hospizi">Jenis Diet</label>
                        <input type="text" name="status_diet" value="<?= esc($pasien['status_diet'] ?? '') ?>" class="input-hospizi form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label class="label-hospizi">Diagnosa</label>
                        <input type="text" name="diagnosa" value="<?= esc($pasien['diagnosa'] ?? '') ?>" class="input-hospizi form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label class="label-hospizi">Berat Badan Awal</label>
                        <input type="text" name="berat_badan" value="<?= esc($pasien['berat_badan'] ?? '') ?>" class="input-hospizi form-control">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mb-2">
                        <label class="label-hospizi">Alergi Pasien</label>
                        <input type="text" name="alergi_pasien" value="<?= esc($pasien['alergi_pasien']) ?>" class="input-hospizi form-control input-alergi">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <a href="<?= base_url('ahli-gizi/data-pasien') ?>" class="btn btn-batal-hospizi w-100">Batal</a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-update-hospizi w-100">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>