<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::login');

/**
 * AUTH
 */
$routes->get('auth/login', 'Auth::login', ['filter' => 'alreadylogged']);
$routes->post('auth/login', 'Auth::loginProcess');
$routes->get('auth/logout', 'Auth::logout');

/**
 * AHLI GIZI (PROTECTED BY MIDDLEWARE)
 */
$routes->group('ahli-gizi', ['filter' => 'authAhliGizi'], function ($routes) {
    $routes->get('dashboard', 'AhliGizi::dashboard');
    $routes->get('data-pasien','AhliGizi::dataPasien');
    //$routes->get('meal-plan', 'AhliGizi::mealPlan');
    $routes->get('meal-plan', 'MealPlan::index');
    $routes->get('meal-plan/create/(:num)', 'MealPlan::create/$1'); // pasien_id
    $routes->post('meal-plan/store', 'MealPlan::store');
    $routes->get('meal-plan/template/(:num)', 'MealPlan::getTemplate/$1');

    $routes->post('meal-plan/save-template', 'MealPlan::saveTemplate');
    $routes->get('meal-plan/detail/(:num)', 'MealPlan::detail/$1');
    $routes->get('monitoring-pasien', 'AhliGizi::monitoringPasien');
    $routes->get('laporan', 'AhliGizi::laporan');
    $routes->post('simpan-kepatuhan', 'AhliGizi::simpanKepatuhan');
    $routes->get('export-laporan-pdf', 'AhliGizi::exportLaporanPdf');
    $routes->post('simpan-pasien', 'AhliGizi::simpanPasien');
    $routes->get('edit-pasien/(:num)', 'AhliGizi::editPasien/$1');
    $routes->post('update-pasien/(:num)', 'AhliGizi::updatePasien/$1');
    $routes->get('hapus-pasien/(:num)', 'AhliGizi::hapusPasien/$1');
    $routes->get('detail-pasien/(:num)', 'AhliGizi::detailPasien/$1');

    $routes->get('daily-plan/(:num)', 'DailyPlan::index/$1');
    $routes->get('daily-plan/detail/(:num)/(:segment)', 'DailyPlan::detail/$1/$2');
    $routes->get('menu-harian/(:num)', 'MenuHarian::index/$1');
    $routes->post('daily-plan/store', 'DailyPlan::storeMenu');
    $routes->get('menu-harian/delete/(:num)', 'MenuHarian::delete/$1');
    $routes->post('menu-harian/update/(:num)', 'MenuHarian::update/$1');
    $routes->get('menu-harian/create/(:num)/(:any)', 'MenuHarian::create/$1/$2');
    $routes->post('menu-harian/store', 'MenuHarian::store');            // simpan menu
    $routes->post('ahli-gizi/simpanPasien', 'AhliGizi::simpanPasien');

});

/**
 * PASIEN (PROTECTED BY MIDDLEWARE)
 */
$routes->get('pasien/login', 'AuthPasien::login');
$routes->post('pasien/login', 'AuthPasien::loginProcess');
$routes->post('pasien/login-process', 'AuthPasien::loginProcess');
$routes->get('pasien/logout', 'AuthPasien::logout');


$routes->group('pasien', ['filter' => 'authPasien'], function ($routes) {
    $routes->get('dashboard', 'Pasien::dashboard');
    $routes->get('menu-makan', 'Pasien::menuMakan');
    $routes->get('daftar-makanan', 'Pasien::daftarMakanan');
    $routes->get('pasien/dashboard', 'Pasien::dashboard');

});

