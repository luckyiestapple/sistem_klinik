<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminOrDokterFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $level = session()->get('id_level');
        if ($level != 1 && $level != 3) {
            if ($level == 2) {
                return redirect()->to(base_url('dashboard_pasien'))->with('error', 'Akses ditolak.');
            }
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
