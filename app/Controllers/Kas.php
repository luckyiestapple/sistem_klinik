<?php

namespace App\Controllers;

use App\Models\ModelLaporanKas;


class Kas extends BaseController
{
    protected $kasModel;


    public function __construct()
    {
        $this->kasModel = new ModelLaporanKas();

    }

    public function index()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $tipe = $this->request->getGet('tipe');
        $tgl_mulai = $this->request->getGet('tgl_mulai');
        $tgl_akhir = $this->request->getGet('tgl_akhir');

        $data = [
            'title'      => 'Laporan Kas',
            'laporan'    => $this->kasModel->getLaporanKas($tipe, $tgl_mulai, $tgl_akhir),
            'ringkasan'  => $this->kasModel->getRingkasan(),
            // Keep filters
            'tipe'       => $tipe,
            'tgl_mulai'  => $tgl_mulai,
            'tgl_akhir'  => $tgl_akhir
        ];

        return view('kas/v_kas', $data);
    }
}
