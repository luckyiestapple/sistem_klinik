<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\ProdiModel;
class ProdiController extends BaseController
{
    public function index()
    {
        // $prodiMdl= new ProdiModel();
        // $prodi = $prodiMdl->findAll();
        //     $data=[
        //         'judul'=>'Data Prodi',
        //         'prodi'=>$prodiMdl->findAll()
        //     ];
        //     return view('v_prodi', $data);
        $dataProdi = new ProdiModel();
        $data = $dataProdi->findAll();
        return view('v_prodi2', ['data' => $data]);
    }

    public function simpandata(){
            $dataProdi = [
                'kode_prodi' => $this->request->getVar('kode_prodi'),
                'kode_jur'   => $this->request->getVar('kode_jur'),
                'prodi' => $this->request->getVar('prodi')
            ];
    
            $rules= [
                'kode_prodi'=>'required|is_unique[tbl_prodi.kode_prodi]|max_length[5]',
                'kode_jur'=>'required|max_length[3]',
                'prodi'=>'required'
            ];
    
            $data = $this ->request->getPost(array_keys($rules));
            if(!$this->validateData($data,$rules)){
                return redirect()->to(base_url('/prodi'))->withInput()->with('errors',$this->validator->getErrors());
            }

            $prodiMdl = new ProdiModel();
            $simpan = $prodiMdl->save($dataProdi);
            if($simpan){
                $this->session->setFlashdata('pesan', '<div class="alert alert-success text-center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h3><i class="icon fas fa-check"></i> Data Prodi Berhasil Disimpan!</h3></div>');
            }
        return redirect()->to(base_url('/prodi'));
    }

    public function updatedata(){
        $dataProdi = [
            'kode_prodi' => $this->request->getVar('kode_prodi'),
            'kode_jur'   => $this->request->getVar('kode_jur'),
            'prodi' => $this->request->getVar('prodi')
        ];

        $rules= [
            'kode_prodi'=>'required|max_length[5]',
            'kode_jur'=>'required|max_length[3]',
            'prodi'=>'required'
        ];

        $data = $this ->request->getPost(array_keys($rules));
        if(!$this->validateData($dataProdi,$rules)){
            return redirect()->to(base_url('/prodi'))->withInput()->with('errors',$this->validator->getErrors());
        }

        $prodiMdl = new ProdiModel();
        $simpan = $prodiMdl->update($dataProdi['kode_prodi'], $dataProdi);
        if($simpan){
            $this->session->setFlashdata('pesan', '<div class="alert alert-success text-center">
            <h4><i class="icon fas fa-check"></i> Data Prodi Berhasil Diupdate!</h4></div>');
        }
        return redirect()->to(base_url('/prodi'));
    }

    public function hapusdata(){
        $kode_prodi = $this->request->getVar('kode_prodi');
        $prodiMdl = new ProdiModel();
        $hapus = $prodiMdl->delete($kode_prodi);
        if($hapus){
            $this->session->setFlashdata('pesan', '<div class="alert alert-success text-center">
            <h4><i class="icon fas fa-check"></i> Data Prodi Berhasil Dihapus!</h4></div>');
        }
        return redirect()->to(base_url('/prodi'));
    }
}