<?php

namespace App\Models;

use CodeIgniter\Model;

class LogDietModel extends Model
{
    protected $table = 'log_diet';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pasien_id',
        'meal_plan_id',
        'jenis_perubahan',
        'diet_sebelum',
        'diet_sesudah',
        'alasan_perubahan',
        'tanggal_perubahan',
        'created_by'
    ];

    protected $useTimestamps = false;

    public function getRiwayatKepatuhan()
    {
        return $this->select('
                log_diet.*,
                pasien.nama_lengkap,
                pasien.no_rm
            ')
            ->join('pasien', 'pasien.id = log_diet.pasien_id')
            ->where('jenis_perubahan', 'kepatuhan_meal_plan')
            ->orderBy('tanggal_perubahan', 'DESC')
            ->findAll();
    }
}
