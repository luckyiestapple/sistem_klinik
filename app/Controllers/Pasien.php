<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelpasien;
use App\Models\UserModel;

class Pasien extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new Modelpasien();
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

        $keyword = $this->request->getGet('keyword');
        if (!empty($keyword)) {
            $pasien = $this->model->like('nama', $keyword)
                                  ->orLike('id_pasien', $keyword)
                                  ->findAll();
        } else {
            $pasien = $this->model->findAll();
        }

        $data = [
            'title'      => 'Data Pasien',
            'breadcrumb' => 'Pasien',
            'pasien'     => $pasien,
            'keyword'    => $keyword,
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

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idPasien = $this->model->generateID();

            $dataPasien = [
                'id_pasien'           => $idPasien,
                'nama'                => $this->request->getPost('nama_pasien'),
                'jk'                  => $this->request->getPost('jenis_kelamin'),
                'tgl_lahir'           => $this->request->getPost('tanggal_lahir'),
                'no_telp'             => $this->request->getPost('no_telp'),
                'alamat'              => $this->request->getPost('alamat'),
                'no_bpjs'             => $this->request->getPost('no_bpjs') ?: null,
                'status_bpjs'         => $this->request->getPost('status_bpjs') ?: 'Tidak Aktif',
                'faskes'              => $this->request->getPost('faskes') ?: null,
                'kelas_rawat'         => $this->request->getPost('kelas_rawat') ?: null,
         ];

            $this->model->insert($dataPasien);

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
                    'id_level'     => 2, // Pasien
                    'id_referensi' => $idPasien,
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal mendaftar pasien.');
                return redirect()->back()->withInput();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Pasien berhasil didaftarkan.');
                return redirect()->to('/pasien');
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

        $pasien = $this->model->find($id);
        $userModel = new UserModel();
        $account = $userModel->where('id_referensi', $id)->where('id_level', 2)->first();

        $data = [
            'title'       => 'Edit Pasien',
            'pasien'      => $pasien,
            'has_account' => !empty($account),
            'account'     => $account,
        ];
        return view('pasien/v_edit_pasien', $data);
    }

    public function update($id)
    {
        if ($r = $this->authCheck()) return $r;

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $dataPasien = [
                'nama'                => $this->request->getPost('nama_pasien'),
                'jk'                  => $this->request->getPost('jenis_kelamin'),
                'tgl_lahir'           => $this->request->getPost('tanggal_lahir'),
                'no_telp'             => $this->request->getPost('no_telp'),
                'alamat'              => $this->request->getPost('alamat'),
                'no_bpjs'             => $this->request->getPost('no_bpjs') ?: null,
                'status_bpjs'         => $this->request->getPost('status_bpjs') ?: 'Tidak Aktif',
                'faskes'              => $this->request->getPost('faskes') ?: null,
                'kelas_rawat'         => $this->request->getPost('kelas_rawat') ?: null,
                'gol_darah'           => $this->request->getPost('gol_darah'),
                'alergi_obat'         => $this->request->getPost('alergi_obat'),
                'riwayat_penyakit'    => $this->request->getPost('riwayat_penyakit'),
                'kontak_darurat_nama' => $this->request->getPost('kontak_darurat_nama'),
                'kontak_darurat_telp' => $this->request->getPost('kontak_darurat_telp'),
            ];

            $this->model->update($id, $dataPasien);

            // Check if creating login account is requested (and they don't already have one)
            $userModel = new UserModel();
            $account = $userModel->where('id_referensi', $id)->where('id_level', 2)->first();

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
                    'id_level'     => 2, // Pasien
                    'id_referensi' => $id,
                ]);
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal memperbarui data pasien.');
                return redirect()->back();
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Data pasien berhasil diperbarui.');
                return redirect()->to('/pasien');
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
            $userModel->where('id_referensi', $id)->where('id_level', 2)->delete();

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal menghapus data pasien.');
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Data pasien berhasil dihapus.');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Error: ' . $e->getMessage());
        }

        return redirect()->to('/pasien');
    }

    public function resetFoto($id)
    {
        if ($r = $this->authCheck()) return $r;

        $pasien = $this->model->find($id);
        if ($pasien) {
            // Delete actual file
            if (!empty($pasien['foto'])) {
                $filePath = ROOTPATH . 'public/uploads/profile/' . $pasien['foto'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            $this->model->update($id, [
                'foto'            => null,
                'foto_updated_at' => null
            ]);
            session()->setFlashdata('success', 'Foto profil pasien berhasil di-reset.');
        } else {
            session()->setFlashdata('error', 'Pasien tidak ditemukan.');
        }

        return redirect()->to('/pasien/edit/' . $id);
    }
}
