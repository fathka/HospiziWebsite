<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;
use App\Models\MealPlanModel;
use App\Models\TemplateDietModel;

class MealPlan extends BaseController
{
    protected $pasienModel;
    protected $mealPlanModel;
    protected $templateDietModel;

    public function __construct()
    {
        $this->pasienModel       = new PasienModel();
        $this->mealPlanModel     = new MealPlanModel();
        $this->templateDietModel = new TemplateDietModel();
    }

    public function aktif($pasienId)
    {
    $mealPlan = $this->mealPlanModel
        ->where('pasien_id', $pasienId)
        ->where('status', 'aktif')
        ->first();

    return view('ahli_gizi/meal_plan_aktif', [
        'mealPlan' => $mealPlan
    ]);
    }


    public function riwayat($pasienId)
{
    $mealPlans = $this->mealPlanModel
        ->where('pasien_id', $pasienId)
        ->orderBy('tanggal_mulai', 'DESC')
        ->findAll();

    return view('ahli_gizi/meal_plan_riwayat', [
        'mealPlans' => $mealPlans
    ]);
}

public function riwayatMenu($mealPlanId)
{
    $menus = $this->menuHarianModel
        ->where('meal_plan_id', $mealPlanId)
        ->orderBy('tanggal', 'ASC')
        ->findAll();

    return view('ahli_gizi/menu_harian_riwayat', [
        'menus' => $menus
    ]);
}


    /**
     * Halaman list pasien aktif
     */
    public function index()
    {
        $pasien = $this->pasienModel->findAll();

        // Tambahkan 'has_meal_plan' supaya tidak undefined
        foreach ($pasien as &$p) {
            $activeMeal = $this->mealPlanModel->getActiveMealPlan($p['id']);

            if ($activeMeal) {
                $p['has_meal_plan'] = true;
                $p['meal_plan_id'] = $activeMeal['id']; // 🔥 INI PENTING
            } else {
                $p['has_meal_plan'] = false;
                $p['meal_plan_id'] = null; // biar aman
            }
        }
        unset($p);

        // Juga load semua template diet untuk modal
        $templates = $this->templateDietModel->findAll();

        return view('ahli_gizi/meal-plan', [
            'title'      => 'Meal Plan Pasien',
            'pasien'     => $pasien,
            'templates'  => $templates,
            'mealPlanModel' => $this->mealPlanModel
        ]);
    }


    /**
     * Detail meal plan pasien
     */
    public function detail($pasienId)
    {
        $pasien = $this->pasienModel->find($pasienId);

        if (!$pasien) {
            return redirect()->to('/ahli-gizi/meal-plan')
                ->with('error', 'Pasien tidak ditemukan');
        }

        return view('ahli_gizi/meal-plan-detail', [
            'title'    => 'Detail Meal Plan',
            'pasien'   => $pasien,
            'mealPlan' => $this->mealPlanModel->getActiveMealPlan($pasienId)
        ]);
    }

    /**
     * Simpan meal plan
     */
    public function store()
    {
        $pasien_id = $this->request->getPost('pasien_id');
        $template_id = $this->request->getPost('template_diet_id'); 

        // 1️⃣ VALIDASI PASIEN
        if (!$this->pasienModel->find($pasien_id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pasien tidak ditemukan atau sudah dihapus');
        }

        // 2️⃣ CEK MEAL PLAN AKTIF
        if ($this->mealPlanModel->getActiveMealPlan($pasien_id)) {
            return redirect()->back()
                ->with('error', 'Pasien sudah memiliki Meal Plan aktif');
        }

        // 3️⃣ DATA MEAL PLAN
        $mealPlanData = [
            'pasien_id'             => $pasien_id,
            'status_diet'           => $this->request->getPost('status_diet'),
            'diagnosa'              => $this->request->getPost('diagnosa'),
            'target_kalori'         => $this->request->getPost('target_kalori'),
            'tanggal_mulai'         => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai'       => $this->request->getPost('tanggal_selesai'),
            'target_protein'        => $this->request->getPost('target_protein'),
            'target_karbohidrat'    => $this->request->getPost('target_karbohidrat'),
            'target_lemak'          => $this->request->getPost('target_lemak'),
            'makanan_boleh'         => $this->request->getPost('makanan_boleh'),
            'makanan_tidak_boleh'   => $this->request->getPost('makanan_tidak_boleh'),
            'catatan_ahli_gizi'     => $this->request->getPost('catatan'),
            'status'                => 'aktif'
        ];

        $this->mealPlanModel->insert($mealPlanData);

        // 4️⃣ SIMPAN TEMPLATE (OPTIONAL)
        if ($this->request->getPost('simpan_template')) {

            $templateData = [
                'nama_template'        => $this->request->getPost('nama_template'),
                'deskripsi'            => $this->request->getPost('deskripsi_template'),
                'status_diet'          => $mealPlanData['status_diet'],
                'diagnosa'             => $mealPlanData['diagnosa'],
                'target_kalori'        => $mealPlanData['target_kalori'],
                'target_protein'       => $mealPlanData['target_protein'],
                'target_karbohidrat'   => $mealPlanData['target_karbohidrat'],
                'target_lemak'         => $mealPlanData['target_lemak'],
                'makanan_boleh'        => $mealPlanData['makanan_boleh'],
                'makanan_tidak_boleh'  => $mealPlanData['makanan_tidak_boleh'],
                'catatan'              => $mealPlanData['catatan'],
            ];

            $this->templateDietModel->insert($templateData);
        }


        return redirect()->to('/ahli-gizi/meal-plan')
            ->with('success', 'Meal Plan berhasil disimpan');
    }
}
