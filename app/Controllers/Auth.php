<?php
namespace App\Controllers;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'id_user'   => $user['id_user'], 
                'username'  => $user['username'], 
                'id_level'  => $user['id_level'], 
                'id_referensi' => $user['id_referensi'],
                'logged_in' => true,
                'login'     => true
            ]);

            // Asumsi Level: 1 = Admin, 2 = Pasien, 3 = Pegawai, 4 = Dokter
            // Sesuai request: Level 1 dan 3 (Admin dan Pegawai sama aja akses dashboard utama)
            $id_level = $user['id_level'];
            if ($id_level == 1 || $id_level == 3) {
                return redirect()->to(base_url('dashboard'));
            } elseif ($id_level == 2) {
                return redirect()->to(base_url('dashboard_pasien'));
            } elseif ($id_level == 4) {
                return redirect()->to(base_url('dashboard_dokter'));
            } else {
                return redirect()->to(base_url('dashboard')); // fallback
            }
        } else {
            session()->setFlashdata('error', 'Username atau Password salah!');
            return redirect()->to(base_url('login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Simpan Data Pasien
            $modelPasien = new \App\Models\Modelpasien();
            $idPasien = $modelPasien->generateID();

            $dataPasien = [
                'id_pasien' => $idPasien,
                'nama'      => $this->request->getPost('nama'),
                'jk'        => $this->request->getPost('jk'),
                'tgl_lahir' => $this->request->getPost('tgl_lahir'),
                'no_telp'   => $this->request->getPost('no_telp'),
                'alamat'    => $this->request->getPost('alamat'),
            ];

            $modelPasien->insert($dataPasien);

            // 2. Simpan Data User
            $modelUser = new \App\Models\UserModel();
            
            // Cek apakah username sudah ada
            $cekUser = $modelUser->where('username', $this->request->getPost('username'))->first();
            if ($cekUser) {
                $db->transRollback();
                session()->setFlashdata('error', 'Username sudah digunakan!');
                return redirect()->to(base_url('register'));
            }

            $dataUser = [
                'username'      => $this->request->getPost('username'),
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'id_level'      => 2, // Level Pasien (2)
                'id_referensi'  => $idPasien // Hubungkan ke ID Pasien
            ];

            $modelUser->insert($dataUser);

            if ($db->transStatus() === false) {
                $db->transRollback();
                session()->setFlashdata('error', 'Gagal mendaftar, coba lagi.');
                return redirect()->to(base_url('register'));
            } else {
                $db->transCommit();
                session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
                return redirect()->to(base_url('login'));
            }
        } catch (\Exception $e) {
            $db->transRollback();
            session()->setFlashdata('error', 'Terjadi kesalahan saat registrasi.');
            return redirect()->to(base_url('register'));
        }
    }
}