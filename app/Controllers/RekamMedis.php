<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelrekmed;
use App\Models\Modelpasien;
use App\Models\Modeldokter;

class RekamMedis extends BaseController
{
    protected $model;
    protected $db;

    public function __construct()
    {
        $this->model = new Modelrekmed();
        $this->db    = \Config\Database::connect();
    }

    private function authCheck()
    {
        if (!session()->get('login')) {
            return redirect()->to('/login');
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $data = [
            'title'       => 'Rekam Medis',
            'breadcrumb'  => 'Rekam Medis',
            'rekam_medis' => $this->model->getRekamMedisLengkap(),
        ];
        return view('v_rekam_medis', $data);
    }

    public function tambah()
    {
        if ($r = $this->authCheck()) return $r;

        $pasienModel = new Modelpasien();
        $dokterModel = new Modeldokter();

        $data = [
            'title'   => 'Input Rekam Medis',
            'pasien'  => $pasienModel->findAll(),
            'dokter'  => $dokterModel->findAll(),
        ];
        return view('rekam_medis/v_tambah_rekmed', $data);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->insert([
            'id_pasien'         => $this->request->getPost('id_pasien'),
            'id_dokter'         => $this->request->getPost('id_dokter'),
            'tanggal_periksa'   => $this->request->getPost('tanggal_periksa'),
            'keluhan'           => $this->request->getPost('keluhan'),
            'hasil_pemeriksaan' => $this->request->getPost('hasil_pemeriksaan'),
            'status'            => 'periksa',
        ]);
        session()->setFlashdata('success', 'Rekam medis berhasil disimpan.');
        return redirect()->to('/rekam_medis');
    }

    public function detail(int $id)
    {
        if ($r = $this->authCheck()) return $r;

        $rekmed = $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama_pasien, d.nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->where('rm.id_rekam_medis', $id)
            ->get()->getRowArray();

        $data = [
            'title'      => 'Detail Rekam Medis',
            'rekam_medis' => $rekmed,
        ];
        return view('rekam_medis/v_detail_rekmed', $data);
    }

    public function edit(int $id)
    {
        if ($r = $this->authCheck()) return $r;

        $pasienModel = new Modelpasien();
        $dokterModel = new Modeldokter();

        $data = [
            'title'      => 'Edit Rekam Medis',
            'rekam_medis' => $this->model->find($id),
            'pasien'     => $pasienModel->findAll(),
            'dokter'     => $dokterModel->findAll(),
        ];
        return view('rekam_medis/v_edit_rekmed', $data);
    }

    public function update(int $id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->update($id, [
            'id_pasien'         => $this->request->getPost('id_pasien'),
            'id_dokter'         => $this->request->getPost('id_dokter'),
            'tanggal_periksa'   => $this->request->getPost('tanggal_periksa'),
            'keluhan'           => $this->request->getPost('keluhan'),
            'hasil_pemeriksaan' => $this->request->getPost('hasil_pemeriksaan'),
            'status'            => $this->request->getPost('status'),
        ]);
        session()->setFlashdata('success', 'Rekam medis berhasil diperbarui.');
        return redirect()->to('/rekam_medis');
    }

    public function hapus(int $id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->delete($id);
        session()->setFlashdata('success', 'Rekam medis berhasil dihapus.');
        return redirect()->to('/rekam_medis');
    }
}
