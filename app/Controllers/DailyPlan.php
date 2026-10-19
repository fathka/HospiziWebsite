<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DailyPlanModel;
use App\Models\MealPlanModel;

class DailyPlan extends BaseController
{
    protected $dailyPlanModel;
    protected $mealPlanModel;

    public function __construct()
    {
        $this->dailyPlanModel = new DailyPlanModel();
        $this->mealPlanModel  = new MealPlanModel();
    }

    public function index($mealPlanId)
    {
        $mealPlan = $this->mealPlanModel->find($mealPlanId);

        if (!$mealPlan) {
            return redirect()->back()->with('error', 'Meal Plan tidak ditemukan');
        }

        $dailyPlans = $this->dailyPlanModel
            ->where('meal_plan_id', $mealPlanId)
            ->orderBy('tanggal', 'ASC')
            ->orderBy('waktu_makan', 'ASC')
            ->findAll();

        return view('ahli_gizi/daily-plan', [
            'mealPlan'   => $mealPlan,
            'dailyPlans' => $dailyPlans
        ]);
    }
}
