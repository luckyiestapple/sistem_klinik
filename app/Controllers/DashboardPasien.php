<?php

namespace App\Controllers;

class DashboardPasien extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('id_level') != 2) {
            return redirect()->to('/login')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Dashboard Pasien'
        ];
        return view('dashboard/pasien', $data);
    }
}
