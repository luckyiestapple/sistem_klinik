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
            return redirect()->to(base_url('login'));
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
    public function tambah($idRekamMedis)
    {
        if ($r = $this->authCheck()) return $r;

        $rekmedModel = new Modelrekmed();
        $obatModel   = new Modelobat();

        $rekmed = $this->db->table('tb_rekam_medis rm')
            ->select('rm.*, p.nama AS nama_pasien, d.nama AS nama_dokter')
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

        // Ambil data pasien & dokter dari rekmed untuk resep
        $rekmedModel = new Modelrekmed();
        $rm = $rekmedModel->find($idRekamMedis);

        // Simpan header resep (id_resep auto increment)
        $idResep = $this->model->insert([
            'id_pasien'   => $rm['id_pasien'],
            'id_dokter'   => $rm['id_dokter'],
            'tgl_resep'   => date('Y-m-d'),
            'total_harga' => $total,
        ], true);

        // Simpan detail resep & Update Stok Obat
        $obatModel = new \App\Models\Modelobat();
        foreach ($idObatArr as $i => $idObat) {
            // Simpan detail
            $this->detailModel->insert([
                'kode_resep'   => $idResep,
                'kode_obat'    => $idObat,
                'jumlah'       => $jumlahArr[$i],
                'dosis'        => $dosisArr[$i],
                'harga'        => $hargaArr[$i],
            ]);

            // Update stok obat
            $obat = $obatModel->find($idObat);
            if ($obat) {
                $newStok = (int)$obat['stok'] - (int)$jumlahArr[$i];
                $obatModel->update($idObat, ['stok' => $newStok]);
            }
        }

        // Di SQL dump tb_rekam_medis tidak ada kolom status.
        // session()->setFlashdata('success', 'Resep berhasil dibuat.');

        session()->setFlashdata('success', 'Resep berhasil dibuat.');
        return redirect()->to('/resep');
    }

    public function detail($id)
    {
        if ($r = $this->authCheck()) return $r;

        $resep = $this->db->table('tb_resep r')
            ->select('r.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
            ->join('tb_pasien p', 'p.id_pasien = r.id_pasien')
            ->join('tb_dokter d', 'd.id_dokter = r.id_dokter')
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


}

