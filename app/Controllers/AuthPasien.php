<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasienModel;

class AuthPasien extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        helper(['form']);
    }

    public function login()
    {
        return view('auth/login_pasien');
    }

    public function loginProcess()
    {
        $no_rm = $this->request->getPost('no_rm');
        $tanggal_lahir = $this->request->getPost('tanggal_lahir');

        $user = $this->pasienModel
            ->where('no_rm', $no_rm)
            ->where('tanggal_lahir', $tanggal_lahir)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Login pasien gagal');
        }

        session()->set([
            'pasien_id'        => $user['id'],
            'nama_lengkap'     => $user['nama_lengkap'],
            'pasien_logged_in' => true,
            'role'             => 'pasien'
        ]);

        return redirect()->to('/pasien/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/pasien/login');
    }
}
