<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
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
                session()->set(['id_user' => $user['id_user'], 'username' => $user['username'], 'id_level'=> $user['id_level'], 'login' => true]);
                return redirect()->to('/dashboard');
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