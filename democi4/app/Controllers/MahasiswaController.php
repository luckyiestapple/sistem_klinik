<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurusanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MahasiswaModel;
class MahasiswaController extends BaseController
{
    public function index()
    {
        // return view('frm_biodata');
        $dataMhs = new MahasiswaModel();
        $dataJurusan = new JurusanModel();
        $data=[
            'mahasiswa' =>$dataMhs
            ->join('tbprodi','tbprodi.kode_prodi = tbmhs.kode_prodi')
            ->join('tbjur','tbjur.kode_jur = tbmhs.kode_jur')
            ->findAll(),
            'jurusan' => $dataJurusan
            ->join('tbprodi','tbprodi.kode_jur = tbjur.kode_jur')
            ->findAll()
        ];
        return view('v_mahasiswa', $data);
    }

    // public function savebiodata(){
    //     $rules =[
    //         'fnim' => 'required|max_length[12]|min_length[12]|numeric',
    //         'fnama' => 'required|max_length[255]|min_length[10]',
    //         'falamat' => 'required|max_length[255]|min_length[10]',
    //     ];

    //     $data = $this->request->getPost(array_keys($rules));

    //     if (!$this->validate($rules)){
    //         return view('frm_biodata', [
    //             'validation' => $this->validator
    //         ]);
    //     }
    //     echo 'Biodata Mahasiswa<br>'; 
    //     echo 'Nim : '.$this->request->getVar('fnim');
    //     echo '<br>Nama : '.$this->request->getVar('fnama');
    //     echo '<br>Alamat : '.$this->request->getVar('falamat');
    // }

    public function simpandata(){
        $kd=$this->request->getVar('kode_prodi');
        $kode=explode('-',$kd);
        $dataMhs = [
            'nim' => $this->request->getVar('nim'),
            'nama' => $this->request->getVar('nama'),
            'alamat' => $this->request->getVar('alamat'),
            'jk' => $this->request->getVar('jk'),
            'kode_prodi' => $kode[1],
            'kode_jur' => $kode[0]
        ];

        $rules= [
            'nim'=>'required|is_unique[tbmhs.nim]|max_length[10]',
            'nama'=>'required',
            'alamat'=>'required',
            'jk'=>'required',
            'kode_prodi'=>'required',
            'kode_jur'=>'required'
        ];

        $data = $this ->request->getPost(array_keys($rules));
        if(!$this->validateData($data, $rules)){
            return redirect()->to(base_url('/mahasiswa'))->withInput()->with('errors',$this->validator->getErrors());
        }

        $mahasiswaMdl = new MahasiswaModel();
        $simpan = $mahasiswaMdl->save($dataMhs);
        if($simpan){
        session()->setFlashdata('pesan', '<div class="alert alert-success text-center">
        <h3><i class="icon fas fa-check"></i> Data Mahasiswa Berhasil Disimpan!</h3></div>');
        }
        return redirect()->to(base_url('/mahasiswa'));
    }

    public function updatedata(){
        $nim = $this->request->getVar('nim');
        $data=[
            'nama'=> $this->request->getVar('nama'),
            'alamat'=> $this->request->getVar('alamat'),
            'jk'=> $this->request->getVar('jk'),
            'kode_prodi'=> $this->request->getVar('kode_prodi'),
            'kode_jur'=> $this->request->getVar('kode_jur')
        ];
        $rules = [
            'nama' => 'required|max_length[255]|min_length[5]',
            'alamat' => 'required|max_length[255]|min_length[5]',
            'jk' => 'required',
            'kode_prodi' => 'required',
            'kode_jur' => 'required'
        ];
        $data1 = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($data1, $rules)) {
            return redirect()->to(base_url('/mahasiswa'))->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $mahasiswaMdl = new MahasiswaModel();
        $update = $mahasiswaMdl->update($nim, $data);
        if($update){
            $this->session->setFlashdata('pesan', '<div class="alert alert-success text-center">
            <h4><i class="icon fas fa-check"></i> Data Mahasiswa Berhasil Diupdate!</h4></div>');
        }
        return redirect()->to(base_url('/mahasiswa'));
    }

    public function hapusdata(){
        $nim = $this->request->getVar('nim');

        if (empty($nim)) {
            $this->session->setFlashdata('pesan', '<div class="alert alert-danger text-center">
                <h4><i class="icon fas fa-times"></i> NIM tidak ditemukan!</h4></div>');
            return redirect()->to(base_url('mahasiswa'));
        }

        $mahasiswaMdl = new MahasiswaModel();
        $hapus = $mahasiswaMdl->delete($nim);
        if ($hapus) {
            $this->session->setFlashdata('pesan', '<div class="alert alert-success text-center">
                <h4><i class="icon fas fa-check"></i> Hapus Data Mahasiswa Sukses!</h4></div>');
        } else {
            $this->session->setFlashdata('pesan', '<div class="alert alert-danger text-center">
                <h4><i class="icon fas fa-times"></i> Hapus Data Mahasiswa Gagal!</h4></div>');
        }

    return redirect()->to(base_url('mahasiswa'));
    }
}