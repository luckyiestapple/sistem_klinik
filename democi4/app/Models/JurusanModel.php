<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table            = 'tbjur';
    protected $primaryKey       = 'kode_jur';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useAutoIncrement = false;    
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_jur', 'jurusan'];
}
