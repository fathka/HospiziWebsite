<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;

class Pasien extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }

    // Dashboard pasien
    public function dashboard()
    {
        $session = session();
        $pasien_id = $session->get('pasien_id');

        // Redirect ke login kalau pasien belum login
        if (!$pasien_id) {
            return redirect()->to('/pasien/login');
        }

        // Ambil data pasien + status diet terbaru
        $pasien = $this->pasienModel->getPasienWithMealPlan($pasien_id);

        // Ambil menu harian pasien dari tabel menu_harian
        $menu_harian = $this->pasienModel->getMenuHarian($pasien_id, date('Y-m-d'));

        // Ambil monitoring kepatuhan pasien jika ada
        $kepatuhan = $this->getMonitoringKepatuhan($pasien_id);

        return view('pasien/dashboard', [
            'pasien' => $pasien,
            'menu_harian' => $menu_harian,
            'kepatuhan' => $kepatuhan
        ]);
    }

    // Halaman menu makan (opsional)
    public function menuMakan()
    {
        return view('pasien/menu_makan');
    }

    // Halaman daftar makanan (opsional)
    public function daftarMakanan()
    {
        return view('pasien/daftar_makanan');
    }

    // Halaman monitoring kepatuhan
    public function monitoring()
    {
        $session = session();
        $id_pasien = $session->get('id_pasien');

        if (!$id_pasien) {
            return redirect()->to('/login');
        }

        $kepatuhan = $this->getMonitoringKepatuhan($id_pasien);

        return view('pasien/monitoring', [
            'kepatuhan' => $kepatuhan
        ]);
    }

    // Method private untuk ambil monitoring kepatuhan pasien
    private function getMonitoringKepatuhan($id_pasien)
    {
        $db = \Config\Database::connect();
        return $db->table('monitoring')
            ->where('pasien_id', $id_pasien)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->getResultArray();
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
