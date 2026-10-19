<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kepatuhan Pasien</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        table, th, td { border: 1px solid black; }
        th { background-color: #68b8ab; color: white; }
        td, th { padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h4>Laporan Kepatuhan Pasien</h4>
    <p>Periode: <?= esc($tanggal_awal) ?> s/d <?= esc($tanggal_akhir) ?></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pasien</th>
                <th>Waktu Makan</th>
                <th>Status Kepatuhan</th>
                <th>Sisa Makanan</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if($monitorings): ?>
                <?php foreach($monitorings as $m): ?>
                <tr>
                    <td><?= date('d-m-Y', strtotime($m['tanggal'])) ?></td>
                    <td><?= esc($m['nama_lengkap']) ?></td>
                    <td><?= ucfirst($m['waktu_makan']) ?></td>
                    <td><?= ucfirst(str_replace('_',' ',$m['status_kepatuhan'])) ?></td>
                    <td><?= $m['sisa_makanan'] ?? '-' ?></td>
                    <td><?= $m['catatan'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Data tidak tersedia</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
