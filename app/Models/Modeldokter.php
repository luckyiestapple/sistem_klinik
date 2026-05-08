<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeldokter extends Model
{
    protected $table            = 'tb_dokter';
    protected $primaryKey       = 'id_dokter';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_dokter', 'spesialisasi', 'no_telp', 'alamat'];
}