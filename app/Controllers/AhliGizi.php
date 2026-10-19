<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\MonitoringModel;
use App\Models\MealPlanModel;
use App\Models\MenuHarianModel;
use Dompdf\Dompdf; // untuk export PDF
use App\Models\RiwayatKunjunganModel;


class AhliGizi extends BaseController
{
    protected $pasienModel;
    protected $monitoringModel;
    protected $mealPlanModel;
    protected $menuHarianModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->monitoringModel = new MonitoringModel();
        $this->mealPlanModel = new MealPlanModel();
        $this->menuHarianModel = new MenuHarianModel();
        helper(['form', 'url']);
    }

    // ===== Dashboard =====
   public function dashboard()
   {
    $today = date('Y-m-d');

    // 1. Ambil semua pasien aktif
    $pasienList = $this->pasienModel
                       ->where('status_aktif', 'aktif')
                       ->findAll();

    // 2. Ambil semua meal plan pasien aktif hari ini
    $mealPlansToday = (new \App\Models\MealPlanModel())
                        ->whereIn('pasien_id', array_column($pasienList, 'id'))
                        ->findAll();

    // 3. Ambil semua monitoring hari ini
    $monitoringsToday = $this->monitoringModel
                             ->where('tanggal', $today)
                             ->findAll();

    // 4. Map monitoring per pasien per waktu makan
    $monitoringMap = [];
    foreach ($monitoringsToday as $m) {
        $monitoringMap[$m['kunjungan_id']][$m['waktu_makan']] = $m;
    }

    // 5. Hitung ringkasan kepatuhan
    $pasienPatuh = 0;
    $pasienPerluPerhatian = 0;
    $pasienTidakPatuh = 0;

    foreach ($pasienList as $p) {
        $statuses = array_column($monitoringMap[$p['id']] ?? [], 'status_kepatuhan');
        if (!$statuses) continue; // belum ada monitoring hari ini

        if (in_array('tidak_patuh', $statuses)) {
            $countTidakPatuh = array_count_values($statuses)['tidak_patuh'];
            if ($countTidakPatuh >= 2) {
                $pasienTidakPatuh++;
            } else {
                $pasienPerluPerhatian++;
            }
        } elseif (in_array('perlu_perhatian', $statuses)) {
            $pasienPerluPerhatian++;
        } elseif (in_array('patuh', $statuses)) {
            $pasienPatuh++;
        }
    }

    $data = [
        'title' => 'Dashboard Ahli Gizi',
        'active_menu' => 'dashboard',
        'tanggal' => date('l, d F Y'),
        'pasienList' => $pasienList,
        'mealPlansToday' => $mealPlansToday,
        'monitoringMap' => $monitoringMap,
        'total_pasien' => count($pasienList),
        'pasien_patuh' => $pasienPatuh,
        'pasien_perlu_perhatian' => $pasienPerluPerhatian,
        'pasien_tidak_patuh' => $pasienTidakPatuh
    ];

    return view('ahli_gizi/dashboard', $data);
}

// 1. FUNGSI HAPUS
public function hapusPasien($id)
{
    // Cek apakah data pasien ada
    $pasien = $this->pasienModel->find($id);
    if (!$pasien) {
        return redirect()->back()->with('error', 'Pasien tidak ditemukan!');
    }

    $this->pasienModel->delete($id);
    return redirect()->to(base_url('ahli-gizi/data-pasien'))->with('success', 'Data pasien berhasil dihapus!');
}

// 2. FUNGSI TAMPIL HALAMAN EDIT
public function editPasien($id)
{
    $pasien = $this->pasienModel->find($id);
    if (!$pasien) {
        return redirect()->back()->with('error', 'Pasien tidak ditemukan!');
    }

    $data = [
        'title'  => 'Edit Data Pasien',
        'pasien' => $pasien
    ];
    
    // Pastikan kamu buat file view ini nanti
    return view('ahli_gizi/edit-pasien', $data);
}

