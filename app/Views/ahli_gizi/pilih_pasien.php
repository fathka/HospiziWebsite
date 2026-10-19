<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h4>Monitoring Kepatuhan Pasien</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Pasien</th>
            <th>No RM</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pasien as $p): ?>
        <tr>
            <td><?= $p['nama_lengkap'] ?></td>
            <td><?= $p['no_rm'] ?></td>
            <td>
                <a href="<?= base_url('ahli-gizi/monitoring/'.$p['id']) ?>"
                   class="btn btn-sm btn-primary">
                   Monitoring
                </a>

                <a href="<?= base_url('ahli-gizi/monitoring/riwayat/'.$p['id']) ?>"
                   class="btn btn-sm btn-secondary">
                   Riwayat
                </a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?= $this->endSection() ?>
