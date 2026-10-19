<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyPlanModel extends Model
{
    protected $table = 'menu_harian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'meal_plan_id',
        'tanggal',
        'waktu_makan',
        'nama_menu',
        'kalori',
        'protein',
        'lemak',
        'karbohidrat'
    ];

    /**
     * Ambil LIST DAILY PLAN (1 hari = 1 baris)
     */
    public function getDailyPlans($mealPlanId)
    {
        return $this->select('tanggal')
            ->where('meal_plan_id', $mealPlanId)
            ->distinct()
            ->orderBy('tanggal', 'ASC')
            ->findAll();
    }

    /**
     * Ambil DETAIL 1 HARI (pagi/siang/malam)
     */
    public function getDailyPlanDetail($mealPlanId, $tanggal)
    {
        return $this->where([
                'meal_plan_id' => $mealPlanId,
                'tanggal'      => $tanggal
            ])
            ->orderBy('waktu_makan', 'ASC')
            ->findAll();
    }
}
