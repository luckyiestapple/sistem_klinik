<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modeldokter;

class Dokter extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Modeldokter();
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
            'title'      => 'Data Dokter',
            'breadcrumb' => 'Dokter',
            'dokter'     => $this->model->findAll(),
        ];
        return view('v_dokter', $data);
    }

    public function tambah()
    {
        if ($r = $this->authCheck()) return $r;
        return view('dokter/v_tambah_dokter', ['title' => 'Tambah Dokter']);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->insert([
            'id_dokter'    => $this->model->generateID(),
            'nama'         => $this->request->getPost('nama_dokter'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);
        session()->setFlashdata('success', 'Data dokter berhasil ditambahkan.');
        return redirect()->to('/dokter');
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;

        $data = [
            'title'  => 'Edit Dokter',
            'dokter' => $this->model->find($id),
        ];
        return view('dokter/v_edit_dokter', $data);
    }

    public function update($id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->update($id, [
            'nama'         => $this->request->getPost('nama_dokter'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'alamat'       => $this->request->getPost('alamat'),
        ]);
        session()->setFlashdata('success', 'Data dokter berhasil diperbarui.');
        return redirect()->to('/dokter');
    }

    public function hapus($id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->delete($id);
        session()->setFlashdata('success', 'Data dokter berhasil dihapus.');
        return redirect()->to('/dokter');
    }
}

