<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginPassword extends BaseController
{
    public function index()
    {
        helper(['form', 'validation']);
        return view('login');
    }

    public function loginpw()
    {
        $rules = [
            'fnama' => ['rules' => ['required', 'max_length[100]']],
            'fpassword' => ['rules' => ['required', 'min_length[10]']],
            'fconfirm' => ['rules' => ['required', 'min_length[10]', 'matches[fpassword]']]
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        echo "Login Password";
        echo '<br> Nama :' . $this->request->getVar('fnama');
        echo '<br> Password :' . $this->request->getVar('fpassword');
        echo '<br> Confirm Password :' . $this->request->getVar('fconfirm');
    }
}