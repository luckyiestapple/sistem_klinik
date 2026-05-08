<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

    return view('frm_bio');

        //data disimpan dalam array
        $data=[
            'nama' =>'Dinda',
            'alamat' => 'Medan',
            'nohp' => '0822 8335 3192'
        ];

        $data2=array(
        'nama' => 'ALo',
        'alamat' => 'Yogyakarta',
        'nohp' => '081282731919'
    );

        $data['nama'] = 'Gempal';
        $data['alamat'] = 'Jakarta';
        $data['nohp'] = '08128666742';
        return view('admin/v_demo1', $data);
    }
    public function homepage(){
        return view('demotemplate');
    }

    public function halamandepan(){
        return view('template/header')
        .view('template/sidebar')
        .view('template/content')
        .view('template/footer');
    }

    public function content(){
        return view('template/content');
    }

    public function terimadatamethodpost(){
        echo 'fungsi terima data';
        echo '<br> Nim:'.$_POST['fnim'];
        echo '<br> Nama:'.$_POST['fnama'];
        echo '<br> Alamat:'.$_POST['falamat'];
    }

    public function savelogin(){
        echo '<br> Username:'.$this->request->getVar('fusn');
        echo '<br> Password:'.$this->request->getVar('fpw');
        echo '<br> Ulangi Password:'.$this->request->getVar('fupw');
    }
}