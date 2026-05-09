<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelpasien;

class Pasien extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Modelpasien();
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
            'title'      => 'Data Pasien',
            'breadcrumb' => 'Pasien',
            'pasien'     => $this->model->findAll(),
        ];
        return view('v_pasien', $data);
    }

    public function tambah()
    {
        if ($r = $this->authCheck()) return $r;
        return view('pasien/v_tambah_pasien', ['title' => 'Daftar Pasien Baru']);
    }

    public function simpan()
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->insert([
            'id_pasien' => $this->model->generateID(),
            'nama'      => $this->request->getPost('nama_pasien'),
            'jk'        => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir' => $this->request->getPost('tanggal_lahir'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'alamat'    => $this->request->getPost('alamat'),
        ]);
        session()->setFlashdata('success', 'Pasien berhasil didaftarkan.');
        return redirect()->to('/pasien');
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;

        $data = [
            'title'  => 'Edit Pasien',
            'pasien' => $this->model->find($id),
        ];
        return view('pasien/v_edit_pasien', $data);
    }

    public function update($id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->update($id, [
            'nama'      => $this->request->getPost('nama_pasien'),
            'jk'        => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir' => $this->request->getPost('tanggal_lahir'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'alamat'    => $this->request->getPost('alamat'),
        ]);
        session()->setFlashdata('success', 'Data pasien berhasil diperbarui.');
        return redirect()->to('/pasien');
    }

    public function hapus($id)
    {
        if ($r = $this->authCheck()) return $r;

        $this->model->delete($id);
        session()->setFlashdata('success', 'Data pasien berhasil dihapus.');
        return redirect()->to('/pasien');
    }
}

