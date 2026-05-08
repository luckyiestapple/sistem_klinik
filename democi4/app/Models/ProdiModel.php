<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table            = 'tbprodi';
    protected $primaryKey       = 'kode_prodi';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $useAutoIncrement = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_prodi', 'kode_jur', 'prodi'];
}
