<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuHarianModel extends Model
{
    protected $table = 'menu_harian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'meal_plan_id',
        'tanggal',
        'waktu_makan',
        'nama_menu',
        'bahan_makanan',
        'kalori',
        'protein',
        'karbohidrat',
        'lemak',
        'catatan'
    ];
    protected $useTimestamps = true; // otomatis created_at & updated_at
    
    public function getMenuHarianByPasien($mealPlanId)
    {
        return $this->where('meal_plan_id', $mealPlanId)
                    ->orderBy('tanggal', 'DESC')
                    ->orderBy('waktu_makan', 'ASC')
                    ->findAll();
    }
}