// 3. FUNGSI PROSES UPDATE
public function updatePasien($id)
{
    $data = [
        'no_rm'          => $this->request->getPost('no_rm'),
        'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
        'tanggal_lahir'  => $this->request->getPost('tanggal_lahir'),
        'jenis_kelamin'  => $this->request->getPost('jenis_kelamin'),
        'tanggal_masuk'  => $this->request->getPost('tanggal_masuk'),
        'bangsal'        => $this->request->getPost('bangsal'),
        'alergi_pasien'  => $this->request->getPost('alergi_pasien'),
        'updated_at'     => date('Y-m-d H:i:s')
    ];

    $this->pasienModel->update($id, $data);
    return redirect()->to(base_url('ahli-gizi/data-pasien'))->with('success', 'Data pasien berhasil diperbarui!');
}

    // ===== Monitoring Pasien =====
    public function monitoringPasien()
{
    $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

    $pasienList = $this->pasienModel
        ->where('status_aktif', 'aktif')
        ->findAll();

    $monitoringData = $this->monitoringModel
        ->select('monitoring.*, rk.pasien_id')
        ->join('riwayat_kunjungan rk', 'rk.id = monitoring.kunjungan_id')
        ->where('rk.status', 'aktif')
        ->where('monitoring.tanggal', $tanggal)
        ->findAll();

    $monitoringMap = [];
    foreach ($monitoringData as $m) {
        $monitoringMap[$m['pasien_id']][$m['waktu_makan']] = $m;
    }

    return view('ahli_gizi/monitoring/index', [
        'title' => 'Monitoring Pasien',
        'tanggal' => $tanggal,
        'pasienList' => $pasienList,
        'monitoringMap' => $monitoringMap
    ]);
}


    public function simpanKepatuhan()
    {
    $pasien_id = $this->request->getPost('pasien_id');
    $tanggal = $this->request->getPost('tanggal');
    $waktu_makan = $this->request->getPost('waktu_makan');

    $kunjunganModel = new RiwayatKunjunganModel();
    $monitoringModel = new MonitoringModel();

    $data = [
        'status_kepatuhan' => $this->request->getPost('status_kepatuhan'),
        'sisa_makanan'     => $this->request->getPost('sisa_makanan'),
        'catatan'          => $this->request->getPost('catatan'),
        'updated_at'       => date('Y-m-d H:i:s'),
        'created_by'       => session('ahli_gizi_id')
    ];

    // cek record monitoring hari ini
    $existing = $this->monitoringModel
                     ->where('pasien_id', $pasien_id)
                     ->where('tanggal', $tanggal)
                     ->where('waktu_makan', $waktu_makan)
                     ->first();

    if ($existing) {
        // update
        $this->monitoringModel->update($existing['id'], $data);
    } else {
        // insert baru
        $data['pasien_id'] = $pasien_id;
        $data['tanggal'] = $tanggal;
        $data['waktu_makan'] = $waktu_makan;
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->monitoringModel->insert($data);
    }

    return redirect()->back()->with('success', 'Kepatuhan berhasil disimpan!');
}

    // ===== Laporan =====
    public function laporan()
{
    // Ambil filter dari GET, kalau kosong pakai default
    $tanggal_awal = $this->request->getGet('tanggal_awal') ?? date('Y-m-01');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

    // Ambil data monitoring sesuai periode
    $monitorings = $this->monitoringModel
                        ->select('monitoring.*, pasien.nama_lengkap')
                        ->join('pasien', 'pasien.id = monitoring.pasien_id')
                        ->where('tanggal >=', $tanggal_awal)
                        ->where('tanggal <=', $tanggal_akhir)
                        ->orderBy('tanggal', 'ASC')
                        ->orderBy('waktu_makan', 'ASC')
                        ->findAll();

    // Kirim semua variabel ke view
    $data = [
        'title'         => 'Laporan Monitoring Kepatuhan',
        'active_menu'   => 'laporan',
        'monitorings'   => $monitorings,
        'tanggal_awal'  => $tanggal_awal,
        'tanggal_akhir' => $tanggal_akhir
    ];

    return view('ahli_gizi/laporan', $data);
}


    // Export PDF laporan
    public function exportLaporanPdf()
    {
    $tanggal_awal  = $this->request->getGet('tanggal_awal') ?? date('Y-m-01');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir') ?? date('Y-m-d');

    $monitorings = $this->monitoringModel
                        ->select('monitoring.*, pasien.nama_lengkap')
                        ->join('pasien', 'pasien.id = monitoring.pasien_id')
                        ->where('tanggal >=', $tanggal_awal)
                        ->where('tanggal <=', $tanggal_akhir)
                        ->orderBy('tanggal', 'ASC')
                        ->orderBy('waktu_makan', 'ASC')
                        ->findAll();

    $data = [
        'monitorings'   => $monitorings,
        'tanggal_awal'  => $tanggal_awal,
        'tanggal_akhir' => $tanggal_akhir
    ];

    $html = view('ahli_gizi/laporan_pdf', $data);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream('laporan-monitoring.pdf', ["Attachment" => true]);
}

public function dataPasien()
{
    // Ambil semua pasien aktif
    $pasienList = $this->pasienModel
                       ->where('status_aktif', 'aktif')
                       ->orderBy('nama_lengkap', 'ASC')
                       ->findAll();

    $data = [
        'title' => 'Data Pasien',
        'pasienList' => $pasienList
    ];

    return view('ahli_gizi/data-pasien', $data);
}


