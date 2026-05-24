<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modeldokter;
use App\Models\UserModel;

class Dokter extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Modeldokter();
    }

    private function authCheck()
    {
        if (!session()->get('logged_in') || session()->get('id_level') != 1) {
            return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.');
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

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idDokter = $this->model->generateID();

            $dataDokter = [
                'id_dokter'    => $idDokter,
                'nama'         => $this->request->getPost('nama_dokter'),
                'spesialisasi' => $this->request->getPost('spesialisasi'),
                'alamat'       => $this->request->getPost('alamat'),
                'no_telp'      => $this->request->getPost('no_telp'),
                'email'        => $this->request->getPost('email'),
                'sip_str'      => $this->request->getPost('sip_str'),
                'status_aktif' => $this->request->getPost('status_aktif') ?: 'aktif',
                'hari_praktek' => $this->request->getPost('hari_praktek'),
                'jam_praktek'  => $this->request->getPost('jam_praktek'),
            ];

            $this->model->insert($dataDokter);

            // Check if create login account is requested
            if ($this->request->getPost('buat_akun') == '1') {
                $userModel = new UserModel();
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                // Validate username
                $existing = $userModel->where('username', $username)->first();
                if ($existing) {
                    $db->transRollback();
                    session()->setFlashdata('error', 'Username sudah digunakan oleh akun lain!');
                    return redirect()->back()->withInput();
                }

                $userModel->insert([
                    'username'     => $username,
                    'password'     => password_hash($password, PASSWORD_DEFAULT),
                    'id_level'     => 3, // Dokter
                    'id_referensi' => $idDokter,
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menyimpan data dokter.');
                return redirect()->back()->withInput();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Data dokter berhasil ditambahkan.');
                return redirect()->to('/dokter');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;

        $userModel = new UserModel();
        $account = $userModel->where('id_referensi', $id)->where('id_level', 3)->first();

        $data = [
            'title'       => 'Edit Dokter',
            'dokter'      => $this->model->find($id),
            'has_account' => !empty($account),
            'account'     => $account,
        ];
        return view('dokter/v_edit_dokter', $data);
    }

    public function update($id)
    {
        if ($r = $this->authCheck()) return $r;

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $dataDokter = [
                'nama'         => $this->request->getPost('nama_dokter'),
                'spesialisasi' => $this->request->getPost('spesialisasi'),
                'alamat'       => $this->request->getPost('alamat'),
                'no_telp'      => $this->request->getPost('no_telp'),
                'email'        => $this->request->getPost('email'),
                'sip_str'      => $this->request->getPost('sip_str'),
                'status_aktif' => $this->request->getPost('status_aktif') ?: 'aktif',
                'hari_praktek' => $this->request->getPost('hari_praktek'),
                'jam_praktek'  => $this->request->getPost('jam_praktek'),
            ];

            $this->model->update($id, $dataDokter);

            // Check if create login account is requested (and they don't already have one)
            $userModel = new UserModel();
            $account = $userModel->where('id_referensi', $id)->where('id_level', 3)->first();

            if (!$account && $this->request->getPost('buat_akun') == '1') {
                $username = $this->request->getPost('username');
                $password = $this->request->getPost('password');

                // Validate username
                $existing = $userModel->where('username', $username)->first();
                if ($existing) {
                    $db->transRollback();
                    session()->setFlashdata('error', 'Username sudah digunakan oleh akun lain!');
                    return redirect()->back()->withInput();
                }

                $userModel->insert([
                    'username'     => $username,
                    'password'     => password_hash($password, PASSWORD_DEFAULT),
                    'id_level'     => 3, // Dokter
                    'id_referensi' => $id,
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal memperbarui data dokter.');
                return redirect()->back();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Data dokter berhasil diperbarui.');
                return redirect()->to('/dokter');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function hapus($id)
    {
        if ($r = $this->authCheck()) return $r;

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $this->model->delete($id);
            // Delete associated user
            $userModel = new UserModel();
            $userModel->where('id_referensi', $id)->where('id_level', 3)->delete();

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menghapus data dokter.');
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Data dokter berhasil dihapus.');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to('/dokter');
    }

    public function resetFoto($id)
    {
        if ($r = $this->authCheck()) return $r;

        $dokter = $this->model->find($id);
        if ($dokter) {
            // Delete actual file
            if (!empty($dokter['foto'])) {
                $filePath = ROOTPATH . 'public/uploads/profile/' . $dokter['foto'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            $this->model->update($id, [
                'foto'            => null,
                'foto_updated_at' => null
            ]);
            session()->setFlashdata('success', 'Foto profil dokter berhasil di-reset.');
        } else {
            session()->setFlashdata('error', 'Dokter tidak ditemukan.');
        }

        return redirect()->to('/dokter/edit/' . $id);
    }
}
