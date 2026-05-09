<?php

namespace App\Controllers;

class DashboardDokter extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('id_level') != 4) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak. Khusus Dokter.');
        }

        $data = [
            'title' => 'Dashboard Dokter'
        ];
        return view('dashboard/dokter', $data);
    }
}

