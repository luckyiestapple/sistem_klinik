<?php

namespace App\Controllers;

use App\Models\ModelTransaksiPasien;
use App\Models\ModelDetailTransaksi;
use App\Models\Modelobat;

class TransaksiPasien extends BaseController
{
    protected $transaksiModel;
    protected $detailModel;
    protected $obatModel;

    public function __construct()
    {
        $this->transaksiModel = new ModelTransaksiPasien();
        $this->detailModel = new ModelDetailTransaksi();
        $this->obatModel = new Modelobat();
    }

    public function index()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $data = [
            'title'     => 'Riwayat Transaksi Pasien',
            'transaksi' => $this->transaksiModel->getTransaksiWithDetails()
        ];
        return view('transaksi_pasien/v_transaksi', $data);
    }

    public function tambah()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Tambah Transaksi',
            'obat'  => $this->obatModel->where('stok >', 0)->findAll()
        ];
        return view('transaksi_pasien/v_tambah_transaksi', $data);
    }

    public function simpan()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $nama_pasien = $this->request->getPost('nama_pasien');
        $is_bpjs = $this->request->getPost('is_bpjs') ? 1 : 0;
        $tanggal = $this->request->getPost('tanggal');
        $obat_data = $this->request->getPost('obat'); // Array of kode_obat => jumlah

        if (empty($obat_data)) {
            return redirect()->to(base_url('transaksipasien/tambah'))->with('error', 'Pilih minimal satu obat.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $total_biaya = 0;
        $detail_items = [];

        foreach ($obat_data as $kode_obat => $jumlah) {
            if ($jumlah > 0) {
                $obat = $this->obatModel->find($kode_obat);
                if ($obat) {
                    $harga_satuan = $obat['harga'];
                    $subtotal = $harga_satuan * $jumlah;
                    
                    if ($is_bpjs) {
                        $subtotal = 0; // BPJS is free
                    }
                    
                    $total_biaya += $subtotal;
                    
                    $detail_items[] = [
                        'kode_obat'    => $kode_obat,
                        'jumlah'       => $jumlah,
                        'harga_satuan' => $harga_satuan,
                        'subtotal'     => $subtotal
                    ];
                    
                    // Reduce stock
                    $this->obatModel->reduceStock($kode_obat, $jumlah);
                }
            }
        }

        if (empty($detail_items)) {
            $db->transRollback();
            return redirect()->to(base_url('transaksipasien/tambah'))->with('error', 'Jumlah obat tidak valid.');
        }

        $transaksi_id = $this->transaksiModel->insert([
            'nama_pasien' => $nama_pasien,
            'is_bpjs'     => $is_bpjs,
            'tanggal'     => $tanggal,
            'total_biaya' => $total_biaya,
            'id_user'     => session()->get('id_user')
        ]);

        foreach ($detail_items as &$item) {
            $item['id_transaksi'] = $transaksi_id;
        }

        $this->detailModel->insertBatch($detail_items);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(base_url('transaksipasien/tambah'))->with('error', 'Gagal menyimpan transaksi.');
        } else {
            return redirect()->to(base_url('transaksipasien'))->with('success', 'Transaksi berhasil disimpan!');
        }
    }

    public function nota($id)
    {
        $transaksi = $this->transaksiModel->getTransaksiWithDetails();
        $transaksi_data = null;
        foreach($transaksi as $t) {
            if($t['id_transaksi'] == $id) {
                $transaksi_data = $t;
                break;
            }
        }

        if (!$transaksi_data) {
            return redirect()->to(base_url('transaksipasien'))->with('error', 'Transaksi tidak ditemukan.');
        }

        $detail = $this->detailModel->getDetailByTransaksi($id);

        $data = [
            'title'     => 'Nota Transaksi',
            'transaksi' => $transaksi_data,
            'detail'    => $detail
        ];

        return view('transaksi_pasien/nota', $data);
    }
}
