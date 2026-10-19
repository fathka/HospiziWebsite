<?php

namespace App\Models;

use CodeIgniter\Model;

class MealPlanModel extends Model
{
    protected $table = 'meal_plan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pasien_id',
        'template_diet_id',
        'jenis_diet',
        'target_kalori',
        'target_protein',
        'target_karbohidrat',
        'target_lemak',
        'makanan_boleh',
        'makanan_tidak_boleh',
        'catatan_ahli_gizi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'created_by'
    ];

    protected $useTimestamps = true;

    // ===============================
    // MEAL PLAN AKTIF (OPERASIONAL)
    // ===============================
    public function getActiveMealPlan($pasienId)
    {
        return $this->where('pasien_id', $pasienId)
            ->where('status', 'aktif')
            ->where('tanggal_mulai <=', date('Y-m-d'))
            ->where('tanggal_selesai >=', date('Y-m-d'))
            ->first();
    }

    // ===============================
    // RIWAYAT MEAL PLAN (SEMUA)
    // ===============================
    public function getRiwayatMealPlan($pasienId)
    {
        return $this->where('pasien_id', $pasienId)
            ->orderBy('tanggal_mulai', 'DESC')
            ->findAll();
    }

    // ===============================
    // AUTO SELESAIKAN MEAL PLAN EXPIRED
    // ===============================
    public function nonaktifkanMealPlanExpired()
    {
        return $this->where('status', 'aktif')
            ->where('tanggal_selesai <', date('Y-m-d'))
            ->set(['status' => 'selesai'])
            ->update();
    }
}
