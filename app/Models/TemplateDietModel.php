<?php

namespace App\Models;

use CodeIgniter\Model;

class TemplateDietModel extends Model
{
    protected $table            = 'template_diet';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nama_template',
        'deskripsi',
        'status_diet',
        'diagnosa',
        'target_kalori',
        'target_protein',
        'target_karbohidrat',
        'target_lemak',
        'makanan_boleh',
        'makanan_tidak_boleh',
        'catatan_ahli_gizi',
        'created_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /* =========================
       CUSTOM METHODS
       ========================= */

    // Ambil semua template diet
    public function getAllTemplate()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    // Ambil template diet by ID
    public function getTemplateById($id)
    {
        return $this->find($id);
    }

    // Ambil template diet buatan ahli gizi tertentu
    public function getTemplateByAhliGizi($ahliGiziId)
    {
        return $this->where('created_by', $ahliGiziId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
