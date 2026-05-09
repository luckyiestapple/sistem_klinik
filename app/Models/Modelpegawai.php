<?php
namespace App\Models;
use CodeIgniter\Model;

class Modelpegawai extends Model
{
    protected $table            = 'tb_pegawai';
    protected $primaryKey       = 'id_pegawai';
    protected $allowedFields    = ['nama', 'alamat', 'jk'];
    protected $returnType       = 'array';
}
