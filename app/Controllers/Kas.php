<?php

namespace App\Controllers;

use App\Models\ModelLaporanKas;
use App\Models\UserModel;

class Kas extends BaseController
{
    protected $kasModel;
    protected $userModel;

    public function __construct()
    {
        $this->kasModel = new ModelLaporanKas();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $tipe = $this->request->getGet('tipe');
        $tgl_mulai = $this->request->getGet('tgl_mulai');
        $tgl_akhir = $this->request->getGet('tgl_akhir');
        $id_admin = $this->request->getGet('id_admin');

        $data = [
            'title'      => 'Laporan Kas',
            'laporan'    => $this->kasModel->getLaporanKas($tipe, $tgl_mulai, $tgl_akhir, $id_admin),
            'ringkasan'  => $this->kasModel->getRingkasan(),
            'admins'     => $this->userModel->whereIn('id_level', [1, 3])->findAll(), // Assuming level 1 and 3 are admins/staff
            // Keep filters
            'tipe'       => $tipe,
            'tgl_mulai'  => $tgl_mulai,
            'tgl_akhir'  => $tgl_akhir,
            'id_admin'   => $id_admin
        ];

        return view('kas/v_kas', $data);
    }
}
