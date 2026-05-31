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

        // Validation for Username
        if (strlen($username) < 5) {
            session()->setFlashdata('error', 'Username harus minimal 5 karakter!');
            return redirect()->to(base_url('login'));
        }

        // Validation for Password
        if (empty($password)) {
            session()->setFlashdata('error', 'Password wajib diisi!');
            return redirect()->to(base_url('login'));
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && md5($password) === $user['password']) {
            session()->set([
                'id_user'   => $user['id_user'], 
                'username'  => $user['username'], 
                'id_level'  => $user['id_level'], 
                'id_referensi' => $user['id_referensi'],
                'logged_in' => true,
                'login'     => true
            ]);

            // Asumsi Level: 1 = Admin, 2 = Pasien, 3 = Pegawai, 4 = Dokter
            // Asumsi Level: 1 = Admin, 2 = Pasien, 4 = Dokter
            $id_level = $user['id_level'];
            if ($id_level == 1) {
                return redirect()->to(base_url('dashboard'));
            } elseif ($id_level == 2) {
                return redirect()->to(base_url('dashboard_pasien'));
            } elseif ($id_level == 3) {
                return redirect()->to(base_url('dashboard_dokter'));
            } else {
                return redirect()->to(base_url('login'))->with('error', 'Akses ditolak.'); // fallback
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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validation for Username
        if (strlen($username) < 5) {
            session()->setFlashdata('error', 'Username harus minimal 5 karakter!');
            return redirect()->to(base_url('register'))->withInput();
        }

        // Validation for Password
        if (strlen($password) < 6 || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
            session()->setFlashdata('error', 'Password minimal 6 karakter, mengandung angka, dan simbol unik!');
            return redirect()->to(base_url('register'))->withInput();
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // 1. Simpan Data Pasien
            $modelPasien = new \App\Models\Modelpasien();
            $idPasien = $modelPasien->generateID();

            $isBpjs = $this->request->getPost('is_bpjs') === 'Ya';
            $dataPasien = [
                'id_pasien' => $idPasien,
                'nama'      => $this->request->getPost('nama'),
                'jk'        => ($this->request->getPost('jk') == 'Laki-laki' || $this->request->getPost('jk') == 'L') ? 'L' : 'P',
                'tgl_lahir' => $this->request->getPost('tgl_lahir'),
                'no_telp'   => $this->request->getPost('no_telp'),
                'alamat'    => $this->request->getPost('alamat'),
                'no_bpjs'   => $isBpjs ? $this->request->getPost('no_bpjs') : null,
                'status_bpjs' => $isBpjs ? $this->request->getPost('status_bpjs') : null,
                'faskes'    => $isBpjs ? $this->request->getPost('faskes') : null,
                'kelas_rawat' => $isBpjs ? $this->request->getPost('kelas_rawat') : null,
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
                'password'      => md5($this->request->getPost('password')),
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

    public function lupaPassword()
    {
        return view('auth/lupa_password');
    }

    public function processLupaPassword()
    {
        $username = $this->request->getPost('username');
        $no_telp = $this->request->getPost('no_telp');
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        $password = $this->request->getPost('password');
        $confirm_password = $this->request->getPost('confirm_password');

        if (empty($username) || empty($no_telp) || empty($tgl_lahir) || empty($password)) {
            session()->setFlashdata('error', 'Semua kolom wajib diisi!');
            return redirect()->to(base_url('lupa_password'));
        }

        if (strlen($password) < 6 || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
            session()->setFlashdata('error', 'Password minimal 6 karakter, mengandung angka, dan simbol unik!');
            return redirect()->to(base_url('lupa_password'));
        }

        if ($password !== $confirm_password) {
            session()->setFlashdata('error', 'Konfirmasi password baru tidak cocok!');
            return redirect()->to(base_url('lupa_password'));
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->where('id_level', 2)->first();

        if (!$user) {
            session()->setFlashdata('error', 'Data verifikasi salah atau Username tidak terdaftar sebagai Pasien!');
            return redirect()->to(base_url('lupa_password'));
        }

        $pasienModel = new \App\Models\Modelpasien();
        $pasien = $pasienModel->find($user['id_referensi']);

        if (!$pasien || $pasien['no_telp'] !== $no_telp || $pasien['tgl_lahir'] !== $tgl_lahir) {
            session()->setFlashdata('error', 'Data verifikasi (Nomor Telepon atau Tanggal Lahir) salah!');
            return redirect()->to(base_url('lupa_password'));
        }

        // Update Password
        $userModel->update($user['id_user'], [
            'password' => md5($password)
        ]);

        session()->setFlashdata('success', 'Password berhasil diubah! Silakan login dengan password baru.');
        return redirect()->to(base_url('login'));
    }
}