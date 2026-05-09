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
                return redirect()->to('/dashboard');
            } elseif ($id_level == 2) {
                return redirect()->to('/dashboard_pasien');
            } elseif ($id_level == 4) {
                return redirect()->to('/dashboard_dokter');
            } else {
                return redirect()->to('/dashboard'); // fallback
            }
        } else {
            session()->setFlashdata('error', 'Username atau Password salah!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}