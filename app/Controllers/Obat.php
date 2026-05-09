<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelobat;

class Obat extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Modelobat();
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
            'title'      => 'Data Obat',
            'breadcrumb' => 'Obat',
            'obat'       => $this->model->findAll(),
        ];
        return view('v_obat', $data);
    }

    public function tambah()
    {
        if ($r = $this->authCheck()) return $r;
        return view('obat/v_tambah_obat', ['title' => 'Tambah Obat']);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->insert([
            'kode_obat' => $this->request->getPost('kode_obat'),
            'nama_obat' => $this->request->getPost('nama_obat'),
            'stok'      => $this->request->getPost('stok'),
            'harga'     => $this->request->getPost('harga'),
        ]);
        session()->setFlashdata('success', 'Obat berhasil ditambahkan.');
        return redirect()->to('/obat');
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;

        $data = [
            'title' => 'Edit Obat',
            'obat'  => $this->model->find($id),
        ];
        return view('obat/v_edit_obat', $data);
    }

    public function update($id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->update($id, [
            'kode_obat' => $this->request->getPost('kode_obat'),
            'nama_obat' => $this->request->getPost('nama_obat'),
            'stok'      => $this->request->getPost('stok'),
            'harga'     => $this->request->getPost('harga'),
        ]);
        session()->setFlashdata('success', 'Data obat berhasil diperbarui.');
        return redirect()->to('/obat');
    }

    public function hapus($id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->delete($id);
        session()->setFlashdata('success', 'Data obat berhasil dihapus.');
        return redirect()->to('/obat');
    }
}

