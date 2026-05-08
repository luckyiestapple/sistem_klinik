<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    public function index()
    {
        return view('frm_login');
    }

    public function savelogin(){
        $rules =[
            'fusn' => 'required|min_length[10]',
            'fpw' => 'required|min_length[10]',
            'fupw' => 'required|min_length[10]',
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (!$this->validate($rules)){
            return view('frm_login', [
                'validation' => $this->validator
            ]);
        }
        echo 'Login Mahasiswa<br>'; 
        echo '<br>Username : '.$this->request->getVar('fusn');
        echo '<br>Password : **********';
    }

}
