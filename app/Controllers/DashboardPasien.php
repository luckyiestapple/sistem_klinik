<?php

namespace App\Controllers;

use App\Models\Modelpasien;
use App\Models\Modeldokter;
use App\Models\Modelrekmed;
use App\Models\Modelresep;
use App\Models\Modeldetailresep;
use App\Models\Modelantrean;

class DashboardPasien extends BaseController
{
    private function checkAuth()
    {
        if (!session()->get('logged_in') || session()->get('id_level') != 2) {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        
        $pasienModel = new Modelpasien();
        $antreanModel = new Modelantrean();
        $resepModel = new Modelresep();
        $rekmedModel = new Modelrekmed();

        $pasien = $pasienModel->find($id_pasien);
        $antreanMendatang = $antreanModel->getJadwalMendatang($id_pasien);
        $resepList = $resepModel->where('id_pasien', $id_pasien)->orderBy('tgl_resep', 'DESC')->findAll(2);
        
        // Fetch resep details if any
        $detailResepModel = new Modeldetailresep();
        foreach ($resepList as &$resep) {
            $resep['details'] = $detailResepModel->getDetailByResep($resep['id_resep']);
        }

        // Fetch latest health readings (dummy but can be made dynamic from latest rekmed)
        $latestRekmed = $rekmedModel->where('id_pasien', $id_pasien)->orderBy('tgl_periksa', 'DESC')->first();

        $data = [
            'title'            => 'Dashboard Pasien',
            'pasien'           => $pasien,
            'antrean'          => $antreanMendatang,
            'resepList'        => $resepList,
            'latest_rekmed'    => $latestRekmed
        ];

        return view('dashboard/pasien', $data);
    }

    public function profil()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $pasienModel = new Modelpasien();
        $pasien = $pasienModel->find($id_pasien);

        $data = [
            'title'  => 'Profil Saya',
            'pasien' => $pasien
        ];

        return view('dashboard/profil', $data);
    }

    public function antrian()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $dokterModel = new Modeldokter();
        $antreanModel = new Modelantrean();

        // Get distinct spesialisasi
        $db = \Config\Database::connect();
        $spesialisasi = $db->table('tb_dokter')->select('spesialisasi')->distinct()->get()->getResultArray();
        
        // Get all doctors
        $dokter = $dokterModel->findAll();
        
        // Get queue history
        $riwayatAntrean = $antreanModel->getAntreanByPasien($id_pasien);

        $data = [
            'title'          => 'Ambil Antrian',
            'spesialisasi'   => $spesialisasi,
            'dokter'         => $dokter,
            'riwayatAntrean' => $riwayatAntrean
        ];

        return view('dashboard/antrian', $data);
    }

    public function simpanAntrian()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $id_dokter = $this->request->getPost('id_dokter');
        $tgl_antrean = $this->request->getPost('tgl_antrean');

        if (empty($id_dokter) || empty($tgl_antrean)) {
            return redirect()->to(base_url('antrian'))->with('error', 'Semua kolom wajib diisi.');
        }

        $antreanModel = new Modelantrean();
        $nomorAntrean = $antreanModel->generateNomorAntrean($id_dokter, $tgl_antrean);

        $antreanModel->insert([
            'id_pasien'     => $id_pasien,
            'id_dokter'     => $id_dokter,
            'tgl_antrean'   => $tgl_antrean,
            'nomor_antrean' => $nomorAntrean,
            'status'        => 'menunggu'
        ]);

        return redirect()->to(base_url('dashboard_pasien'))->with('success', 'Berhasil mengambil antrean! Nomor antrean Anda: ' . $nomorAntrean);
    }

    public function resep()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $resepModel = new Modelresep();
        $riwayatResep = $resepModel->getResepByPasien($id_pasien);

        $data = [
            'title'        => 'Resep Saya',
            'riwayatResep' => $riwayatResep
        ];

        return view('dashboard/resep', $data);
    }

    public function resepDetail($id)
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $resepModel = new Modelresep();
        $resep = $resepModel->where('id_resep', $id)->where('id_pasien', $id_pasien)->first();

        if (!$resep) {
            return redirect()->to(base_url('resep_pasien'))->with('error', 'Resep tidak ditemukan.');
        }

        // Fetch detail resep beserta nama obat
        $detailModel = new Modeldetailresep();
        $details = $detailModel->getDetailByResep($id);

        // Fetch doctor info
        $dokterModel = new Modeldokter();
        $dokter = $dokterModel->find($resep['id_dokter']);

        $data = [
            'title'   => 'Detail Resep',
            'resep'   => $resep,
            'details' => $details,
            'dokter'  => $dokter
        ];

        return view('dashboard/resep_detail', $data);
    }

    public function rekamMedis()
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $id_pasien = session()->get('id_referensi');
        $rekmedModel = new Modelrekmed();
        $riwayatRekmed = $rekmedModel->getRekamMedisByPasien($id_pasien);

        $data = [
            'title'         => 'Rekam Medis Saya',
            'riwayatRekmed' => $riwayatRekmed
        ];

        return view('dashboard/rekam_medis', $data);
    }
}
