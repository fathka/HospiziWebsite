<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatKunjunganModel extends Model
{
    protected $table = 'riwayat_kunjungan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'pasien_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
