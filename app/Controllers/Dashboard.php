<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelpasien;
use App\Models\Modeldokter;
use App\Models\Modelrekmed;
use App\Models\Modelresep;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('login')) {
            return redirect()->to('/login');
        }

        $pasien  = new Modelpasien();
        $dokter  = new Modeldokter();
        $rekmed  = new Modelrekmed();
        $resep   = new Modelresep();

        $data = [
            'total_pasien'  => $pasien->countAll(),
            'total_dokter'  => $dokter->countAll(),
            'rekmed_hari_ini' => $rekmed->getTodayCount(),
            'resep_menunggu'  => $resep->getMenungguCount(),
            'daftar_dokter'   => $dokter->findAll(5),
            'rekmed_terbaru'  => $rekmed->getRekamMedisLengkap(),
        ];

        return view('v_dashboard', $data);
    }
}
