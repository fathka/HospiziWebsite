<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AhliGiziModel;

class Auth extends BaseController
{
    protected $ahliGiziModel;

    public function __construct()
    {
        $this->ahliGiziModel = new AhliGiziModel();
        helper(['form']);
    }

    /**
     * Halaman login
     */
    public function login()
    {
        return view('auth/login_ahli_gizi', [
            'errors' => session()->getFlashdata('errors')
        ]);
    }

    /**
     * Proses login
     */
   public function loginProcess()
{
    $identity = $this->request->getPost('username'); // FIX DI SINI
    $password = $this->request->getPost('password');

    $allPostData = $this->request->getPost();

    $user = $this->ahliGiziModel
        ->where('username', $identity)
        ->orWhere('email', $identity)
        ->first();

    if (!$user) {
        return redirect()->back()->withInput()->with('error', 'Akun tidak ditemukan');
    }

    if (!password_verify($password, $user['password'])) {
        return redirect()->back()->with('error', 'Password salah');
    }

    session()->set([
        'id_ahli_gizi' => $user['id'],
        'nama'         => $user['nama'] ?? $user['username'],
        'role'         => 'ahli_gizi',
        'ahli_gizi_logged_in'    => true
    ]);

    return redirect()->to('/ahli-gizi/dashboard');
}


    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}
