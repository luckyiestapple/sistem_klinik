<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\JurusanModel;

class JurusanController extends BaseController
{
    public function index()
    {
        $dataJurusan = new JurusanModel();
        $data['data'] = $dataJurusan->findAll();

        return view('v_jurusan', $data);
    }

    public function simpandata()
    {
        $rules = [
            'kode_jur' => 'required|is_unique[tbl_jurusan.kode_jur]|max_length[3]',
            'jurusan'  => 'required'
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($data, $rules)) {
            return redirect()->to(base_url('/jurusan'))->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $dataJurusan = new JurusanModel();
        $dataJurusan->save($data);
        return redirect()->to(base_url('jurusan'))->with('success', 'Data jurusan berhasil ditambahkan!');
    }

    public function hapus($id)
    {
        $dataJurusan = new JurusanModel();
        $dataJurusan->delete($id);
        return redirect()->to(base_url('jurusan'))->with('success', 'Data jurusan berhasil dihapus!');
    }

    public function edit($id)
    {
        $dataJurusan = new JurusanModel();
        $jurusan = $dataJurusan->find($id);
        if (!$jurusan) {
            return redirect()->to(base_url('jurusan'))->with('errors', ['Data tidak ditemukan']);
        }
        $data['jurusan'] = $jurusan;
        return view('v_edit_jurusan', $data);
    }

    public function update($id)
    {
        $rules = [
            'kode_jur' => 'required|max_length[3]',
            'jurusan'  => 'required'
        ];
        $data = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($data, $rules)) {
            return redirect()->to(base_url('jurusan/edit/' . $id))->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        $dataJurusan = new JurusanModel();
        $dataJurusan->update($id, $data);
        return redirect()->to(base_url('jurusan'))->with('success', 'Data jurusan berhasil diupdate!');
    }
}