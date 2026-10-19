<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuHarianModel;
use App\Models\MealPlanModel;
use App\Models\PasienModel;

class MenuHarian extends BaseController
{
    protected $menuHarianModel;
    protected $mealPlanModel;
    protected $pasienModel;

    public function __construct()
    {
        $this->menuHarianModel = new MenuHarianModel();
        $this->mealPlanModel = new MealPlanModel();
        $this->pasienModel = new PasienModel();
    }

    // Halaman utama menu harian
    public function index($mealPlanId = null)
    {
        $data['menus'] = $this->menuHarianModel->getByMealPlan($mealPlanId);
        $data['mealPlanId'] = $mealPlanId;

        return view('menu_harian/index', $data);
    }

    public function create($mealPlanId, $tanggal = null)
{
    $mealPlan = $this->mealPlanModel->find($mealPlanId);
    if (!$mealPlan) return redirect()->back()->with('error', 'Meal Plan tidak ditemukan');

    $pasien = $this->pasienModel->find($mealPlan['pasien_id']);
    $tanggal = $tanggal ?? date('Y-m-d');

    return view('ahli_gizi/menu-harian-form', [
        'mealPlan' => $mealPlan,
        'pasien'   => $pasien,
        'tanggal'  => $tanggal
    ]);
}



    // Method untuk menyimpan menu baru
    public function store()
    {
        $data = [
            'meal_plan_id'  => $this->request->getPost('meal_plan_id'),
            'tanggal'       => $this->request->getPost('tanggal'),
            'waktu_makan'   => $this->request->getPost('waktu_makan'),
            'nama_menu'     => $this->request->getPost('nama_menu'),
            'bahan_makanan' => $this->request->getPost('bahan_makanan'),
            'kalori'        => $this->request->getPost('kalori'),
            'protein'       => $this->request->getPost('protein'),
            'karbohidrat'   => $this->request->getPost('karbohidrat'),
            'lemak'         => $this->request->getPost('lemak'),
            'catatan'       => $this->request->getPost('catatan'),
        ];

        $mealPlanId = $this->request->getPost('meal_plan_id');
        $tanggal    = $this->request->getPost('tanggal');
        $waktu      = $this->request->getPost('waktu_makan');

        // CEK MEAL PLAN
        $mealPlan = $this->mealPlanModel->find($mealPlanId);
        if (!$mealPlan || $mealPlan['status'] !== 'aktif') {
            return redirect()->back()
                ->with('error', 'Meal plan sudah selesai / tidak aktif');
        }

        // CEK DUPLIKAT MENU
        if ($this->menuHarianModel->isMenuExist($mealPlanId, $tanggal, $waktu)) {
            return redirect()->back()
                ->with('error', 'Menu untuk waktu makan ini sudah ada');
        }
        
        $this->menuHarianModel->insert($data);

        return redirect()->back()->with('success', 'Menu harian berhasil ditambahkan!');
    }

    // Method untuk menghapus menu
    public function delete($id)
    {
        $this->menuHarianModel->delete($id);
        return redirect()->back()->with('success', 'Menu harian berhasil dihapus!');
    }

    // Method update menu harian
    public function update($id)
    {
        $data = [
            'nama_menu' => $this->request->getPost('nama_menu'),
            'waktu_makan'      => $this->request->getPost('waktu_makan'),
            'jumlah'    => $this->request->getPost('jumlah'),
            'keterangan'=> $this->request->getPost('keterangan'),
        ];

        $this->menuHarianModel->update($id, $data);
        return redirect()->back()->with('success', 'Menu harian berhasil diupdate!');
    }
}
