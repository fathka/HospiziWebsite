<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MonitoringModel;
use App\Models\RiwayatKunjunganModel;

class Monitoring extends BaseController
{
    protected $monitoringModel;
    protected $kunjunganModel;

    public function __construct()
    {
        $this->monitoringModel = new MonitoringModel();
        $this->kunjunganModel  = new RiwayatKunjunganModel();
    }

    public function simpan()
    {
        $pasienId     = $this->request->getPost('pasien_id');
        $tanggal      = $this->request->getPost('tanggal');
        $waktuMakan   = $this->request->getPost('waktu_makan');
        $kepatuhan    = $this->request->getPost('status_kepatuhan');
        $sisaMakanan  = $this->request->getPost('sisa_makanan');
        $catatan      = $this->request->getPost('catatan');

        // 1️⃣ Ambil kunjungan AKTIF pasien
        $kunjungan = $this->kunjunganModel
            ->where('pasien_id', $pasienId)
            ->where('status', 'aktif')
            ->first();

        if (!$kunjungan) {
            return redirect()->back()
                ->with('error', 'Pasien belum memiliki kunjungan aktif');
        }

        // 2️⃣ Cek apakah monitoring sudah ada
        $existing = $this->monitoringModel
            ->where('kunjungan_id', $kunjungan['id'])
            ->where('tanggal', $tanggal)
            ->where('waktu_makan', $waktuMakan)
            ->first();

        $data = [
            'kunjungan_id'     => $kunjungan['id'],
            'tanggal'          => $tanggal,
            'waktu_makan'      => $waktuMakan,
            'status_kepatuhan' => $kepatuhan,
            'sisa_makanan'     => $sisaMakanan,
            'catatan'          => $catatan,
        ];

        // 3️⃣ Update / Insert
        if ($existing) {
            $this->monitoringModel->update($existing['id'], $data);
            $pesan = 'Monitoring berhasil diperbarui';
        } else {
            $this->monitoringModel->insert($data);
            $pesan = 'Monitoring berhasil disimpan';
        }

        return redirect()->back()->with('success', $pesan);
    }
}
