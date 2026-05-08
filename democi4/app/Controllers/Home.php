<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn') == true && session() -> get('username') != ''){
            return view('template/konten');
        } else {
            return redirect()->to(base_url('/login'));
        }
    }

    public function login()
    {
        return view('login');
    }

    public function ceklogin()
    {
        $username = $this->request->getVar('username');
        $password = md5 ($this->request->getVar('password'));

        $userModel = new UserModel();

        $user = $userModel->where('username', $username)->first();

    if($user !== null) {
        if($username === $user['username'] && $password === $user['password']){
            session()->set([
                'isLoggedIn' => true,
                'nama' => $user['nama'],
                'username' => $username
            ]);
            return redirect()->to(base_url());
        } else {
              $this->session->setflashdata('pesan','<div class="alert alert-danger text-center"> <h3>Username/Password Salah!</h3></div>');
            return redirect()->to(base_url('login'));
        }
          } else {
              $this->session->setflashdata('pesan','<div class="alert alert-danger text-center"> <h3>Username/Password Salah!</h3></div>');
            return redirect()->to(base_url('login'));
        }
    }

   public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/login'));
    }
}