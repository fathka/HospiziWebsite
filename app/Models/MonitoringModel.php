<?php

namespace App\Models;

use CodeIgniter\Model;

class MonitoringModel extends Model
{
    protected $table = 'monitoring';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'pasien_id',
        'kunjungan_id',
        'tanggal',
        'waktu_makan',
        'status_kepatuhan',
        'sisa_makanan',
        'catatan',
        'created_at',
        'updated_at',
        'created_by'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // 🔹 Monitoring per tanggal (dashboard ahli gizi)
    public function getByTanggal($tanggal = null)
    {
        if (!$tanggal) {
            $tanggal = date('Y-m-d');
        }

        return $this->select('
                monitoring.*,
                pasien.nama_lengkap,
                pasien.id AS pasien_id
            ')
            ->join('riwayat_kunjungan', 'riwayat_kunjungan.id = monitoring.kunjungan_id')
            ->join('pasien', 'pasien.id = riwayat_kunjungan.pasien_id')
            ->where('monitoring.tanggal', $tanggal)
            ->orderBy('pasien.nama_lengkap', 'ASC')
            ->findAll();
    }

    // 🔹 Riwayat monitoring per pasien
    public function getRiwayatPasien($pasienId, $limit = 5)
    {
        return $this->select('monitoring.*')
            ->join('riwayat_kunjungan', 'riwayat_kunjungan.id = monitoring.kunjungan_id')
            ->where('riwayat_kunjungan.pasien_id', $pasienId)
            ->orderBy('monitoring.tanggal', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
