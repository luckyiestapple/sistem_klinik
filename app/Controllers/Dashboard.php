<?php

namespace App\Controllers;

use App\Models\Modelpasien;
use App\Models\Modeldokter;
use App\Models\Modelobat;
use App\Models\Modelresep;
use App\Models\Modelrekmed;
use App\Models\Modelantrean;

class Dashboard extends BaseController
{
    public function index()
    {
        $pasienModel = new Modelpasien();
        $dokterModel = new Modeldokter();
        $obatModel = new Modelobat();
        $resepModel = new Modelresep();
        $rekmedModel = new Modelrekmed();

        // 1. Total Pasien
        $totalPasien = $pasienModel->countAllResults();

        // 2. Total Dokter
        $totalDokter = $dokterModel->countAllResults();

        // 3. Obat Stok Rendah
        $stokRendah = $obatModel->where('stok < stok_minimum')->countAllResults();

        // 4. Resep Menunggu Hari Ini
        $resepMenunggu = $resepModel->where('status', 'menunggu')
                                    ->where('DATE(tgl_resep)', date('Y-m-d'))
                                    ->countAllResults();

        // 5. Pendapatan Hari Ini (status = selesai)
        $db = \Config\Database::connect();
        $pendapatanResult = $db->table('tb_resep')
                               ->selectSum('total_harga')
                               ->where('status', 'selesai')
                               ->where('DATE(tgl_resep)', date('Y-m-d'))
                               ->get()
                               ->getRow();
        $pendapatan = $pendapatanResult->total_harga ?? 0;

        // 6. Dokter List
        $daftarDokter = $dokterModel->limit(5)->findAll();

        // 7. Rekam Medis Terbaru
        $rekmedTerbaru = $rekmedModel->getRekamMedisLengkap();
        $rekmedTerbaru = array_slice($rekmedTerbaru, 0, 5);

        $data = [
            'title'            => 'Dashboard Utama (Klinik)',
            'total_pasien'     => $totalPasien,
            'total_dokter'     => $totalDokter,
            'stok_rendah'      => $stokRendah,
            'resep_menunggu'   => $resepMenunggu,
            'pendapatan'       => $pendapatan,
            'daftar_dokter'    => $daftarDokter,
            'rekmed_terbaru'   => $rekmedTerbaru,
        ];

        return view('dashboard/admin', $data);
    }

    public function antrian()
    {
        $antreanModel = new Modelantrean();
        $db = \Config\Database::connect();

        // Get filter inputs
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $dokterId = $this->request->getGet('dokter_id');
        $status = $this->request->getGet('status');

        $query = $db->table('tb_antrean a')
                    ->select('a.*, p.nama AS nama_pasien, d.nama AS nama_dokter, d.spesialisasi')
                    ->join('tb_pasien p', 'p.id_pasien = a.id_pasien')
                    ->join('tb_dokter d', 'd.id_dokter = a.id_dokter');

        if (!empty($tanggal)) {
            $query->where('a.tgl_antrean', $tanggal);
        }
        if (!empty($dokterId)) {
            $query->where('a.id_dokter', $dokterId);
        }
        if (!empty($status)) {
            $query->where('a.status', $status);
        }

        $antrean = $query->orderBy('a.tgl_antrean', 'ASC')
                         ->orderBy('a.nomor_antrean', 'ASC')
                         ->get()
                         ->getResultArray();

        $dokterList = (new Modeldokter())->findAll();

        $data = [
            'title'      => 'Kelola Antrian Global',
            'antrean'    => $antrean,
            'dokterList' => $dokterList,
            'filter'     => [
                'tanggal'   => $tanggal,
                'dokter_id' => $dokterId,
                'status'    => $status
            ]
        ];

        return view('dashboard/admin_antrian', $data);
    }

    public function updateAntrianStatus($id)
    {
        $antreanModel = new Modelantrean();
        $status = $this->request->getPost('status');

        if (in_array($status, ['menunggu', 'dipanggil', 'selesai', 'batal'])) {
            $antreanModel->update($id, ['status' => $status]);
            session()->setFlashdata('success', 'Status antrean berhasil diperbarui.');
        } else {
            session()->setFlashdata('error', 'Status tidak valid.');
        }

        return redirect()->to(base_url('admin/antrian'));
    }
}
