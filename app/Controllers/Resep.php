<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelresep;
use App\Models\Modeldetailresep;
use App\Models\Modelobat;
use App\Models\Modelrekmed;

class Resep extends BaseController
{
    protected $model;
    protected $detailModel;
    protected $db;

    public function __construct()
    {
        $this->model       = new Modelresep();
        $this->detailModel = new Modeldetailresep();
        $this->db          = \Config\Database::connect();
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

        $query = $this->db->table('tb_resep r')
            ->select('r.*, p.nama AS nama_pasien, p.status_bpjs, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = r.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = r.id_dokter');

        if ($level == 3) {
            // Dokter only sees their own prescriptions
            $query->where('r.id_dokter', $idReferansi);
        }

        $resep = $query->orderBy('r.tgl_resep', 'DESC')->get()->getResultArray();

        $data = [
            'title'      => 'Daftar Resep',
            'breadcrumb' => 'Resep',
            'resep'      => $resep,
            'is_admin'   => ($level == 1),
        ];
        return view('v_resep', $data);
    }

    /**
     * Tambah resep berdasarkan rekam medis yang ada.
     */
    public function tambah($idRekamMedis)
    {
        if ($r = $this->authCheck()) return $r;

        $rekmedModel = new Modelrekmed();
        $obatModel   = new Modelobat();

        $rekmed = $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, p.status_bpjs, p.no_bpjs, d.nama AS nama_dokter')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->where('rm.id_rekam_medis', $idRekamMedis)
            ->get()->getRowArray();

        if (!$rekmed) {
            session()->setFlashdata('error', 'Rekam medis tidak ditemukan.');
            return redirect()->to('/rekam_medis');
        }

        // Check if Doctor is trying to prescribe for another doctor's record
        if (session()->get('id_level') == 3 && $rekmed['id_dokter'] != session()->get('id_referensi')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to('/rekam_medis');
        }

        // Only show active and in-stock medicines
        $obat = $obatModel->where('stok >', 0)->findAll();

        $data = [
            'title'       => 'Buat Resep',
            'rekam_medis' => $rekmed,
            'obat'        => $obat,
            'is_bpjs'     => (strtolower($rekmed['status_bpjs'] ?? '') === 'aktif'),
        ];
        return view('resep/v_tambah_resep', $data);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idRekamMedis = $this->request->getPost('id_rekam_medis');
            $idObatArr    = $this->request->getPost('id_obat');
            $jumlahArr    = $this->request->getPost('jumlah');
            $dosisArr     = $this->request->getPost('dosis');
            $hargaArr     = $this->request->getPost('harga_satuan');

            if (empty($idObatArr)) {
                $db->transRollback();
                session()->setFlashdata('error', 'Pilih minimal satu obat!');
                return redirect()->back()->withInput();
            }

            // Ambil data pasien & dokter dari rekmed
            $rekmedModel = new Modelrekmed();
            $rm = $rekmedModel->find($idRekamMedis);

            // Ambil status BPJS pasien
            $pasienModel = new \App\Models\Modelpasien();
            $pasien = $pasienModel->find($rm['id_pasien']);
            $isBpjs = (strtolower($pasien['status_bpjs'] ?? '') === 'aktif');

            // Hitung total (BPJS = gratis Rp0, Non-BPJS = normal)
            $total = 0;
            if (!$isBpjs) {
                foreach ($jumlahArr as $i => $jml) {
                    $total += (int)$jml * (float)$hargaArr[$i];
                }
            }

            // Simpan header resep (id_resep auto increment)
            $idResep = $this->model->insert([
                'id_pasien'   => $rm['id_pasien'],
                'id_dokter'   => $rm['id_dokter'],
                'tgl_resep'   => date('Y-m-d'),
                'total_harga' => $total,
                'status'      => 'menunggu', // default status
            ], true);

            // Simpan detail resep & Update Stok Obat
            $obatModel = new Modelobat();
            foreach ($idObatArr as $i => $idObat) {
                // Check stock
                $obat = $obatModel->find($idObat);
                if (!$obat) {
                    $db->transRollback();
                    session()->setFlashdata('error', 'Obat tidak ditemukan.');
                    return redirect()->back()->withInput();
                }

                if ((int)$obat['stok'] < (int)$jumlahArr[$i]) {
                    $db->transRollback();
                    session()->setFlashdata('error', 'Stok obat "' . esc($obat['nama_obat']) . '" tidak cukup! (Tersedia: ' . $obat['stok'] . ')');
                    return redirect()->back()->withInput();
                }

                // Simpan detail
                $this->detailModel->insert([
                    'kode_resep'   => $idResep,
                    'kode_obat'    => $idObat,
                    'jumlah'       => $jumlahArr[$i],
                    'dosis'        => $dosisArr[$i],
                    'harga'        => $hargaArr[$i],
                ]);

                // Update stok obat
                $newStok = (int)$obat['stok'] - (int)$jumlahArr[$i];
                $obatModel->update($idObat, ['stok' => $newStok]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menyimpan resep.');
                return redirect()->back()->withInput();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Resep berhasil dibuat.');
                return redirect()->to('/resep');
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

        $resep = $this->db->table('tb_resep r')
            ->select('r.*, p.nama AS nama_pasien, p.jk, p.tgl_lahir, p.no_telp, p.status_bpjs, p.no_bpjs, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = r.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = r.id_dokter')
            ->where('r.id_resep', $id)
            ->get()->getRowArray();

        if (!$resep) {
            session()->setFlashdata('error', 'Resep tidak ditemukan.');
            return redirect()->to('/resep');
        }

        // Access check for Doctors
        if (session()->get('id_level') == 3 && $resep['id_dokter'] != session()->get('id_referensi')) {
            session()->setFlashdata('error', 'Akses ditolak.');
            return redirect()->to('/resep');
        }

        $detail = $this->detailModel->getDetailByResep($id);
        $isBpjs = (strtolower($resep['status_bpjs'] ?? '') === 'aktif');

        $data = [
            'title'   => 'Detail Resep',
            'resep'   => $resep,
            'detail'  => $detail,
            'is_bpjs' => $isBpjs,
        ];
        return view('resep/v_detail_resep', $data);
    }

    public function updateStatus($id)
    {
        if ($r = $this->authCheck()) return $r;

        // Only Admin (Apoteker) can update resep status
        if (session()->get('id_level') != 1) {
            session()->setFlashdata('error', 'Akses ditolak. Hanya Apoteker/Admin yang dapat memproses resep.');
            return redirect()->back();
        }

        $status = $this->request->getPost('status');
        if (in_array($status, ['menunggu', 'diproses', 'selesai'])) {
            $this->model->update($id, ['status' => $status]);
            session()->setFlashdata('success', 'Status resep berhasil diubah menjadi: ' . ucfirst($status));
        } else {
            session()->setFlashdata('error', 'Status tidak valid.');
        }

        return redirect()->to('/resep');
    }
}
