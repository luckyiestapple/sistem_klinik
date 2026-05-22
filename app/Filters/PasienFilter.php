<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PasienFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        if (session()->get('id_level') != 2) {
            $level = session()->get('id_level');
            if ($level == 1) {
                return redirect()->to(base_url('dashboard'))->with('error', 'Akses ditolak.');
            } elseif ($level == 3) {
                return redirect()->to(base_url('dashboard_dokter'))->with('error', 'Akses ditolak.');
            }
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
