<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelrekmed;
use App\Models\Modelpasien;
use App\Models\Modeldokter;
use App\Models\Modelantrean;

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
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $level = session()->get('id_level');
        if ($level != 1 && $level != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $level = session()->get('id_level');
        $idReferansi = session()->get('id_referensi');

        $query = $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter');

        if ($level == 3) {
            // Dokter only sees their own medical records
            $query->where('rm.id_dokter', $idReferansi);
        }

        $rekam_medis = $query->orderBy('rm.tgl_periksa', 'DESC')->get()->getResultArray();

        $data = [
            'title'       => 'Rekam Medis',
            'breadcrumb'  => 'Rekam Medis',
            'rekam_medis' => $rekam_medis,
            'is_admin'    => ($level == 1),
        ];
        return view('v_rekam_medis', $data);
    }

    public function tambah()
    {
        if ($r = $this->authCheck()) return $r;

        // Hanya Dokter yang boleh input rekam medis
        if (session()->get('id_level') != 3) {
            session()->setFlashdata('error', 'Akses ditolak. Hanya Dokter yang dapat menginput rekam medis.');
            return redirect()->to(base_url('rekam_medis'));
        }

        $pasienModel = new Modelpasien();
        $dokterModel = new Modeldokter();
        $antreanModel = new Modelantrean();

        $prefilledAntrean = null;
        $idAntrean = $this->request->getGet('id_antrean');
        if (!empty($idAntrean)) {
            $prefilledAntrean = $antreanModel->find($idAntrean);
        }

        $level = session()->get('id_level');
        $idReferansi = session()->get('id_referensi');

        // Doctors can only prescribe/examine for themselves
        if ($level == 3) {
            $dokterList = $dokterModel->where('id_dokter', $idReferansi)->findAll();
        } else {
            $dokterList = $dokterModel->findAll();
        }

        $data = [
            'title'            => 'Input Rekam Medis',
            'pasien'           => $pasienModel->findAll(),
            'dokter'           => $dokterList,
            'prefilledAntrean' => $prefilledAntrean,
            'level'            => $level,
            'current_dokter'   => $idReferansi,
        ];
        return view('rekam_medis/v_tambah_rekmed', $data);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idAntrean = $this->request->getPost('id_antrean') ?: null;

            $dataInsert = [
                'id_pasien'         => $this->request->getPost('id_pasien'),
                'id_dokter'         => $this->request->getPost('id_dokter'),
                'tgl_periksa'       => $this->request->getPost('tanggal_periksa'),
                'keluhan'           => $this->request->getPost('keluhan'),
                'diagnosa'          => $this->request->getPost('hasil_pemeriksaan'),
                'tensi'             => $this->request->getPost('tensi'),
                'nadi'              => $this->request->getPost('nadi'),
                'suhu'              => $this->request->getPost('suhu'),
                'berat_badan'       => $this->request->getPost('berat_badan'),
                'tinggi_badan'      => $this->request->getPost('tinggi_badan'),
                'pemeriksaan_fisik' => $this->request->getPost('pemeriksaan_fisik'),
                'tgl_kontrol'       => $this->request->getPost('tgl_kontrol') ?: null,
                'id_antrean'        => $idAntrean,
            ];

            $this->model->insert($dataInsert);
            $idRekamMedis = $this->model->getInsertID();

            // Update queue status to completed if exists
            if (!empty($idAntrean)) {
                $antreanModel = new Modelantrean();
                $antreanModel->update($idAntrean, ['status' => 'selesai']);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menyimpan rekam medis.');
                return redirect()->back()->withInput();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Rekam medis berhasil disimpan. Silakan buat resep obat.');
                
                // Redirect Dokter ke halaman buat resep setelah simpan RM
                if (session()->get('id_level') == 3) {
                    return redirect()->to(base_url('resep/tambah/' . $idRekamMedis));
                }
                return redirect()->to(base_url('rekam_medis'));
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function detail($id)
    {
        if ($r = $this->authCheck()) return $r;

        $rekmed = $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, p.jk, p.tgl_lahir, p.no_telp, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->where('rm.id_rekam_medis', $id)
            ->get()->getRowArray();

        if (!$rekmed) {
            session()->setFlashdata('error', 'Rekam medis tidak ditemukan.');
            return redirect()->to('/rekam_medis');
        }

        // Access check for Doctors
        if (session()->get('id_level') == 3 && $rekmed['id_dokter'] != session()->get('id_referensi')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to('/rekam_medis');
        }

        $data = [
            'title'       => 'Detail Rekam Medis',
            'rekam_medis' => $rekmed,
        ];
        return view('rekam_medis/v_detail_rekmed', $data);
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;

        // Hanya Dokter yang boleh edit rekam medis
        if (session()->get('id_level') != 3) {
            session()->setFlashdata('error', 'Akses ditolak. Hanya Dokter yang dapat mengedit rekam medis.');
            return redirect()->to(base_url('rekam_medis'));
        }

        $rekmed = $this->model->find($id);
        if (!$rekmed) {
            session()->setFlashdata('error', 'Rekam medis tidak ditemukan.');
            return redirect()->to('/rekam_medis');
        }

        // Access check for Doctors
        if (session()->get('id_level') == 3 && $rekmed['id_dokter'] != session()->get('id_referensi')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to('/rekam_medis');
        }

        $pasienModel = new Modelpasien();
        $dokterModel = new Modeldokter();

        $data = [
            'title'       => 'Edit Rekam Medis',
            'rekam_medis' => $rekmed,
            'pasien'      => $pasienModel->findAll(),
            'dokter'      => $dokterModel->findAll(),
            'level'       => session()->get('id_level'),
        ];
        return view('rekam_medis/v_edit_rekmed', $data);
    }

    public function update($id)
    {
        if ($r = $this->authCheck()) return $r;

        $rekmed = $this->model->find($id);
        if (!$rekmed) {
            session()->setFlashdata('error', 'Rekam medis tidak ditemukan.');
            return redirect()->to('/rekam_medis');
        }

        // Access check for Doctors
        if (session()->get('id_level') == 3 && $rekmed['id_dokter'] != session()->get('id_referensi')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to('/rekam_medis');
        }

        $dataUpdate = [
            'id_pasien'         => $this->request->getPost('id_pasien'),
            'id_dokter'         => $this->request->getPost('id_dokter'),
            'tgl_periksa'       => $this->request->getPost('tanggal_periksa'),
            'keluhan'           => $this->request->getPost('keluhan'),
            'diagnosa'          => $this->request->getPost('hasil_pemeriksaan'),
            'tensi'             => $this->request->getPost('tensi'),
            'nadi'              => $this->request->getPost('nadi'),
            'suhu'              => $this->request->getPost('suhu'),
            'berat_badan'       => $this->request->getPost('berat_badan'),
            'tinggi_badan'      => $this->request->getPost('tinggi_badan'),
            'pemeriksaan_fisik' => $this->request->getPost('pemeriksaan_fisik'),
            'tgl_kontrol'       => $this->request->getPost('tgl_kontrol') ?: null,
        ];

        $this->model->update($id, $dataUpdate);
        session()->setFlashdata('success', 'Rekam medis berhasil diperbarui.');
        return redirect()->to('/rekam_medis');
    }

    public function hapus($id)
    {
        if ($r = $this->authCheck()) return $r;

        // Only Admin can delete medical records
        if (session()->get('id_level') != 1) {
            session()->setFlashdata('error', 'Akses ditolak. Dokter tidak diperbolehkan menghapus rekam medis.');
            return redirect()->to('/rekam_medis');
        }

        $this->model->delete($id);
        session()->setFlashdata('success', 'Rekam medis berhasil dihapus.');
        return redirect()->to('/rekam_medis');
    }
}