public function simpanPasien()
{
    $pasienModel = $this->pasienModel;

    // Ambil data dari form
    $data = [
        'no_rm'        => $this->request->getPost('no_rm'),
        'nama_lengkap' => $this->request->getPost('nama_lengkap'),
        'tanggal_lahir'=> $this->request->getPost('tanggal_lahir'),
        'jenis_kelamin'=> $this->request->getPost('jenis_kelamin'),
        'tanggal_masuk'=> $this->request->getPost('tanggal_masuk'),
        'alergi_pasien'=> $this->request->getPost('alergi_pasien'),
        'status_aktif' => 'aktif', // default aktif
        'created_at'   => date('Y-m-d H:i:s')
    ];

    // Simpan ke database
    $pasienModel->insert($data);

    return redirect()->back()->with('success', 'Data pasien berhasil disimpan!');
}

// ===== FITUR MEAL PLAN & DAILY PLAN =====

public function mealPlan()
{
    // Mengambil semua meal plan beserta nama pasiennya
    $mealPlans = $this->mealPlanModel
                      ->select('meal_plan.*, pasien.nama_lengkap, pasien.no_rm')
                      ->join('pasien', 'pasien.id = meal_plan.pasien_id')
                      ->where('pasien.status_aktif', 'aktif')
                      ->findAll();

    $data = [
        'title'      => 'Manajemen Meal Plan',
        'active_menu'=> 'meal-plan',
        'mealPlans'  => $mealPlans
    ];

    return view('ahli_gizi/meal-plan', $data);
}

public function dailyPlan($mealPlanId)
{
    $mealPlan = $this->mealPlanModel->find($mealPlanId);
    if (!$mealPlan) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    // Ambil semua menu harian (daily plan) untuk meal plan ini
    $dailyPlans = $this->menuHarianModel
                       ->where('meal_plan_id', $mealPlanId)
                       ->orderBy('tanggal', 'DESC')
                       ->findAll();

    $data = [
        'title'      => 'Daftar Menu Harian',
        'mealPlan'   => $mealPlan,
        'dailyPlans' => $dailyPlans
    ];

    return view('ahli_gizi/daily-plan', $data);
}

public function dailyPlanDetail($mealPlanId, $tanggal)
{
    // Mengambil detail menu pada tanggal tertentu untuk dihitung total nutrisinya
    $menus = $this->menuHarianModel
                  ->where('meal_plan_id', $mealPlanId)
                  ->where('tanggal', $tanggal)
                  ->findAll();

    $data = [
        'title'      => 'Detail Nutrisi Harian',
        'menus'      => $menus,
        'tanggal'    => $tanggal,
        'mealPlanId' => $mealPlanId
    ];

    return view('ahli_gizi/daily-plan-detail', $data);
}

public function createMenuHarian($mealPlanId, $tanggal)
{
    // Method untuk menampilkan form tambah menu harian
    $data = [
        'title'      => 'Tambah Menu Harian',
        'mealPlanId' => $mealPlanId,
        'tanggal'    => $tanggal
    ];

    return view('ahli_gizi/menu-harian-create', $data);
}

public function simpanMenuHarian()
{
    // Method untuk memproses simpan menu harian
    $mealPlanId = $this->request->getPost('meal_plan_id');
    
    $data = [
        'meal_plan_id' => $mealPlanId,
        'tanggal'      => $this->request->getPost('tanggal'),
        'waktu_makan'  => $this->request->getPost('waktu_makan'),
        'nama_menu'    => $this->request->getPost('nama_menu'),
        'kalori'       => $this->request->getPost('kalori'),
        'protein'      => $this->request->getPost('protein'),
        'lemak'        => $this->request->getPost('lemak'),
        'karbohidrat'  => $this->request->getPost('karbohidrat'),
    ];

    $this->menuHarianModel->insert($data);

    return redirect()->to(base_url('ahli-gizi/daily-plan/' . $mealPlanId))
                     ->with('success', 'Menu harian berhasil ditambahkan');
}
public function index()
    {
        $pasienId = session()->get('id_pasien'); // ambil id pasien dari session

        // Ambil status diet pasien (dari ahli gizi)
        $statusDiet = $this->mealPlanModel->getStatusDietByPasien($pasienId);

        // Ambil menu harian pasien
        $menuHarian = $this->menuHarianModel->getMenuHarianByPasien($pasienId);

        // Ambil status kepatuhan pasien per waktu makan
        $monitoringData = $this->monitoringModel->getMonitoringByPasien($pasienId);

        // Mapping agar mudah dipanggil di view
        $monitoringMap = [];
        foreach ($monitoringData as $m) {
            $monitoringMap[$m['waktu_makan']] = [
                'status' => $m['status']  // misal "Patuh" / "Tidak Patuh"
            ];
        }

        // Kirim semua data ke view
        return view('pasien/dashboard', [
            'statusDiet' => $statusDiet,
            'menuHarian' => $menuHarian,
            'monitoringMap' => $monitoringMap
        ]);
    }
}

