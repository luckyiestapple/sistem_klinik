<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelpasien extends Model
{
    protected $table            = 'tb_pasien';
    protected $primaryKey       = 'id_pasien';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_pasien',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_telp',
        'alamat',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}
