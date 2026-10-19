<h5>Riwayat Monitoring</h5>

<table class="table table-bordered">
<tr>
    <th>Tanggal</th>
    <th>Waktu</th>
    <th>Status</th>
    <th>Sisa</th>
</tr>
<?php foreach ($monitoring as $m): ?>
<tr>
    <td><?= $m['tanggal'] ?></td>
    <td><?= $m['waktu_makan'] ?></td>
    <td><?= $m['status_kepatuhan'] ?></td>
    <td><?= $m['sisa_makan'] ?></td>
</tr>
<?php endforeach ?>
</table>
