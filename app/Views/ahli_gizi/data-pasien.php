<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .card-filter { border-radius: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: none; }
    .card-table { border-radius: 25px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: none; overflow: hidden; }
    .header-table { background-color: #79D1C3; color: white; border: none; }
    .btn-tambah { background-color: #F2D36B; color: white; border-radius: 20px; font-weight: bold; border: none; padding: 5px 25px; }
    .btn-tambah:hover { background-color: #e6c55a; color: white; }
    .table thead th { border: none; font-size: 10px; text-transform: uppercase; color: #555; background-color: #f8f9fa; }
    .form-control-custom { border-radius: 20px; border: 1px solid #ddd; }
    .btn-cari { background-color: #79D1C3; border: none; border-radius: 20px; color: white; font-weight: bold; }
    .btn-cari:hover { background-color: #68b8ab; color: white; }
</style>

<div class="card shadow-sm mb-4" style="background-color: #73CCBF;">
    <h3 class="text-center mb-4" style="color: #fff;">DATA PASIEN</h3>
</div>

<div class="container-fluid">

    <!-- Filter Pencarian -->
    <div class="card card-filter mb-4">
        <div class="card-body">
            <h6 class="font-weight-bold mb-3">Filter Pencarian</h6>
            <form action="" method="GET" class="row align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold">Nama</label>
                    <input type="text" name="keyword" class="form-control form-control-custom" placeholder="Cari nama...">
                </div>
                <div class="col-md-2">
                    <label class="small font-weight-bold">No RM</label>
                    <input type="text" name="no_rm" class="form-control form-control-custom" placeholder="RM-XXX">
                </div>
                <div class="col-md-2">
                    <label class="small font-weight-bold">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control form-control-custom">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold">Bangsal</label>
                    <input type="text" name="bangsal" class="form-control form-control-custom" placeholder="Nama Bangsal">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-cari btn-block">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data Pasien -->
    <div class="card card-table">
        <div class="card-header header-table d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 font-weight-bold">Data Pasien</h5>
            <button class="btn btn-tambah shadow-sm" data-toggle="modal" data-target="#modalTambahPasien">+ Tambah</button>
        </div>
        <div class="table-responsive">
            <table class="table table-borderless table-hover mb-0">
                <thead>
                    <tr>
                        <th>No RM</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>Tanggal Masuk</th>
                        <th>Bangsal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pasienList)) : ?>
                        <?php foreach ($pasienList as $p) : ?>
                            <tr>
                                <td><?= $p['no_rm']; ?></td>
                                <td><?= $p['nama_lengkap']; ?></td>
                                <td><?= $p['tanggal_lahir']; ?></td>
                                <td><?= $p['tanggal_masuk'] ?? '-' ?></td>
                                <td><?= $p['bangsal'] ?? '-' ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('ahli-gizi/edit-pasien/' . $p['id']) ?>" class="btn btn-sm btn-warning text-white rounded-pill">Edit</a>
                                    <button onclick="hapusPasien(<?= $p['id'] ?>)" class="btn btn-sm btn-danger rounded-pill">Hapus</button>
                                    <a href="<?= base_url('ahli-gizi/detail-pasien/' . $p['id']) ?>" class="btn btn-sm btn-info text-white rounded-pill">Detail</a>
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pasien.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah Pasien -->
<div class="modal fade" id="modalTambahPasien" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg border-0">
        <div class="modal-content card-table">
            <div class="modal-header header-table border-0">
                <h5 class="modal-title font-weight-bold">Form Tambah Pasien</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('ahli-gizi/simpanPasien') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body bg-white p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="small font-weight-bold">No RM</label>
                            <input type="text" name="no_rm" class="form-control form-control-custom mb-3" required>

                            <label class="small font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control form-control-custom mb-3" required>

                            <label class="small font-weight-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-custom mb-3" required>

                            <label class="small font-weight-bold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control form-control-custom mb-3" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small font-weight-bold">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control form-control-custom mb-3">

                            <label class="small font-weight-bold">Bangsal</label>
                            <input type="text" name="bangsal" class="form-control form-control-custom mb-3">

                            <label class="small font-weight-bold">Alergi Pasien</label>
                            <input type="text" name="alergi_pasien" class="form-control form-control-custom mb-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-start">
                    <button type="button" class="btn btn-light px-4 rounded-pill" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-tambah px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function hapusPasien(id) {
    if(confirm('Yakin ingin menghapus data ini?')) {
        window.location.href = "<?= base_url('ahli-gizi/hapus-pasien/') ?>/" + id;
    }
}
</script>

<?= $this->endSection() ?>
