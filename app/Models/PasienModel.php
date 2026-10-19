<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table      = 'pasien';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'no_rm', 
        'nama_lengkap', 
        'tanggal_lahir',
        'jenis_penyakit',
        'jenis_kelamin',
        'bangsal', 
        'diagnosa', 
        'alergi_pasien',
        'status_diet'
    ];

    // Ambil pasien + status diet terbaru + meal plan harian
    public function getPasienWithMealPlan($id_pasien)
{
    return $this->select('pasien.*, meal_plan.status_diet, meal_plan.diagnosa')
                ->join('meal_plan', 'meal_plan.pasien_id = pasien.id', 'left')
                ->where('pasien.id', $id_pasien)
                ->orderBy('meal_plan.tanggal_mulai', 'desc')
                ->first();
}

    // Ambil menu harian pasien untuk tanggal tertentu
    public function getMenuHarian($id_pasien, $tanggal)
{
    return $this->db->table('menu_harian')
        ->select('menu_harian.*')
        ->join('meal_plan', 'meal_plan.id = menu_harian.meal_plan_id')
        ->where('meal_plan.pasien_id', $id_pasien)
        ->where('menu_harian.tanggal', $tanggal)
        ->orderBy('menu_harian.waktu_makan', 'asc')
        ->get()
        ->getResultArray();
}

}
