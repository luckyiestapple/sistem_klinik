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
        if (!session()->get('login')) {
            return redirect()->to('/login');
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $data = [
            'title'      => 'Daftar Resep',
            'breadcrumb' => 'Resep',
            'resep'      => $this->model->getResepLengkap(),
        ];
        return view('v_resep', $data);
    }

    /**
     * Tambah resep berdasarkan rekam medis yang ada.
     * (:num) = id_rekam_medis
     */
    public function tambah(int $idRekamMedis)
    {
        if ($r = $this->authCheck()) return $r;

        $rekmedModel = new Modelrekmed();
        $obatModel   = new Modelobat();

        $rekmed = $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama_pasien, d.nama_dokter')
            ->join('tb_pasien p', 'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = rm.id_dokter')
            ->where('rm.id_rekam_medis', $idRekamMedis)
            ->get()->getRowArray();

        $data = [
            'title'      => 'Buat Resep',
            'rekam_medis' => $rekmed,
            'obat'       => $obatModel->findAll(),
        ];
        return view('resep/v_tambah_resep', $data);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $idRekamMedis = $this->request->getPost('id_rekam_medis');
        $idObatArr    = $this->request->getPost('id_obat');
        $jumlahArr    = $this->request->getPost('jumlah');
        $dosisArr     = $this->request->getPost('dosis');
        $hargaArr     = $this->request->getPost('harga_satuan');

        // Hitung total
        $total = 0;
        foreach ($jumlahArr as $i => $jml) {
            $total += (int)$jml * (float)$hargaArr[$i];
        }

        // Simpan header resep (id_resep auto increment)
        $idResep = $this->model->insert([
            'id_rekam_medis' => $idRekamMedis,
            'tanggal_resep'  => date('Y-m-d H:i:s'),
            'total_harga'    => $total,
            'status'         => 'menunggu',
        ], true);

        // Simpan detail resep (id_detail auto increment, tanpa subtotal)
        foreach ($idObatArr as $i => $idObat) {
            $this->detailModel->insert([
                'id_resep'     => $idResep,
                'id_obat'      => $idObat,
                'jumlah'       => $jumlahArr[$i],
                'dosis'        => $dosisArr[$i],
                'harga_satuan' => $hargaArr[$i],
            ]);
        }

        // Update status rekam medis → selesai
        $rekmedModel = new Modelrekmed();
        $rekmedModel->update($idRekamMedis, ['status' => 'selesai']);

        session()->setFlashdata('success', 'Resep berhasil dibuat.');
        return redirect()->to('/resep');
    }

    public function detail(int $id)
    {
        if ($r = $this->authCheck()) return $r;

        $resep = $this->db->table('tb_resep r')
            ->select('r.*, rm.keluhan, rm.hasil_pemeriksaan, rm.tanggal_periksa, p.nama_pasien, d.nama_dokter, d.spesialisasi')
            ->join('tb_rekam_medis rm', 'rm.id_rekam_medis = r.id_rekam_medis')
            ->join('tb_pasien p',       'p.id_pasien = rm.id_pasien')
            ->join('tb_dokter d',       'd.id_dokter = rm.id_dokter')
            ->where('r.id_resep', $id)
            ->get()->getRowArray();

        // Subtotal dihitung di query: jumlah * harga_satuan
        $detail = $this->detailModel->getDetailByResep($id);

        $data = [
            'title'  => 'Detail Resep',
            'resep'  => $resep,
            'detail' => $detail,
        ];
        return view('resep/v_detail_resep', $data);
    }

    /**
     * Apoteker mengupdate status resep.
     */
    public function updateStatus(int $id)
    {
        if ($r = $this->authCheck()) return $r;

        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $this->model->update($id, [
            'status'  => $status,
            'catatan' => $catatan,
        ]);
        session()->setFlashdata('success', 'Status resep berhasil diperbarui.');
        return redirect()->to('/resep');
    }
}
