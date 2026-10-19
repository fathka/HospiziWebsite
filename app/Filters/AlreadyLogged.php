<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AlreadyLogged implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('ahli_gizi_logged_in')) {
            return redirect()->to('/ahli-gizi/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // kosong
    }
}
