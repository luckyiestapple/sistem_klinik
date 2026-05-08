<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLevel extends Model
{
    protected $table         = 'tb_level';
    protected $primaryKey    = 'id_level';
    protected $useAutoIncrement = true;
    protected $returnType    = 'array';
    protected $allowedFields = ['nama_level'];
}
