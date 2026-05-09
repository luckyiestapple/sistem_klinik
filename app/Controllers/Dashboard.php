<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek login dan pastikan levelnya admin/pegawai
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $id_level = session()->get('id_level');
        if ($id_level != 1 && $id_level != 3) { 
            // Level 1 = Admin, 3 = Pegawai (asumsi)
            // Jika bukan admin/pegawai, tolak
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Dashboard Utama (Klinik)'
        ];
        return view('dashboard/admin', $data);
    }
}
