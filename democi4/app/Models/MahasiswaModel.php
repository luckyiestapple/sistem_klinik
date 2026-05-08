<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'tbmhs';
    protected $primaryKey       = 'nim';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useAutoIncrement = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nim', 'nama', 'alamat', 'jk', 'kode_prodi', 'kode_jur'];
}
