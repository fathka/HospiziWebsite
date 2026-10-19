<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model Ahli Gizi
 */
class AhliGiziModel extends Model
{
    protected $table = 'ahli_gizi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}

/**
 * Model Pasien
 */
class PasienModel extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'no_rm', 'nama_lengkap', 'tanggal_lahir','jenis_kelamin',
        'bangsal', 'kamar', 'diagnosa', 'status_diet', 'tanggal_masuk',
        'berat_badan', 'tinggi_badan', 'alergi_pasien', 'catatan_khusus',
        'status_aktif', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Cari pasien berdasarkan No RM dan Tanggal Lahir
    public function verifyPasien($noRM, $tanggalLahir)
    {
        return $this->where('no_rm', $noRM)
                    ->where('tanggal_lahir', $tanggalLahir)
                    ->where('status_aktif', 'aktif')
                    ->first();
    }
    
    // Ambil pasien dengan status monitoring
    public function getPasienWithMonitoring($bangsal = null)
    {
        $builder = $this->db->table('pasien p');
        $builder->select('p.*, 
            COUNT(CASE WHEN m.status_kepatuhan = "tidak_habis" 
                AND m.tanggal >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) 
                THEN 1 END) as tidak_patuh_count');
        $builder->join('monitoring m', 'm.pasien_id = p.id', 'left');
        $builder->where('p.status_aktif', 'aktif');
        
        if ($bangsal) {
            $builder->where('p.bangsal', $bangsal);
        }
        
        $builder->groupBy('p.id');
        return $builder->get()->getResultArray();
    }
    
    // Statistik per bangsal
    public function getStatistikPerBangsal()
    {
        return $this->select('bangsal, status_diet, COUNT(*) as jumlah')
                    ->where('status_aktif', 'aktif')
                    ->groupBy(['bangsal', 'status_diet'])
                    ->findAll();
    }
}

/**
 * Model Template Diet
 */
class TemplateDietModel extends Model
{
    protected $table = 'template_diet';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_template', 'deskripsi', 'target_kalori',
        'target_makronutrisi', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}


/**
 * Model Menu Harian
 */
class MenuHarianModel extends Model
{
    protected $table = 'menu_harian';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'meal_plan_id', 'tanggal', 'waktu_makan', 'nama_menu',
        'bahan_makanan', 'kalori', 'protein', 'karbohidrat', 'lemak', 'catatan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Ambil menu untuk tanggal tertentu
    public function getMenuByDate($mealPlanId, $tanggal)
    {
        return $this->where('meal_plan_id', $mealPlanId)
                    ->where('tanggal', $tanggal)
                    ->orderBy('waktu_makan', 'ASC')
                    ->findAll();
    }
    
    // Ambil menu hari ini untuk pasien
    public function getMenuHariIni($pasienId)
    {
        $builder = $this->db->table('menu_harian mh');
        $builder->select('mh.*');
        $builder->join('meal_plan mp', 'mp.id = mh.meal_plan_id');
        $builder->where('mp.pasien_id', $pasienId);
        $builder->where('mp.status', 'aktif');
        $builder->where('mh.tanggal', date('Y-m-d'));
        $builder->orderBy('mh.waktu_makan', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}

/**
 * Model Monitoring
 */
class MonitoringModel extends Model
{
    protected $table = 'monitoring';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pasien_id', 'tanggal', 'waktu_makan', 'status_kepatuhan',
        'sisa_makanan', 'catatan', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = false;
    
    // Cek status kepatuhan 2 hari terakhir
    public function checkKepatuhan($pasienId)
    {
        $result = $this->where('pasien_id', $pasienId)
                       ->where('tanggal >=', date('Y-m-d', strtotime('-2 days')))
                       ->where('status_kepatuhan', 'tidak_habis')
                       ->countAllResults();
        
        return $result >= 2; // True jika tidak patuh >= 2 hari
    }
    
    // Riwayat monitoring pasien
    public function getRiwayatMonitoring($pasienId, $limit = 7)
    {
        return $this->where('pasien_id', $pasienId)
                    ->orderBy('tanggal', 'DESC')
                    ->orderBy('waktu_makan', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}

/**
 * Model Log Diet
 */
class LogDietModel extends Model
{
    protected $table = 'log_diet';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'pasien_id', 'meal_plan_id', 'jenis_perubahan',
        'diet_sebelum', 'diet_sesudah', 'alasan_perubahan', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'tanggal_perubahan';
    protected $updatedField = false;
    
    // Riwayat perubahan diet pasien
    public function getRiwayatPerubahan($pasienId)
    {
        return $this->select('log_diet.*, ahli_gizi.nama_lengkap as nama_ahli_gizi')
                    ->join('ahli_gizi', 'ahli_gizi.id = log_diet.created_by', 'left')
                    ->where('log_diet.pasien_id', $pasienId)
                    ->orderBy('log_diet.tanggal_perubahan', 'DESC')
                    ->findAll();
    }
}

/**
 * Model Edukasi Gizi
 */
class EdukasiGiziModel extends Model
{
    protected $table = 'edukasi_gizi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'judul', 'konten', 'kategori', 'gambar', 'status', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Ambil edukasi aktif
    public function getEdukasiAktif($kategori = null)
    {
        $builder = $this->where('status', 'aktif');
        
        if ($kategori) {
            $builder->where('kategori', $kategori);
        }
        
        return $builder->orderBy('created_at', 'DESC')->findAll();
    }
}