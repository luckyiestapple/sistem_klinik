<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function index()
    {
       $data =[
        'title' => 'Dashboard Admin & Apoteker',
        'total_pasien' => 150,
        'total_obat' => 45,
        'total_resep' => 89,
        'pendapatan'=>'Rp. 12.500.000'
       ];
       return view('v_apoteker', $data);
    }
}
