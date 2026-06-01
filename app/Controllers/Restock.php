<?php

namespace App\Controllers;

use App\Models\ModelRestock;
use App\Models\Modelobat;

class Restock extends BaseController
{
    protected $restockModel;
    protected $obatModel;

    public function __construct()
    {
        $this->restockModel = new ModelRestock();
        $this->obatModel = new Modelobat();
    }

    public function index()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $data = [
            'title'   => 'Restock Obat',
            'restock' => $this->restockModel->getRestockWithDetails()
        ];
        return view('restock/v_restock', $data);
    }

    public function tambah()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Tambah Restock',
            'obat'  => $this->obatModel->findAll()
        ];
        return view('restock/v_tambah_restock', $data);
    }

    public function simpan()
    {
        if (session()->get('id_level') != 1 && session()->get('id_level') != 3) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
        }

        $kode_obat = $this->request->getPost('kode_obat');
        $tanggal = $this->request->getPost('tanggal');
        $keterangan = $this->request->getPost('keterangan');
        $jumlah = $this->request->getPost('jumlah');
        $harga_beli = $this->request->getPost('harga_beli');
        
        $total_biaya = $jumlah * $harga_beli;

        $db = \Config\Database::connect();
        $db->transStart();

        $this->restockModel->insert([
            'kode_obat'   => $kode_obat,
            'tanggal'     => $tanggal,
            'keterangan'  => $keterangan,
            'jumlah'      => $jumlah,
            'harga_beli'  => $harga_beli,
            'total_biaya' => $total_biaya,
            'id_user'     => session()->get('id_user')
        ]);

        $this->obatModel->addStock($kode_obat, $jumlah);
        
        // Optional: Update harga beli in obat table? User didn't mandate but mentioned it. We skip to keep it simple.

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(base_url('restock/tambah'))->with('error', 'Gagal menambah restock.');
        } else {
            return redirect()->to(base_url('restock'))->with('success', 'Data restock berhasil ditambahkan!');
        }
    }

    public function hapus($id)
    {
        if (session()->get('id_level') != 1) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak. Hanya admin.');
        }

        $data = $this->restockModel->find($id);
        if ($data) {
            $db = \Config\Database::connect();
            $db->transStart();

            $this->obatModel->reduceStock($data['kode_obat'], $data['jumlah']);
            $this->restockModel->delete($id);

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to(base_url('restock'))->with('error', 'Gagal menghapus restock.');
            } else {
                return redirect()->to(base_url('restock'))->with('success', 'Data restock berhasil dihapus!');
            }
        }
        return redirect()->to(base_url('restock'))->with('error', 'Data tidak ditemukan.');
    }
}
